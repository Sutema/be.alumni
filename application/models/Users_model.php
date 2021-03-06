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
        $options = [
            'cost' => 12,
        ];
        $password = $this->input->post('password');
        $hash = password_hash($password, PASSWORD_BCRYPT, $options);
        $username = url_title(strtolower($this->input->post('fullname')), '.', TRUE);
        
        $data = array(
            'id' => $id,
            'username' => $username,
            'password' => $hash,
            'fullname' => $fullname, 
            'email'=> $this->input->post('email'), 
            'status' => 1
        );

        return $this->db->insert($this->table_name, $data);
    }

    public function verify(){
        $password = $this->input->post("password");
        $email = $this->input->post("email");
        $result = false;

        $query = $this->db->get_where($this->table_name, array('email' => $email));
        $row = $query->result_array();
        
        try{
            if($row != []){
                $hash = $row[0]['password'];
                $result = password_verify($password, $hash);
            }
        }
        catch(Exception $e){
        }

        return $result;
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