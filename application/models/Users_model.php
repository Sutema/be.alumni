<?php
class Users_model extends CI_Model{
    var $table_name = "users";
    
    public function __construct(){
        $this->load->database();
    }

    public function get($id = FALSE){
        if($id == FALSE){
            $query = $this->db->get($this->table_name);
            return $query->result_array();
        }

        $query = $this->db->get_where($this->table_name, array('id' => $id));
        return $query->row_array();
    }

    public function auth(){
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $query = $this->db->get_where($this->table_name, array('username' => $username, 'password' => $password));
        
        return $query->result_array();
    }

    public function create()
    {
        $this->load->helper('url');
        $id = $this->uuid->v4();
        $fullname = ucwords($this->input->post('fullname'));
        $password = $this->randomString();
        $username = url_title(strtolower($this->input->post('fullname')), '.', TRUE);
        
        $data = array(
            'id' => $id,
            'username' => $username,
            'password' => $password,
            'fullname' => $fullname, 
            'email'=> $this->input->post('email'), 
            'status' => 1
        );

        return $this->db->insert($this->table_name, $data);
    }

    private function randomString($length = 6) {
        $str = "";
        $characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }
}
?>