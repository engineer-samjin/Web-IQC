<?php

class Home extends Controller {
    public function __construct()
    {
        $this->qcModel = $this->model('Qc_model');
        $this->vendorModel = $this->model("Vendor_model");
        $this->progresModel = $this->model('Progres_model');
    }
    public function index()
    {   
        $limit = $_GET['limit'] ?? 10;
        $page = $_GET['page'] ?? 1;
        $offset = ($page - 1) * $limit;

        $search = $_GET['search'] ?? '';
        $category = $_GET['category'] ?? 'vendor';

        // Fetch data
        $vendors = $this->vendorModel->getAllVendors();
        $parts = $this->vendorModel->getAllParts();
        $data = $this->qcModel->getQcData($limit, $offset, $search, $category);
        foreach ($data as &$row) {
            $row['nextStatus'] = $this->qcModel->determineInspectionStatus($row['total_approve'], $row['total_reject']);
        }
        $totalData = $this->qcModel->getTotalCount($search, $category);
        $totalPages = 4;
        // $totalPages = $limit !== 'all' ? ceil($totalData / $limit) : 1;

        $this->view('templates/header', ['judul' => 'Home']);
        $this->view('home/index', [
            'data' => $data,
            'nextProgres' => $row['nextStatus'],
            'vendors' => $vendors,
            'parts' => $parts,
            'totalData' => $totalData,
            'totalPages' => $totalPages,
            'search' => $search,
            'category' => $category,
            'limit' => $limit,
            'page' => $page,
            'offset' => $offset 
        ]);
        $this->view('templates/footer');
    }

    public function inspect()
    {
        $this->view('templates/header', ['judul' => 'Inspect']);
        $this->view('home/inspect');
        $this->view('templates/footer');
    }

    public function history()
    {
        $data['judul'] = 'History';
        $this->view('templates/header', $data);
        $this->view('home/history' );
        $this->view('templates/footer');
    }

    public function historyData()
    {
        $data = $this->qcModel->getAllHistoryInspector();
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function addQcData()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form_type']) && $_POST['form_type'] === 'qc_data') {
            $tanggal = $_POST['tanggal'];
            $vendor = $_POST['vendor'];
            $code_number = $_POST['code_number'];
            $person = $_POST['operator'];
            $progres = 'In Progress';
    
            $file = $_FILES['file']['name'];

            $file = str_replace(' ','_',$file);
            $file_extension = strtolower(pathinfo($file, PATHINFO_EXTENSION)); 
    
            // Daftar ekstensi file yang diizinkan
            $allowed_extensions = ['xls', 'xlsx', 'pdf', 'doc', 'docx'];
    
            if (!in_array($file_extension, $allowed_extensions)) {
                Flasher::setFlash('error', 'Failed!', 'File types are not allowed! Only Excel, PDF, and Word files are allowed.');
                header('Location: ' . BASEURL . '/home');
                exit;
            }
    
            // Nama file baru dengan format: tanggal_namafile.extension
            $new_file_name = $tanggal . "_" . basename($file, ".$file_extension") . "." . $file_extension;
            $target_dir = "D:\\File_Server\\QC\\$tanggal\\";
    
            // Membuat folder jika belum ada
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
    
            $target_file = $target_dir . $new_file_name;
    
            // Memindahkan file yang diunggah
            if (!move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
                Flasher::setFlash('error', 'Failed!', 'Failed to upload file!');
                header('Location: ' . BASEURL . '/home');
                exit;
            }
    
            // Simpan data QC
            if ($this->qcModel->addData($tanggal, $vendor, $code_number, $new_file_name, $progres, $person)) {
                $this->qcModel->updateTotals($vendor, $code_number);
                Flasher::setFlash('success', 'Succeed!', 'Data successfully added!');
                header('Location: ' . BASEURL . '/home');
                exit;
            } else {
                Flasher::setFlash('error', 'Failed!', 'Failed to add data!');
                header('Location: ' . BASEURL . '/home');
                exit;
            }
        }
    }
    

    public function addVendorData()
    {
        header('Content-Type: application/json'); 
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form_type']) && $_POST['form_type'] === 'vendor_data') {
            $vendor = $_POST['vendor'];
            $code_number = $_POST['code_number'];

            $dataVendor = $this->vendorModel->checkVendor($vendor, $code_number);

            if ($dataVendor) {
                http_response_code(400);
                Flasher::setFlash('error','Failed!', 'Vendor is already registered!');
                header('Location: ' . BASEURL . '/home');
                exit;
            } 
            
            // Simpan data vendor
            if ($this->vendorModel->addVendor($vendor, $code_number)) {
                Flasher::setFlash('success','Succeed!', 'Data successfully added!');
                header('Location: ' . BASEURL . '/home');
                exit;
            } else {
                Flasher::setFlash('error','Failed!', 'Failed to add data!');
                header('Location: ' . BASEURL . '/home');
                exit;
            }

        } 
    }
  
    public function updateTotals() {
        $vendor = $_POST['vendor'];
        $code_number = $_POST['code_number'];

        $this->qcModel->updateTotals($vendor, $code_number);
    }

    public function getDataLastOne()
    {
        $data = $this->qcModel->getDataLastOne();
        foreach ($data as &$row) {
            $row['nextProgres'] = $this->qcModel->determineInspectionStatus($row['total_approve'], $row['total_reject']);
        }

        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function approve() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            header('Content-Type: application/json');
            $id = intval($_POST['id']);
            $result = $this->qcModel->approve($id);

            if ($result) {
                $row = $this->qcModel->getDataById($id);
                $this->qcModel->processInspectionStatus($row);
                echo json_encode(['success' => true, 'message' => 'Data berhasil disetujui']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Gagal menyetujui data']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Permintaan tidak valid']);
        }
    }

    public function reject() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            header('Content-Type: application/json');
            $id = intval($_POST['id']);
            $result = $this->qcModel->reject($id);

            if ($result) {
                $row = $this->qcModel->getDataById($id);
                $this->qcModel->processInspectionStatus($row);
                echo json_encode(['success' => true, 'message' => 'Data berhasil ditolak']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Gagal menolak data']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Permintaan tidak valid']);
        }
    }

    public function allDataAction()
    {
        $data = $this->qcModel->getAllAction();
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
