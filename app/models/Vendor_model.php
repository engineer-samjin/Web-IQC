<?php

class Vendor_model {
    private $table = 'tb_qc_vendor';
    // private $table2 = 'tb_vendor';
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllVendors()
    {
        $this->db->query("SELECT DISTINCT vendor FROM ". $this->table);
        return $this->db->resultSet();
    }
    public function getAllParts()
    {
        $this->db->query("SELECT DISTINCT code_number FROM ". $this->table);
        return $this->db->resultSet();
    }

    public function addVendor($vendor, $code_number)
    {
        $query = "INSERT INTO ". $this->table . "(vendor, code_number)
        VALUES (:vendor, :code_number)";
        $this->db->query($query);
        $this->db->bind(':vendor', $vendor);
        $this->db->bind(':code_number', $code_number);
        $this->db->execute(); 

        return $this->db->rowCount();
    }

    public function checkVendor($vendor, $code_number)
    {
        $this->db->query("SELECT * FROM ". $this->table . " WHERE vendor = :vendor AND code_number = :code_number");
        $this->db->bind(":vendor", $vendor);
        $this->db->bind(":code_number", $code_number);
        return $this->db->single();
    }
}