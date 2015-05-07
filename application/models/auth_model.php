<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Auth_model
 * Model for autentification users
 */
class Auth_model extends MY_Model
{
    const AUTH_ADMIN        = 0;
    const AUTH_USER         = 1;

    public $ci = false;

    function __construct()
    {
        parent::__construct();
        $this->ci->load->language('auth');
        $this->ci = &get_instance();
    }

    /**
     * Check current user login
     * @return bool
     */
    public function is_logged_in()
    {
        return $this->session->userdata('user_is_loggedin') == 1;
    }

    public function checkAccess($role = false)
    {
        $user = $this->ci->getUser();
        if(!$user) return false;
        return $user['role'] == $role;
    }

    /**
     * Logout user
     * @return bool
     */
    function logout()
    {
        if($this->is_logged_in())
        {
            $this->session->unset_userdata(array(
                'id'                => '',
                'user_is_loggedin'  => '',
            ));
        }
        redirect('auth/login');
    }

    public function login($identity = '', $password = '', $remember=FALSE)
    {
        try
        {
            if(empty($identity) || empty($password)) return false;

            $cookiehash = get_cookie('uhash');
            if($cookiehash)
            {
                $user = $this->db->query("SELECT * FROM `user` WHERE `remember_code` = '".$cookiehash."' LIMIT 1")->row_array();
                if($user)
                {
                    $this->session->set_userdata(array(
                        'id'                => $user['id'],
                        'user_is_loggedin'  => 1,
                    ));

                    $this->ci->setUser($user);
                    return true;
                }
                else
                    return false;
            }

            $user =  $this->db->query("SELECT * FROM `user` WHERE `email` = '".$identity."' LIMIT 1")->row_array();
            if($user)
            {
                if(get_double_hash($password) !== $user['password'])
                    return false;
                else
                {
                    $this->session->set_userdata(array(
                        'id'                => $user['id'],
                        'user_is_loggedin'  => 1,
                    ));

                    if($remember)
                    {
                        $this->auth_remember_me($user);
                    }
                    $this->ci->setUser($user);
                    return true;
                }
            }
            else
                return false;
        }
        catch(Exception $e)
        {
            log_message('error', $e);
        }
        return false;
    }

    /**
     * Remember user identity
     * @return bool
     */
    function auth_remember_me($user)
    {
        if(!is_array($user) && !empty($user)) return false;

        $cookiehash = get_double_hash($user['id'] . time());
        set_cookie(array(
            'name'   => 'uhash',
            'value'  => $cookiehash,
            'expire' => 3600 * 24 * 365,
        ));

        return $this->db->update('user', array(
            'remember_code' => $cookiehash,
        ), array('id' => $user['id']));

    }
}