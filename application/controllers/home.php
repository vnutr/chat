<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Home
 * Home Controller
 */
class Home extends Base_Frontend_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $data = array();
        $user = $this->getUser();
        $data['errors'] = array();
        $data['users'] = $this->db->select('*')->from('user')->where("id <> {$user['id']}")->get()->result_array();
        $this->_js_variables = array(
            'chat_type' => 'private',
            'chat_id'        => !empty($data['users'])? $data['users'][0]['id']: 0,
        );
        $data['rooms'] = $this->db->select('*')->from('room')->get()->result_array();
        $this->page_name = lang('home_page_name');

        $this->layout('home/index', $data);
    }


}