<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function index()
    {
        if(isset($_SESSION['login']))
        {
            $this->load->view('user_page');
        }
        else
        {
            $this->load->view('login_page');
        }

    }

    public function logout()
    {
        unset($_SESSION['login']);
        $this->index();
    }

    public function login()
    {
        if(isset($_SESSION['login']))
        {
            $this->load->view('user_page');
        }
        else
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

                $value = $this->users->login($login, $password);
                $data['login'] = $login;
                if($value)
                {
                    $array = array('login' => $login);
                    $this->session->set_userdata($array);
                    $this->load->view('user_page', $data);
                }
                else
                {
                    $message['message'] = 'Please try again';
                    $this->load->view('login_page', $message);

                }
            }

        }


    }

    public function get_hotspots()
    {
        $this->load->model('users');
        $hotspots['hotspots'] = $this->users->get_hotspots();
        $this->load->view('all_hotspots', $hotspots);
    }
}
