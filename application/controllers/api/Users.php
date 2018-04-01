<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Users extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        $this->load->model('employees_model');
        $this->load->helper('url_helper');
    }

    public function index_get()
    {
        // Users from a data store e.g. database
        $users = $this->employees_model->get_employees();
        $this->set_response($users, 200);
    }

    public function index_post()
    {
        $result = $this->employees_model->set_employee();
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

    public function index_delete()
    {
        $id = (int) $this->get('id');

        // Validate the id.
        if ($id <= 0)
        {
            // Set the response and exit
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        // $this->some_model->delete_something($id);
        $message = [
            'id' => $id,
            'message' => 'Deleted the resource'
        ];

        $this->set_response($message, REST_Controller::HTTP_NO_CONTENT); // NO_CONTENT (204) being the HTTP response code
    }

}
