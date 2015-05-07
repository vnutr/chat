<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Room_model
 * Room model
 */
class Room_model extends MY_Model
{

    function __construct()
    {
        parent::__construct();
        $this->_table_name      = 'room';
        $this->_model_name      = 'Room';
        $this->load->language('room');

        $this->_rules = array(
            array(
                'field'   => 'name',
                'label'   => lang('room_db_name'),
                'rules'   => 'trim|required|xss_clean'
            ),
        );

    }

    function create($data = array())
    {
        $ci = &get_instance();
        if(!$ci->Auth_model->checkAccess(Auth_model::AUTH_ADMIN)) return false;
        return parent::insert($data);
    }

    function update($id, $data = array())
    {
        $ci = &get_instance();
        if(!$ci->Auth_model->checkAccess(Auth_model::AUTH_ADMIN)) return false;
        return parent::update($id, $data);
    }

    function delete($id)
    {
        $ci = &get_instance();
        if(!$ci->Auth_model->checkAccess(Auth_model::AUTH_ADMIN)) return false;
        return $this->db->where("id IN ($id)")->delete('room');
    }

    function has_user($user_id, $user_rooms)
    {
        foreach($user_rooms as $item)
            if($item['user_id'] == $user_id)
                return true;
        return false;
    }

}