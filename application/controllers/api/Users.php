<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Users extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        $this->load->model('users_model');
        $this->load->helper('url_helper');
    }

    public function index_get()
    {
        // Users from a data store e.g. database
        $users = $this->users_model->get();
        $this->set_response($users, 200);
    }

    public function index_post()
    {
        $result = $this->users_model->create();
        $message = [
            'text' => null
        ];
        if($result){
            $message['text'] = 'Succesfully insert new User';
        }else{
            $message['text'] = 'Insert is failed';
        }
        $this->set_response($message, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }

    public function auth_post(){
        $result = $this->users_model->auth();
        $message = false;
        if($result){
            $message = true;
        }
        $this->set_response(array("success" => $message), 200); 
    }

    public function verify_post(){
        $result = $this->users_model->verify();

        $this->set_response(array("success" => $result), 200);
    }
}
