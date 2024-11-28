<?php
require_once '../vendor/autoload.php'; 

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Dashboard extends Controller{

    public function __construct()
    {
        if (!isset($_SESSION['username'])) {
            header('Location: ' . BASEURL . '/login');
            exit();
        }

        // Inisialisasi model sekali di konstruktor
        $this->qcModel = $this->model('Qc_model');
        $this->progresModel = $this->model('Progres_model');
    }
    public function index() 
    {   

        $data = $this->qcModel->getInspectionCounts();
        $totalData = $this->qcModel->getTotalCount();

        $data['judul'] = 'Dashboard';
        $this->view('templates/header', $data);
        $this->view('dashboard/index', [
            'Normal Inspection' => $data['Normal Inspection'],
            'Easy Inspection' => $data['Easy Inspection'],
            'Skip Inspection' => $data['Skip Inspection'],
            'Tightened Inspection' => $data['Tightened Inspection'],
            'In Progress' => $data['In Progress'],
            'Total Data' => $totalData
        ]);
        $this->view('templates/footer');
    }

    public function getCountProgresData()
    {
        $inspectionCounts = $this->qcModel->getInspectionCounts();
        $totalData = $this->qcModel->getTotalCount();

        echo json_encode([
            'inspectionCounts' => [
                'Normal Inspection' => $inspectionCounts['Normal Inspection'],
                'Easy Inspection' => $inspectionCounts['Easy Inspection'],
                'Skip Inspection' => $inspectionCounts['Skip Inspection'],
                'Tightened Inspection' => $inspectionCounts['Tightened Inspection'],
                'In Progress' => $inspectionCounts['In Progress'],
                'Total Data' => $totalData
            ],
        ]);
    }


    public function history()
    {
        $data['judul'] = 'History';
        $this->view('templates/header', $data);
        $this->view('dashboard/history' );
        $this->view('templates/footer');
    }

    public function tracking()
    {
        $data['judul'] = 'Tracking';
        $this->view('templates/header', $data);
        $this->view('dashboard/tracking' );
        $this->view('templates/footer');
    }

    public function historyData()
    {
        $data = $this->qcModel->getAllHistory();
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    public function allDataAction()
    {
        $data = $this->qcModel->getDataAfterInspect();
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function approve() 
    {
        date_default_timezone_set('Asia/Jakarta');
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            header('Content-Type: application/json');
            $id = intval($_POST['id']);
            $tanggal_approve = date('Y-m-d');
            $result = $this->qcModel->approveAdmin($id, $tanggal_approve);
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Data berhasil disetujui']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Gagal menyetujui data']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Permintaan tidak valid']);
        }
    }

    public function dataById($id)
    {
        header('Content-Type: application/json');
    
        // Memastikan ID valid
        if ($id === null || !is_numeric($id)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'ID tidak valid']);
            return;
        }
    
        // Mengambil data dari model berdasarkan ID
        $data = $this->qcModel->getDataById(intval($id));
    
        if ($data) {
            // Mengirim data yang ditemukan sebagai JSON
            echo json_encode(['success' => true, 'data' => $data]);
        } else {
            // Mengirim pesan error jika data tidak ditemukan
            echo json_encode(['success' => false, 'error' => 'Data tidak ditemukan']);
        }
    }

    public function download($file)
    {
        $file = htmlspecialchars($file);
        $response = $this->qcModel->downloadFile($file);

        if ($response) {
            echo $response;
        }
    }

    public function updateStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_qc = $_POST['id_qc'];
            $newStatus = $_POST['nextProgres'];

            $result = $this->qcModel->updateStatus($id_qc, $newStatus);

            header('Content-Type: application/json');
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Status berhasil diperbarui']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Gagal memperbarui status']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Metode tidak valid']);
        }
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

    public function getProgresDetails()
    {
        if (isset($_GET['progres']) && !empty($_GET['progres'])) {
            $progres = htmlspecialchars($_GET['progres']);

            $data = $this->qcModel->getDetailsByProgres($progres);
    
            header('Content-Type: application/json');
            echo json_encode($data);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid progres parameter']);
        }
    }
    
    public function deleteAll() 
    {
        $deletedRows = $this->qcModel->deleteAll();

        if ($deletedRows > 0) {
            Flasher::setFlash('success','Delete Success!', 'Data has been successfully deleted');
            header('Location: ' . BASEURL . '/dashboard/history');
            exit();
        } else {
            Flasher::setFlash('error','Failed Delete', 'Data not found');
            header('Location: ' . BASEURL . '/dashboard/history');
            exit();
        }

    }

    public function exportToExcel()
    {
        $data = $this->qcModel->getAllHistory();

        if (empty($data)) {
            Flasher::setFlash('error','Failed Export', 'Data not found');
            header('Location: ' . BASEURL . '/dashboard/history');
            exit;
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Date');
        $sheet->setCellValue('C1', 'Vendor');
        $sheet->setCellValue('D1', 'Part Number');
        $sheet->setCellValue('E1', 'Progres');
        $sheet->setCellValue('F1', 'Inspection Result');

        // Isi data
        $row = 2;
        $no = 1;
        foreach ($data as $item) {
            if ($item['is_approve'] == 1) {
                $item['is_approve'] = 'Approved';
            } else {
                $item['is_approve'] = 'Rejected';
            }
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $item['tanggal']);
            $sheet->setCellValue('C' . $row, $item['vendor']);
            $sheet->setCellValue('D' . $row, $item['code_number']);
            $sheet->setCellValue('E' . $row, $item['progres']);
            $sheet->setCellValue('F' . $row, $item['is_approve']);
            $row++;
        }

        // Set nama file
        $fileName = 'History_QC_' . date('Y-m-d_H-i-s') . '.xlsx';

        // Header untuk download file
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        // Tulis file Excel ke output
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
  
}