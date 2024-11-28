<?php
$koneksi = mysqli_connect("localhost","root","","samjin")
or die(mysqli_connect_error());

if (isset($_GET['file'])) {
    $file = $_GET['file'];

    // Dapatkan data tanggal dari database berdasarkan nama file
    $query = "SELECT tanggal FROM tb_qc WHERE file = '$file'";
    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $tanggal = $row['tanggal'];
        
        // Set path file dengan folder berdasarkan tanggal
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
            
            // Membersihkan buffer output sebelum mengirim file
            ob_clean();
            flush();

            // Membaca file dan mengirimkannya ke output
            readfile($filePath);
            exit;
        } else {
            echo "File tidak ditemukan.";
        }
    } else {
        echo "Data file tidak ditemukan di database.";
    }
} else {
    echo "File tidak tersedia.";
}
?>
