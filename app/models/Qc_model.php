<?php

class Qc_model {
    private $table = 'tb_qc';
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllData()
    {
        $this->db->query("SELECT * FROM . $this->table");
        return $this->db->resultSet();
    }

    public function getDataById($id)
    {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE id_qc = :id_qc");
        $this->db->bind(':id_qc', $id);
        return $this->db->single();
    }

    public function downloadFile($file) 
    {
        // Dapatkan tanggal berdasarkan nama file
        $tanggal = $this->getTanggalByFile($file);
        
        if ($tanggal) {
            // Tentukan path file berdasarkan tanggal
            $filePath = "D:\\File_Server\\QC\\$tanggal\\" . basename($file);

            // Cek apakah file ada
            if (file_exists($filePath)) {
                // Set header untuk download file
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($filePath));

                // Bersihkan buffer sebelum mengirim file
                ob_clean();
                flush();

                // Kirim file ke output
                readfile($filePath);
                exit;
            } else {
                return "File tidak ditemukan.";
            }
        } else {
            return "Data file tidak ditemukan di database.";
        }
    } 

    // Fungsi untuk menambah data QC baru
    public function addData($tanggal, $vendor, $code_number, $new_file_name, $progres, $person)
    {
       
        $query = "INSERT INTO " . $this->table . " (tanggal, vendor, code_number, file, progres, person) 
                  VALUES (:tanggal, :vendor, :code_number, :file, :progres, :person)";
        $this->db->query($query);
        $this->db->bind(':tanggal', $tanggal);
        $this->db->bind(':vendor', $vendor);
        $this->db->bind(':code_number', $code_number);
        $this->db->bind(':file', $new_file_name);
        $this->db->bind(':progres', $progres);
        $this->db->bind(':person', $person);
        $this->db->execute(); 

        return $this->db->rowCount();

    }

        // Mengupdate total rejected dan approveed berdasarkan vendor dan code_number
    public function updateTotals($vendor, $code_number)
    {
        $query = "
            UPDATE " . $this->table . " t1
            JOIN (
                SELECT 
                    vendor,
                    code_number,
                    SUM(CASE WHEN is_reject = 1 AND is_approve = 0 THEN 1 ELSE 0 END) as total_rejected,
                    SUM(CASE WHEN is_reject = 0 AND is_approve = 1 THEN 1 ELSE 0 END) as total_approved
                FROM " . $this->table . " 
                GROUP BY vendor, code_number
            ) t2 ON t1.vendor = t2.vendor AND t1.code_number = t2.code_number
            SET 
                t1.total_reject = t2.total_rejected,
                t1.total_approve = t2.total_approved
            WHERE t1.vendor = :vendor AND t1.code_number = :code_number";
        $this->db->query($query);
        $this->db->bind(':vendor', $vendor);
        $this->db->bind(':code_number', $code_number);
        return $this->db->execute();
    }

    public function deleteAll()
    {
        $query = "DELETE FROM " . $this->table . " WHERE progres != 'In Progress'";
        $this->db->query($query);
        $this->db->execute();
    
        return $this->db->rowCount(); 
    }


    public function processInspectionStatus($row)
    {
        // Pengaturan logika untuk alur inspeksi berdasarkan input dari row
        $progres = $row['progres'];
        $is_reject = $row['is_reject'];
        $is_approve = $row['is_approve'];
        $vendor = $row['vendor'];
        $code_number = $row['code_number'];
        $countData = 0;
        $ngLots = 0;

    
        // Memperbarui total rejected dan approveed untuk vendor dan code_number yang bersangkutan
        $this->updateTotals($vendor, $code_number);
    
        if ($is_reject == 1) {
            $query = "SELECT COUNT(*) as ng_lots FROM " . $this->table . " WHERE code_number = :code_number AND vendor = :vendor AND is_reject = 1 AND is_approve = 0";
            $this->db->query($query);
            $this->db->bind(':code_number', $code_number);
            $this->db->bind(':vendor', $vendor);
            $result = $this->db->single();
            $ngLots = $result ? $result['ng_lots'] : 0;
        } else {
            $query = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE code_number = :code_number AND vendor = :vendor AND is_reject = 0 AND is_approve = 1";
            $this->db->query($query);
            $this->db->bind(':code_number', $code_number);
            $this->db->bind(':vendor', $vendor);
            $result = $this->db->single();
            $countData = $result ? $result['total'] : 0;
        }
    
        // Menentukan status inspeksi berdasarkan kondisi tertentu
        if ($progres == 'In Progress') {
            if ($ngLots > 0 && $countData == 0) {
                $progres = 'Tightened Inspection';
            } elseif ($countData >= 20) {
                $progres = 'Skip Inspection';
            } elseif ($countData >= 10) {
                $progres = 'Easy Inspection';
            } elseif ($row['total_reject'] > 0 && $countData <= 3) {
                $progres = ($countData >= 3) ? 'Normal Inspection' : 'Tightened Inspection';
            } else {
                $progres = 'Normal Inspection';
            }
        }
    
    
        // Memperbarui progres di database
        $query = "UPDATE " . $this->table . " SET progres = :progres WHERE id_qc = :id_qc";
        $this->db->query($query);
        $this->db->bind(':progres', $progres);
        $this->db->bind(':id_qc', $row['id_qc']);
        $this->db->execute(); 
        return $this->db->rowCount();
    }

    function determineInspectionStatus($total_approve, $total_reject) 
    {
        if ($total_approve >= 20) {
            return 'Skip Inspection';
        } elseif ($total_approve >= 10) {
            return 'Easy Inspection';
        } elseif ($total_reject > 0 && $total_approve <= 3) {
            if ($total_approve >= 3) {
                return 'Normal Inspection';
            } else {
                return 'Tightened Inspection';
            }
        } else {
            return 'Normal Inspection';
        }
    }

    public function approveAdmin($id, $tanggal_approve) 
    {
        $query = "UPDATE " . $this->table . " SET approve_admin = 1, tanggal_approve = :tanggal_approve WHERE id_qc = :id_qc";
        $this->db->query($query);
        $this->db->bind(':id_qc', $id);
        $this->db->bind(':tanggal_approve', $tanggal_approve);
        $this->db->execute(); 

        return $this->db->rowCount();
    }

    public function approve($id) 
    {
        $query = "UPDATE " . $this->table . " SET is_reject = 0, is_approve = 1 WHERE id_qc = :id_qc";
        $this->db->query($query);
        $this->db->bind(':id_qc', $id);
        $this->db->execute(); 

        return $this->db->rowCount();
    }

    // Menolak data QC dengan ID tertentu
    public function reject($id) {
        // Gabungan query untuk menandai is_reject, history_reject dan mereset is_approve
        // history_reject = CASE WHEN id_qc = :id_qc THEN 1 ELSE history_reject END,
        $query = "
            UPDATE " . $this->table . " 
            SET 
                is_reject = CASE WHEN id_qc = :id_qc THEN 1 ELSE is_reject END,
                is_approve = CASE 
                    WHEN code_number = (SELECT code_number FROM " . $this->table . " WHERE id_qc = :id_qc LIMIT 1) 
                         AND vendor = (SELECT vendor FROM " . $this->table . " WHERE id_qc = :id_qc LIMIT 1) 
                         AND is_approve = 1 THEN 0 
                    ELSE is_approve 
                END
            WHERE id_qc = :id_qc
               OR (code_number = (SELECT code_number FROM " . $this->table . " WHERE id_qc = :id_qc LIMIT 1) 
                   AND vendor = (SELECT vendor FROM " . $this->table . " WHERE id_qc = :id_qc LIMIT 1) 
                   AND is_approve = 1)";
    
        $this->db->query($query);
        $this->db->bind(':id_qc', $id);
        $this->db->execute();
    
        return $this->db->rowCount();
    }

    public function getQcData($limit, $offset, $search, $category) 
    {
        $searchQuery = $search !== '' ? "WHERE t1.$category LIKE :search" : '';
        $query = "
            SELECT *
            FROM tb_qc t1
            INNER JOIN (
                SELECT vendor, code_number, MAX(id_qc) as max_id
                FROM tb_qc
                GROUP BY vendor, code_number
            ) t2 ON t1.id_qc = t2.max_id
            $searchQuery
            ORDER BY t1.vendor, t1.code_number
            LIMIT :limit OFFSET :offset
        ";
        $this->db->query($query);
        $this->db->bind('limit', $limit);
        $this->db->bind('offset', $offset);
        if ($search !== '') {
            $this->db->bind('search', '%' . $search . '%');
        }
        return $this->db->resultSet(); 
    }

    public function getDataLastOne() 
    {
        $query = "
            SELECT *
            FROM tb_qc t1
            INNER JOIN (
                SELECT vendor, code_number, MAX(id_qc) as max_id
                FROM tb_qc
                GROUP BY vendor, code_number
            ) t2 ON t1.id_qc = t2.max_id
            ORDER BY t1.vendor, t1.code_number
        ";
        $this->db->query($query);
        return $this->db->resultSet();
    }
    

    public function getTotalCount() 
    {
        $query = " SELECT COUNT(*) as total FROM " . $this->table . " WHERE is_approve = 1 OR is_reject = 1 OR progres = 'In Progress'";
        $this->db->query($query);
        return $this->db->single()['total'];
    }
    
    public function getInspectionCounts()
    {
        $counts = [];
        $inspectionTypes = ['Normal Inspection', 'Easy Inspection', 'Skip Inspection', 'Tightened Inspection', 'In Progress'];
        
        foreach ($inspectionTypes as $type) {
            $query = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE progres = :type AND (is_approve = 1 OR is_reject = 1 OR progres = 'In Progress')";
            $this->db->query($query);
            $this->db->bind(':type', $type);
            $result = $this->db->single();
            
            $counts[$type] = $result['total'];
        }
        
        return $counts;
    }

    public function getAllHistory()
    {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE progres != 'In Progress' AND approve_admin > 0 ");
        return $this->db->resultSet();
    }

    public function getAllHistoryInspector()
    {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE is_approve = 1 OR is_reject = 1");
        return $this->db->resultSet();
    }

    public function getTanggalByFile($file) 
    {
        $this->db->query("SELECT tanggal FROM " . $this->table . " WHERE file = :file");
        $this->db->bind(':file', $file);
        $result = $this->db->single();
        return $result ? $result['tanggal'] : null;
    }

    public function getDetailsByProgres($progres)
    {
        $query = "SELECT code_number, vendor FROM " . $this->table . " WHERE progres = :progres AND (is_approve = 1 OR is_reject = 1 OR progres = 'In Progress')";
        $this->db->query($query);
        $this->db->bind(':progres', $progres);

        return $this->db->resultSet();
    }

    public function getAllAction()
    {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE progres = 'In Progress'");
        return $this->db->resultSet();
    }

    public function getDataAfterInspect()
    {
        // $this->db->query("SELECT * FROM " . $this->table . " WHERE progres = 'In Progress'");
        // return $this->db->resultSet();
        $query = "SELECT * FROM " .$this->table. " WHERE (is_reject > 0 OR is_approve > 0) AND approve_admin = 0";
        $this->db->query($query);
        return $this->db->resultSet();
    }

}