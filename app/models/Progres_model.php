<?php

class Progres_model {
    private $tabel = 'tb_qc_progres';
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function addProgres($tanggal, $vendor, $code_number, $progres)
    {
        // Cek apakah data sudah ada
        $query = "SELECT id_progres FROM " . $this->tabel . " WHERE code_number = :code_number AND vendor = :vendor";
        $this->db->query($query);
        $this->db->bind(':code_number', $code_number);
        $this->db->bind(':vendor', $vendor);
        $existing = $this->db->single();
    
        if ($existing) {
            // Update jika data sudah ada
            $query = "UPDATE " . $this->tabel . " 
                     SET progres = :progres, 
                         tanggal = :tanggal 
                     WHERE code_number = :code_number AND vendor = :vendor";
        } else {
            // Insert jika data belum ada
            $query = "INSERT INTO " . $this->tabel . 
                    "(vendor, code_number, progres, tanggal) 
                     VALUES (:vendor, :code_number, :progres, :tanggal)";
        }
        
        $this->db->query($query);
        $this->db->bind(':progres', $progres);
        $this->db->bind(':tanggal', $tanggal);
        $this->db->bind(':code_number', $code_number);
        $this->db->bind(':vendor', $vendor);
        $this->db->execute();
    
        return $this->db->rowCount();
    }
}