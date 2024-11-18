<?php
// Cek apakah pengguna sudah login (dengan memeriksa cookie)
if (isset($_COOKIE['username'])) {
    header('Location: index.php');
    exit();
}

// Cek jika form login dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars($_POST['username']);

    // Set cookie untuk username yang berlaku selama 1 jam
    setcookie('username', $username, time() + 3600, "/"); // 3600 detik = 1 jam

    // Arahkan ke index.php setelah login
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <title>Login - Pendaftaran Lomba</title>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <span class="navbar-brand mb-0 h1">Pendaftaran Lomba</span>
    </nav>

    <div class="container">
        <br>
        <h4><center>Login</center></h4>
        <form method="POST" action="login.php">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</body>
</html>
