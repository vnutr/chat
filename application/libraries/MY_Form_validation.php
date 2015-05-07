<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class MY_Form_validation
 * Extended validation form class
 */
class MY_Form_validation extends CI_Form_validation
{
    private $_data = NULL;
    function __construct()
    {
        parent::__construct();
        $this->CI->load->language('my_form_validation');
    }

    /**
     * get all errors as associative array
     * @return array
     */
    function get_error_array()
    {
        return $this->_error_array;
    }

    /**
     * Check valid slug
     * @param $str
     * @return int
     */
    public function uniqueSlug($slug, $t, $field)
    {
        if(isset($_POST['Page']['id']) && !empty($_POST['Page']['id']))
        {
            $ci = &get_instance();
            $res = $ci->db->select('*')->from('page')->where("slug = '{$slug}' and id <> {$_POST['Page']['id']}")->count_all_results();
            if($res > 0)
            {
                $this->_error_array['Page[title]'] = lang('valid_unique_slug');
                $this->_error_messages = lang('valid_unique_slug');
                return FALSE;
            }
        }
        return TRUE;
    }

    /**
     * Check regexp
     * @param $str
     * @param $regex
     * @return bool
     */
    function regex($str, $regex, $field)
    {
        if ( ! preg_match($regex, $str))
        {
            $this->_error_array[$field] = sprintf(lang('valid_regex'), $field);
            $this->_error_messages = sprintf(lang('valid_regex'), $field);
            return FALSE;
        }

        return  TRUE;
    }

    /**
     * Check unique email
     * @param $str
     * @return int
     */
    public function uniqueEmail($email, $t, $field)
    {
        $ci = &get_instance();
        if(isset($_POST['User']['id']) && !empty($_POST['User']['id']))
        {
            $res = $ci->db->select('*')->from('user')->where(array('email' => $email, 'id <>'=> $_POST['User']['id']))->count_all_results();
            if($res > 0)
            {
                $this->_error_array['User[email]'] = lang('valid_email_uniq');
                $this->_error_messages = lang('valid_email_uniq');
                return FALSE;
            }
        }else{
            $res = $ci->db->select('*')->from('user')->where(array('email' => $email))->count_all_results();
            if($res > 0)
            {
                $this->_error_array['User[email]'] = lang('valid_email_uniq');
                $this->_error_messages = lang('valid_email_uniq');
                return FALSE;
            }
        }
        return TRUE;
    }

    /**
     * Check color
     * @param $str
     * @return int
     */
    public function color($str, $t, $field)
    {
        if(!empty($str))
        {

            if(preg_match ('/^#([0-9A-Fa-f]{3}|[0-9A-Fa-f]{6})$/', $str)==0)
            {
                $this->_error_array[$field] = lang('valid_color');
                $this->_error_messages = lang('valid_color');
                return FALSE;
            }
        }
        return TRUE;
    }

    /**
     * Check enum
     * @param $str
     * @return int
     */
    public function enum($str, $val='', $field)
    {
        if(!empty($str))
        {
            $arr = explode(',', $val);
            $array = array();
            foreach($arr as $value)
                $array[] = trim($value);
            if(!in_array(trim($str), $array))
            {
                $this->_error_array[$field] = lang('valid_enum');
                $this->_error_messages = lang('valid_enum');
                return FALSE;
            }
        }
        return TRUE;
    }

    /**
     * Check valid date
     * @param $str
     * @return int
     */
    public function matchPass($str, $t, $field)
    {
        if(isset($_POST['passconf']))
        {
            if($str != get_double_hash($_POST['passconf']))
            {
                $this->_error_array[$field] = lang('valid_match_pass');
                $this->_error_messages = lang('valid_match_pass');
                return FALSE;
            }
        }
        return TRUE;
    }

    /**
     * Executes the Validation routines
     *
     * @access	private
     * @param	array
     * @param	array
     * @param	mixed
     * @param	integer
     * @return	mixed
     */
    protected function _execute($row, $rules, $postdata = NULL, $cycles = 0)
    {
        // If the $_POST data is an array we will run a recursive call
        if (is_array($postdata))
        {
            foreach ($postdata as $key => $val)
            {
                $this->_execute($row, $rules, $val, $cycles);
                $cycles++;
            }

            return;
        }

        // --------------------------------------------------------------------

        // If the field is blank, but NOT required, no further tests are necessary
        $callback = FALSE;
        if ( ! in_array('required', $rules) AND is_null($postdata))
        {
            // Before we bail out, does the rule contain a callback?
            if (preg_match("/(callback_\w+(\[.*?\])?)/", implode(' ', $rules), $match))
            {
                $callback = TRUE;
                $rules = (array('1' => $match[1]));
            }
            else
            {
                return;
            }
        }

        // --------------------------------------------------------------------

        // Isset Test. Typically this rule will only apply to checkboxes.
        if (is_null($postdata) AND $callback == FALSE)
        {
            if (in_array('isset', $rules, TRUE) OR in_array('required', $rules))
            {
                // Set the message type
                $type = (in_array('required', $rules)) ? 'required' : 'isset';

                if ( ! isset($this->_error_messages[$type]))
                {
                    if (FALSE === ($line = $this->CI->lang->line($type)))
                    {
                        $line = 'The field was not set';
                    }
                }
                else
                {
                    $line = $this->_error_messages[$type];
                }

                // Build the error message
                $message = sprintf($line, $this->_translate_fieldname($row['label']));

                // Save the error message
                $this->_field_data[$row['field']]['error'] = $message;

                if ( ! isset($this->_error_array[$row['field']]))
                {
                    $this->_error_array[$row['field']] = $message;
                }
            }

            return;
        }

        // --------------------------------------------------------------------

        // Cycle through each rule and run it
        foreach ($rules As $rule)
        {
            $_in_array = FALSE;

            // We set the $postdata variable with the current data in our master array so that
            // each cycle of the loop is dealing with the processed data from the last cycle
            if ($row['is_array'] == TRUE AND is_array($this->_field_data[$row['field']]['postdata']))
            {
                // We shouldn't need this safety, but just in case there isn't an array index
                // associated with this cycle we'll bail out
                if ( ! isset($this->_field_data[$row['field']]['postdata'][$cycles]))
                {
                    continue;
                }

                $postdata = $this->_field_data[$row['field']]['postdata'][$cycles];
                $_in_array = TRUE;
            }
            else
            {
                $postdata = $this->_field_data[$row['field']]['postdata'];
            }

            // --------------------------------------------------------------------

            // Is the rule a callback?
            $callback = FALSE;
            if (substr($rule, 0, 9) == 'callback_')
            {
                $rule = substr($rule, 9);
                $callback = TRUE;
            }

            // Strip the parameter (if exists) from the rule
            // Rules can contain a parameter: max_length[5]
            $param = FALSE;
            if (preg_match("/(.*?)\[(.*)\]/", $rule, $match))
            {
                $rule	= $match[1];
                $param	= $match[2];
            }

            // Call the function that corresponds to the rule
            if ($callback === TRUE)
            {
                if ( ! method_exists($this->CI, $rule))
                {
                    continue;
                }

                // Run the function and grab the result
                $result = $this->CI->$rule($postdata, $param);

                // Re-assign the result to the master data array
                if ($_in_array == TRUE)
                {
                    $this->_field_data[$row['field']]['postdata'][$cycles] = (is_bool($result)) ? $postdata : $result;
                }
                else
                {
                    $this->_field_data[$row['field']]['postdata'] = (is_bool($result)) ? $postdata : $result;
                }

                // If the field isn't required and we just processed a callback we'll move on...
                if ( ! in_array('required', $rules, TRUE) AND $result !== FALSE)
                {
                    continue;
                }
            }
            else
            {
                if ( ! method_exists($this, $rule))
                {
                    // If our own wrapper function doesn't exist we see if a native PHP function does.
                    // Users can use any native PHP function call that has one param.
                    if (function_exists($rule))
                    {
                        $result = $rule($postdata);

                        if ($_in_array == TRUE)
                        {
                            $this->_field_data[$row['field']]['postdata'][$cycles] = (is_bool($result)) ? $postdata : $result;
                        }
                        else
                        {
                            $this->_field_data[$row['field']]['postdata'] = (is_bool($result)) ? $postdata : $result;
                        }
                    }
                    else
                    {
                        log_message('debug', "Unable to find validation rule: ".$rule);
                    }

                    continue;
                }

                $result = $this->$rule($postdata, $param, $row['field']);

                if ($_in_array == TRUE)
                {
                    $this->_field_data[$row['field']]['postdata'][$cycles] = (is_bool($result)) ? $postdata : $result;
                }
                else
                {
                    $this->_field_data[$row['field']]['postdata'] = (is_bool($result)) ? $postdata : $result;
                }
            }

            // Did the rule test negatively?  If so, grab the error.
            if ($result === FALSE)
            {
                if ( ! isset($this->_error_messages[$rule]))
                {
                    if (FALSE === ($line = $this->CI->lang->line($rule)))
                    {
                        $line = 'Unable to access an error message corresponding to your field name.';
                    }
                }
                else
                {
                    $line = $this->_error_messages[$rule];
                }

                // Is the parameter we are inserting into the error message the name
                // of another field?  If so we need to grab its "field label"
                if (isset($this->_field_data[$param]) AND isset($this->_field_data[$param]['label']))
                {
                    $param = $this->_translate_fieldname($this->_field_data[$param]['label']);
                }

                // Build the error message
                $message = sprintf($line, $this->_translate_fieldname($row['label']), $param);

                // Save the error message
                $this->_field_data[$row['field']]['error'] = $message;

                if ( ! isset($this->_error_array[$row['field']]))
                {
                    $this->_error_array[$row['field']] = $message;
                }

                return;
            }
        }
    }

    /**
     * Run the Validator
     *
     * This function does all the work.
     *
     * @access	public
     * @return	bool
     */
    public function run($group = '')
    {
        // Do we even have any data to process?  Mm?
        if (count($_POST) == 0)
        {
            return FALSE;
        }

        // Does the _field_data array containing the validation rules exist?
        // If not, we look to see if they were assigned via a config file
        if (count($this->_field_data) == 0)
        {
            // No validation rules?  We're done...
            if (count($this->_config_rules) == 0)
            {
                return FALSE;
            }

            // Is there a validation rule for the particular URI being accessed?
            $uri = ($group == '') ? trim($this->CI->uri->ruri_string(), '/') : $group;

            if ($uri != '' AND isset($this->_config_rules[$uri]))
            {
                $this->set_rules($this->_config_rules[$uri]);
            }
            else
            {
                $this->set_rules($this->_config_rules);
            }

            // We're we able to set the rules correctly?
            if (count($this->_field_data) == 0)
            {
                log_message('debug', "Unable to find validation rules");
                return FALSE;
            }
        }

        // Load the language file containing error messages
        $this->CI->lang->load('form_validation');

        // Cycle through the rules for each field, match the
        // corresponding $_POST item and test for errors
        foreach ($this->_field_data as $field => $row)
        {
            // Fetch the data from the corresponding $_POST array and cache it in the _field_data array.
            // Depending on whether the field name is an array or a string will determine where we get it from.

            if ($row['is_array'] == TRUE)
            {
                $post_name = explode(',', preg_replace('/\[|\]/', ',', $field));
                $this->_field_data[$field]['postdata'] = $this->_reduce_array($_POST, $row['keys']);
            }
            else
            {
                if (isset($_POST[$field]) AND $_POST[$field] != "")
                {
                    $this->_field_data[$field]['postdata'] = $_POST[$field];
                }
            }
            if(isset($post_name[0]) && isset($post_name[1]) && isset($_POST[$post_name[0]][$post_name[1]]))
                $this->_execute($row, explode('|', $row['rules']), $this->_field_data[$field]['postdata']);
        }

        // Did we end up with any errors?
        $total_errors = count($this->_error_array);

        if ($total_errors > 0)
        {
            $this->_safe_form_data = TRUE;
        }

        // Now we need to re-set the POST data with the new, processed data
        $this->_reset_post_array();

        // No errors, validation passes!
        if ($total_errors == 0)
        {
            return TRUE;
        }

        // Validation fails
        return FALSE;
    }

}