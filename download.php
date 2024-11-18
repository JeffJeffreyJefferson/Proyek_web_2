<?php

include "koneksi.php";

// Cek apakah ada parameter 'file' yang diterima
if (isset($_GET['file'])) {
    $file = urldecode($_GET['file']); // Decode URL-encoded file name

    // Cek apakah file benar-benar ada
    if (file_exists($file)) {
        // Set header untuk mengunduh file
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($file).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        flush(); // Flush system output buffer
        readfile($file); // Baca dan kirim file ke output
        exit;
    } else {
        echo "<div class='alert alert-danger'> File tidak ditemukan.</div>";
    }
} else {
    echo "<div class='alert alert-danger'> Tidak ada file yang dipilih.</div>";
}
?>
