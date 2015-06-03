<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends Public_Controller {

    /**
     * Constructor
     */
    function __construct(){
        parent::__construct();

        // load the users model
        $this->load->model('users_model');

        // load the users language file
        $this->lang->load('users');
    }

    /**
	 * Default
     */
	function index(){

	//Do basic login checks
	if ($this->session->userdata('logged_in')){
            $logged_in_user = $this->session->userdata('logged_in');
            /*if ($logged_in_user['is_admin']){
                redirect('admin');
            }*/
        }


	if (isset ($_POST['submit_login'])) {
		        // set form validation rules
		$this->form_validation->set_error_delimiters($this->config->item('error_delimeter_left'), $this->config->item('error_delimeter_right'));
		$this->form_validation->set_rules('login_username', lang('users input username_email'), 'required|trim');
		$this->form_validation->set_rules('login_password', lang('users input password'), 'required|trim|callback__check_login');
	
		if ($this->form_validation->run() == TRUE){
		    if ($this->session->userdata('redirect')){
		        $redirect = $this->session->userdata('redirect');
		        $this->session->unset_userdata('redirect');
		        redirect($redirect);
		    }else{
		        $logged_in_user = $this->session->userdata('logged_in');
			//Check is user is either and admin or a normal user then redirect as necessary
		        if ($logged_in_user['is_admin'] || !$logged_in_user['is_admin']){
		            redirect(base_url());
		        }else{
				//SignUP Form Validation
			

			}
		    }
		}       
	}else if (isset ($_POST['submit_register'])){
		//form_validation of your change password

$this->form_validation->set_rules('username', lang('users input username'), 'required|trim|min_length[5]|max_length[30]|callback__check_username');
			$this->form_validation->set_rules('first_name', lang('users input first_name'), 'required|trim|min_length[2]|max_length[32]');
			$this->form_validation->set_rules('last_name', lang('users input last_name'), 'required|trim|min_length[2]|max_length[32]');
			$this->form_validation->set_rules('email', lang('users input email'), 'required|trim|max_length[128]|valid_email');
			$this->form_validation->set_rules('password', lang('users input password'), 'required|trim|min_length[5]');
			$this->form_validation->set_rules('password_repeat', lang('users input password_repeat'), 'required|trim|matches[password]');

        if ($this->form_validation->run() == TRUE){
            // save the changes
            $validation_code = $this->users_model->create_profile($this->input->post());

            if ($validation_code){
                // build the validation URL
                $encrypted_email = sha1($this->input->post('email', TRUE));
                $validation_url  = base_url('user/validate') . "?e={$encrypted_email}&c={$validation_code}";

                // build email
                $email_msg  = lang('core email start');
                $email_msg .= sprintf(lang('users msg email_new_account'), $this->settings->site_name, $validation_url, $validation_url);
                $email_msg .= lang('core email end');

                // send email
                $this->load->library('email');
                $config['protocol'] = 'sendmail';
                $config['mailpath'] = '/usr/sbin/sendmail -f' . $this->settings->site_email;
                $this->email->initialize($config);
                $this->email->clear();
                $this->email->from($this->settings->site_email, $this->settings->site_name);
                $this->email->reply_to($this->settings->site_email, $this->settings->site_name);
                $this->email->to($this->input->post('email', TRUE));
                $this->email->subject(sprintf(lang('users msg email_new_account_title'), $this->input->post('first_name', TRUE)));
                $this->email->message($email_msg);
                $this->email->send();
                #echo $this->email->print_debugger();

                $this->session->set_flashdata('message', sprintf(lang('users msg register_success'), $this->input->post('first_name', TRUE)));
            }else{
                $this->session->set_flashdata('error', lang('users error register_failed'));
            }

            // redirect home and display message
            redirect(base_url());
        }
	}

        // setup page header data
        //$this->set_title( sprintf(lang('core title welcome'), $this->settings->site_name) );
  	$this->set_title( 'Chronicles');
        $data = $this->includes;

	// set content data
        $content_data = array(
            'cancel_url'        => base_url(),
            'user'              => NULL,
            'password_required' => TRUE
        ); 

        // load views
        $data['content'] = $this->load->view('welcome', $content_data, TRUE);
		$this->load->view($this->template, $data);
	}

    /**************************************************************************************
     * PRIVATE VALIDATION CALLBACK FUNCTIONS
     **************************************************************************************/


    /**
     * Verify the login credentials
     *
     * @param  string $password
     * @return boolean
     */
    function _check_login($password){
        $login = $this->users_model->login($this->input->post('login_username', TRUE), $password);

        if ($login){
            $this->session->set_userdata('logged_in', $login);
            return TRUE;
        }

        $this->form_validation->set_message('_check_login', lang('users error invalid_login'));
        return FALSE;
    }


    /**
     * Make sure username is available
     *
     * @param  string $username
     * @return int|boolean
     */
    function _check_username($username){
        if ($this->users_model->username_exists($username)){
            $this->form_validation->set_message('_check_username', sprintf(lang('users error username_exists'), $username));
            return FALSE;
        }else{
            return $username;
        }
    }


    /**
     * Make sure email exists
     *
     * @param  string $email
     * @return int|boolean
     */
    function _check_email($email)
    {
        if ( ! $this->users_model->email_exists($email))
        {
            $this->form_validation->set_message('_check_email', sprintf(lang('users error email_not_exists'), $email));
            return FALSE;
        }
        else
        {
            return $email;
        }
    }

































}
