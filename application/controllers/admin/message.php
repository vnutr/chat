<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Message
 * Message Controller
 */
class Message extends Base_Backend_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Message_model');
    }

    function index()
    {

    }

    function create()
    {
        if(isset($_POST['room_id']))
        {
            if($this->Message_model->create(array(
                'room_id' => $_POST['room_id'],
                'text' => $_POST['text'],
                'from_id' => $this->getUser()['id'],
                'date' => time()
            )))
            {
                $messages = $this->db
                    ->select('message.*, user.first_name, user.last_name')
                    ->from('message')
                    ->join('user', 'user.id = message.from_id')
                    ->where(array('message.room_id' => $_POST['room_id']))
                    ->order_by('message.date', 'desc')
                    ->get()->result_array();
                echo json_encode(array(
                    'status' => true,
                    'html_rows' => $this->load->view('backend/message/rows', array('messages' => $messages), TRUE),
                ));
            }
        }
        die();
    }

    function by_room()
    {
        if(isset($_POST['room_id']))
        {
            $messages = $this->db
                ->select('message.*, user.first_name, user.last_name')
                ->from('message')
                ->join('user', 'user.id = message.from_id')
                ->where(array('message.room_id' => $_POST['room_id']))
                ->order_by('message.date', 'desc')
                ->get()->result_array();
            echo json_encode(array(
                'status' => true,
                'html_rows' => $this->load->view('backend/message/rows', array('messages' => $messages), TRUE),
            ));
        }
        die();
    }

    function delete()
    {
        if(isset($_POST['room_id']) && isset($_POST['id']))
        {

            if($this->Message_model->delete($_POST['id']))
            {
                $messages = $this->db
                    ->select('message.*, user.first_name, user.last_name')
                    ->from('message')
                    ->join('user', 'user.id = message.from_id')
                    ->where(array('message.room_id' => $_POST['room_id']))
                    ->order_by('message.date', 'desc')
                    ->get()->result_array();
                echo json_encode(array(
                    'status' => true,
                    'html_rows' => $this->load->view('backend/message/rows', array('messages' => $messages), TRUE),
                ));
            }
        }
        die();
    }
}