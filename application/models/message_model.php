<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Message_model
 * Message model
 */
class Message_model extends MY_Model
{

    function __construct()
    {
        parent::__construct();
        $this->_table_name      = 'message';
        $this->_model_name      = 'Message';
        $this->load->language('message');

        $this->_rules = array(
            array(
                'field'   => 'from_id',
                'label'   => lang('message_db_from_id'),
                'rules'   => 'trim|required|xss_clean'
            ),
            array(
                'field'   => 'date',
                'label'   => lang('message_db_date'),
                'rules'   => 'trim|required|xss_clean'
            ),
            array(
                'field'   => 'text',
                'label'   => lang('message_db_text'),
                'rules'   => 'trim|required|xss_clean'
            ),
        );

    }

    function create($data = array())
    {
        return parent::insert($data);
    }

    function update($id, $data = array())
    {
        $model = $this->db->select('*')->from('message')->where(array('id' => $id))->get()->row_array();
        $ci = &get_instance();
        if($ci->getUser()['id'] != $model['from_id']) return false;
        return parent::update($id, $data);
    }

    function delete($id)
    {
        $model = $this->db->select('*')->from('message')->where(array('id' => $id))->get()->row_array();
        $ci = &get_instance();
        if($ci->getUser()['id'] != $model['from_id']) return false;
        return $this->db->where("id IN ($id)")->delete('message');
    }

}