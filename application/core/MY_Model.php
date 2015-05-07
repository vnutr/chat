<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class MY_Model
 * Base model for all model
 */
class MY_Model extends CI_Model
{
    /**
     * db table name
     * @var string
     */
    public $_table_name           = '';

    /**
     * title of model
     * @var string
     */
    public $_model_name              = '';

    /**
     * Rules for model validation
     * format:
     * array(
     *      'field' => 'name_field',
     *      'label' => 'name_label_of_field',
     *      'rules' => 'rules (for example: required|min_length|max_length|numeric|alpha //  etc.)'
     * )
     * @var array
     */
    protected $_rules                = array();

    /**
     * app instance
     * @var
     */
    public $ci;

    /**
     * Error of model
     * @var array
     */
    private $errors = array();

    public function get_rules($array_prefix)
    {
        $return = array();
        foreach($this->_rules as $rule)
        {
            $return[] = array(
                'field' => $array_prefix .'['.$rule['field']. ']',
                'label' => $rule['label'],
                'rules' => $rule['rules'],
            );
        }
        return $return;
    }

    function __construct()
    {
        parent::__construct();
        $this->ci = &get_instance();
    }

    /**
     * Insert model in db
     * @return bool
     */
    public function insert($data = array(), $is_validate = true)
    {
        try
        {
            if(empty($data)) return false;
            if(!$is_validate){
                if($this->db->simple_query($this->db->insert_string($this->_table_name, $data)))
                    return $this->db->insert_id();
                else
                    return false;
            }
            else
            {
                $this->ci->load->library('form_validation');
                for($i=0;$i<count($this->_rules); $i++)
                    $this->_rules[$i]['field'] = "{$this->_model_name}[{$this->_rules[$i]['field']}]";
                $this->ci->form_validation->set_rules($this->_rules);
                if($this->ci->form_validation->run())
                {
                    if($this->db->simple_query($this->db->insert_string($this->_table_name, $data)))
                        return $this->db->insert_id();
                    else {
                        $this->errors[] = $this->db->_error_message();
                        return false;
                    }
                }
                else
                {
                    $this->errors = $this->ci->form_validation->get_error_array();
                    return false;
                }
            }

        }
        catch(Exception $e)
        {
            log_message('error', $e->getMessage());
        }
        return false;
    }

    /**
     * Get errors
     * @return array
     */
    public function get_errors()
    {
        return $this->errors;
    }

    /**
     * Check validation
     * @param $data
     * @return bool
     */
    public function valid($data)
    {
        $this->ci->load->library('form_validation');
        for($i=0;$i<count($this->_rules); $i++)
            $this->_rules[$i]['field'] = "{$this->_model_name}[{$this->_rules[$i]['field']}]";
        $this->ci->form_validation->set_rules($this->_rules);
        if($this->ci->form_validation->run())
        {
            return true;
        }
        else
        {
            $this->errors = $this->ci->form_validation->get_error_array();
            return false;
        }
    }

    /**
     * Update model record in db
     *@return bool
     */
    public function update($id, $data = array(), $is_validate = true)
    {
        try
        {
            $where = "id = $id";
            if(!$is_validate)
            {
                return $this->db->simple_query($this->db->update_string($this->_table_name, $data, $where));
            }
            else
            {
                $this->ci->load->library('form_validation');
                for($i=0;$i<count($this->_rules); $i++)
                    $this->_rules[$i]['field'] = "{$this->_model_name}[{$this->_rules[$i]['field']}]";
                $this->ci->form_validation->set_rules($this->_rules);
                if($this->ci->form_validation->run())
                {
                    if($this->db->simple_query($this->db->update_string($this->_table_name, $data, $where)))
                        return true;
                    else {
                        $this->errors[] = $this->db->_error_message();
                        return false;
                    }
                }
                else
                {
                    $this->errors = $this->ci->form_validation->get_error_array();
                    return false;
                }
            }
            return false;
        }
        catch(Exception $e)
        {
            log_message('error', $e->getMessage());
            return false;
        }
    }

}