<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function index() {
        mininos_render("administrator/dashboard/v_dashboard", array());
    }

    public function login() {
        // print_r($this->data);
        // die();
        render_view('auth/login', array(), NULL, NULL, LAYOUT_LOGIN);
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect(base_url(), 'refresh');
    }

    public function login_auth() {
        if ($this->reqMethod == 'POST') {
            $input = $this->input->post('data');
            $args = array(
                "username" => $input['uid'],
                "password" => md5($input['upass']),
            );
            $data = $this->common_model->condition($args)->table_name(V_USER_LOGIN)->do_read();
            if (!empty($data)) {
                $this->session->set_userdata(CURRENT_USER, $data[0]);
                redirect(base_url('dashboard'), 'refresh');
            } else {
                render_view('auth/login', array(), NULL, NULL, 'login');
            }
        }
        
    }

}
