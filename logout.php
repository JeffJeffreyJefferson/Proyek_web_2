<?php
// Hapus cookie dengan mengatur waktu kedaluwarsa di masa lalu
setcookie('username', '', time() - 3600, '/');

// Arahkan ke halaman login setelah logout
header('Location: login.php');
exit();
?>
