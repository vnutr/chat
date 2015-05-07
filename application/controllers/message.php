<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Message
 * Message Controller
 */
class Message extends Base_Frontend_Controller
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
        if(isset($_POST['chat_type']) && isset($_POST['chat_id']) && isset($_POST['text']))
        {
            if($this->Message_model->create(array(
                'room_id' => $_POST['chat_type'] == 'room'? $_POST['chat_id']: NULL,
                'text' => $_POST['text'],
                'from_id' => $this->getUser()['id'],
                'to_id' => $_POST['chat_type'] == 'private'? $_POST['chat_id']: NULL,
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
                    'html_rows' => $this->load->view('frontend/message/rows', array('messages' => $messages, 'current_user' => $this->getUser()), TRUE),
                ));
            }
        }
        die();
    }

    function fetch()
    {
        if(isset($_POST['chat_id']) && isset($_POST['chat_type']))
        {
            $messages = array();
            switch($_POST['chat_type'])
            {
                case "private":
                    $messages = $this->db
                        ->select('message.*, user.first_name, user.last_name')
                        ->from('message')
                        ->join('user', 'user.id = message.from_id')
                        ->where(sprintf('(message.from_id = %s AND message.to_id = %s) OR (message.from_id = %s AND message.to_id = %s)', $_POST['chat_id'], $this->getUser()['id'], $this->getUser()['id'], $_POST['chat_id']))
                        ->order_by('message.date', 'desc')
                        ->get()->result_array();
                    break;
                case "room":
                    $messages = $this->db
                        ->select('message.*, user.first_name, user.last_name')
                        ->from('message')
                        ->join('user', 'user.id = message.from_id')
                        ->where(array('message.room_id' => $_POST['chat_id']))
                        ->order_by('message.date', 'desc')
                        ->get()->result_array();
                    break;
            }

            echo json_encode(array(
                'status' => true,
                'html_rows' => $this->load->view('frontend/message/rows', array('messages' => $messages, 'current_user' => $this->getUser()), TRUE),
            ));
        }
        die();
    }

    function delete()
    {
        if(isset($_POST['message_id']) && isset($_POST['chat_type']) && isset($_POST['chat_id']))
        {

            if($this->Message_model->delete($_POST['message_id']))
            {
                $messages = array();
                switch($_POST['chat_type'])
                {
                    case "private":
                        $messages = $this->db
                            ->select('message.*, user.first_name, user.last_name')
                            ->from('message')
                            ->join('user', 'user.id = message.from_id')
                            ->where(sprintf('(message.from_id = %s AND message.to_id = %s) OR (message.from_id = %s AND message.to_id = %s)', $_POST['chat_id'], $this->getUser()['id'], $this->getUser()['id'], $_POST['chat_id']))
                            ->order_by('message.date', 'desc')
                            ->get()->result_array();
                        break;
                    case "room":
                        $messages = $this->db
                            ->select('message.*, user.first_name, user.last_name')
                            ->from('message')
                            ->join('user', 'user.id = message.from_id')
                            ->where(array('message.room_id' => $_POST['chat_id']))
                            ->order_by('message.date', 'desc')
                            ->get()->result_array();
                        break;
                }

                echo json_encode(array(
                    'status' => true,
                    'html_rows' => $this->load->view('backend/message/rows', array('messages' => $messages), TRUE),
                ));
            }
        }
        die();
    }
}