<?php

class User_model{
    private $table = "tb_qc_users";
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function checkUser($username, $password)
    {
        $this->db->query("SELECT * FROM ". $this->table . " WHERE username = :username AND password = :password");
        $this->db->bind(":username", $username);
        $this->db->bind(":password", $password);
        return $this->db->single();
    }
}