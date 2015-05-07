<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Base_Frontend_Controller extends Base_Controller
{
    public $header = 'frontend/layout/header';
    public $footer = 'frontend/layout/footer';

    public $main_menu = array();

    function __construct()
    {
        parent::__construct();
        $this->addCSS(array('bootstrap.min.css', 'font-awesome.min.css', 'chosen.css', 'ace.css', 'main.css'));
        $this->addJS(array(
            'jquery-1.11.3.min.js' => self::SCRIPT_HEAD,
            'bootstrap.min.js' => self::SCRIPT_HEAD,
            'chosen.jquery.js' => self::SCRIPT_HEAD,
            'main.js' => self::SCRIPT_FOOTER,
        ));

    }

    public function layout($views = '', $data = array())
    {
        parent::layout($views, $data, $this->header, $this->footer, 'frontend');
    }

}


class Base_Backend_Controller extends Base_Controller
{
    public $header = 'backend/layout/header';
    public $footer = 'backend/layout/footer';

    function __construct()
    {
        parent::__construct();

        if(!$this->Auth_model->checkAccess(Auth_model::AUTH_ADMIN))
            redirect('/');

        $this->addCSS(array('bootstrap.min.css', 'font-awesome.min.css', 'chosen.css', 'ace.css', 'admin.css'));
        $this->addJS(array(
            'jquery-1.11.3.min.js' => self::SCRIPT_HEAD,
            'bootstrap.min.js' => self::SCRIPT_HEAD,
            'chosen.jquery.js' => self::SCRIPT_HEAD,
            'admin.js' => self::SCRIPT_FOOTER,
        ));
    }

    public function layout($views = '', $data = array())
    {
        parent::layout($views, $data, $this->header, $this->footer, 'backend');
    }
}


/**
 * Class Base_Controller
 * Base Controller for extends
 */
class Base_Controller extends CI_Controller
{

    const SCRIPT_HEAD       = 1;
    const SCRIPT_FOOTER     = 2;

    private $user = array();

    protected $css = array();
    protected $js = array();
    protected $assets = array();

    public $_js_variables = array();

    public $lang_name = NULL;
    public $title = '';


    /**
     * Get Current User
     * @return array
     */
    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public $page_name = '';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->model('Auth_model');

        $this->user = $this->session->userdata('id') !== false? $this->db->select('*')->from('user')->where('id', $this->session->userdata('id'))->get()->row_array(): false;

        if(!$this->Auth_model->is_logged_in() && $this->router->class != 'auth')
            redirect('auth/login');

        if(file_exists(APPPATH . "language/english/{$this->router->class}_lang.php"))
            $this->load->language($this->router->class);

        $this->_js_variables = array(
            'controller' => $this->router->class,
            'method'     => $this->router->method,
        );
    }

    public function getJS()
    {
        return $this->js;
    }

    public function getCSS()
    {
        return $this->css;
    }

    public function addJS($js = array())
    {
        if(!is_array($js) && empty($js)) return false;
        $this->js = array_merge($this->js, $js);
        return true;
    }

    public function addCSS($css = array())
    {
        if(!is_array($css) && empty($css)) return false;
        $this->css = array_merge($this->css, $css);
        return true;
    }

    public function layout($views = '', $data = array(), $header, $footer, $type)
    {
        $data = array_merge(array('base' => $this), $data);
        if ($header)
        {
            $this->load->view($header, $data);
        }

        if (is_array($views))
        {
            foreach ($views as $view)
            {
                $this->load->view("$type/$view", $data);
            }
        }
        else
        {
            $this->load->view("$type/$views", $data);
        }

        if ($footer)
        {
            $this->load->view($footer);
        }
    }

    /**
     * Return is ajax request
     * @return bool
     */
    public function is_ajax()
    {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']=="XMLHttpRequest");
    }

}