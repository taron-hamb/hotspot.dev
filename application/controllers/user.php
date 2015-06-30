<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function index()
    {
        $this->load->view('login_page');
    }

    public function login()
    {

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('login', 'trim|required|min_length[5]|max_length[12]|xss_clean');
        $this->form_validation->set_rules('password', 'trim|required|md5');

        if($this->form_validation->run() == false)
        {
            $this->load->view('login_page');
        }
        else
        {
            $login = $this->input->post('login');
            $password = $this->input->post('password');

            $this->load->model('users');
//            var_dump( $this->load->model('users'));exit;

            $value = $this->users->login($login, $password);
            $data['login'] = $login;
            if($value)
            {
                $this->load->view('user_page', $data);
            }
            else
            {
                header('Location: login/');
//                $this->form_validation->set_message('login', 'password ');
//                redirect('login',$login);

            }
        }


    }

}
