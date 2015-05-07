<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Room
 * Room Controller
 */
class Room extends Base_Backend_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Room_model');
    }

    function index()
    {
        $data = array();
        $this->page_name = lang('room_page_name');
        $this->title = lang('room_page_name');
        $data['rooms'] = $this->db->select('*')->from('room')->get()->result_array();
        $this->layout('room/index', $data);
    }

    function delete($id)
    {
        if($this->Room_model->delete($id))
            redirect($_SERVER['HTTP_REFERER']);
    }

    function create()
    {
        $data['errors'] = array();
        $this->page_name = lang('room_page_name_create');

        if(isset($_POST['Room']))
        {

            if($inserted_id = $this->Room_model->create($_POST['Room']))
                redirect(array('admin', 'room', 'update', $inserted_id));
            else
                $data['errors'] = $this->Room_model->get_errors();
        }
        $this->layout('room/create', $data);
    }

    function update($id)
    {
        $user = $this->getUser();
        $data['errors'] = array();
        $this->page_name = lang('room_page_name_update');

        $this->_js_variables = array(
            'room_id' => $id,
        );

        if(isset($_POST['Room']))
        {
            if(!$this->Room_model->update($id, $_POST['Room']))
                $data['errors'] = $this->Room_model->get_errors();
        }

        if(isset($_POST['UserRoom']))
        {
            $data['UserRoom'] = array();
            $this->db->where("user_id IN (".implode(',', $_POST['UserRoom']['user_id']).")")->delete('user_room');
            foreach($_POST['UserRoom']['user_id'] as $user_id)
                $data['UserRoom'][] = array(
                    'user_id' => $user_id,
                    'room_id' => $id,
                );
            $this->db->insert_batch('user_room', $data['UserRoom']);

        }
        $data['room'] = $this->db->select('*')->from('room')->where('id', $id)->get()->row_array();
        $data['users'] = $this->db->select('*')->from('user')->where("id <> {$user['id']}")->get()->result_array();
        $data['user_room'] = $this->db->select('*')->from('user_room')->where(array('room_id' => $id))->get()->result_array();
        $data['messages'] = $this->db
            ->select('message.*, user.first_name, user.last_name')
            ->from('message')
            ->join('user', 'user.id = message.from_id')
            ->where(array('message.room_id' => $id))
            ->order_by('message.date', 'desc')
            ->get()->result_array();
        $this->layout('room/update', $data);
    }
}