<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Auth
 * Auth Controller
 */
class Auth extends Base_Frontend_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $this->login();
    }

    function login()
    {
        $errors = array();
        $this->page_name = lang('auth_page_name');

        if($identity = $this->input->post('Login'))
        {
            if($this->Auth_model->login($identity['email'], $identity['password'], isset($identity['rememberMe'])))
            {
                if($this->Auth_model->checkAccess(Auth_model::AUTH_ADMIN))
                    redirect('admin/room/index');
                else
                    redirect('home/index');
            }
            else
                $errors['Login'] = lang('auth_login_error');
        }

        $this->load->view('auth/login', array(
            'errors' => $errors,
            'base' => $this
        ));
    }

    function logout()
    {
        $this->Auth_model->logout();
    }
}