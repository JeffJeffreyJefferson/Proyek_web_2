<!DOCTYPE html>
<html>
<head>
    <title>Form Pendaftaran Anggota</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <?php
    // Include file koneksi, untuk koneksikan ke database
    include "koneksi.php";

    // Fungsi untuk mencegah inputan karakter yang tidak sesuai
    function input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Cek apakah ada nilai yang dikirim menggunakan method GET dengan nama id_peserta
    if (isset($_GET['id_peserta'])) {
        $id_peserta = input($_GET["id_peserta"]);
        $sql = "SELECT * FROM peserta WHERE id_peserta = $id_peserta";
        $hasil = mysqli_query($kon, $sql);
        $data = mysqli_fetch_assoc($hasil);
    }

    // Cek apakah ada kiriman form dari method POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_peserta = htmlspecialchars($_POST["id_peserta"]);
        $nama = input($_POST["nama"]);
        $universitas = input($_POST["universitas"]);
        $jurusan = input($_POST["jurusan"]);
        $no_hp = input($_POST["no_hp"]);
        
        // Handle file upload
        $foto_ktm = '';
        if (isset($_FILES['foto_ktm']) && $_FILES['foto_ktm']['error'] == 0) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["foto_ktm"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["foto_ktm"]["tmp_name"]);
            if ($check === false) {
                echo "<div class='alert alert-danger'> File is not an image.</div>";
                $uploadOk = 0;
            }

            // Check file size (5MB max)
            if ($_FILES["foto_ktm"]["size"] > 5000000) {
                echo "<div class='alert alert-danger'> Sorry, your file is too large.</div>";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
                echo "<div class='alert alert-danger'> Sorry, only JPG, JPEG, PNG & GIF files are allowed.</div>";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 1) {
                if (move_uploaded_file($_FILES["foto_ktm"]["tmp_name"], $target_file)) {
                    $foto_ktm = $target_file; // Store the file path for the database
                } else {
                    echo "<div class='alert alert-danger'> Sorry, there was an error uploading your file.</div>";
                }
            }
        }

        // Prepare SQL for updating data
        $sql = "UPDATE peserta SET
            nama='$nama',
            universitas='$universitas',
            jurusan='$jurusan',
            no_hp='$no_hp'";

        // Only include the photo update if a new file was uploaded
        if ($foto_ktm) {
            $sql .= ", foto_ktm='$foto_ktm'";
        }

        $sql .= " WHERE id_peserta=$id_peserta";

        // Execute the query
        $hasil = mysqli_query($kon, $sql);

        // Check if the query was successful
        if ($hasil) {
            header("Location:index.php");
        } else {
            echo "<div class='alert alert-danger'> Data Gagal disimpan.</div>";
        }
    }
    ?>
    <h2>Update Data</h2>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Nama:</label>
            <input type="text" name="nama" class="form-control" placeholder="Masukan Nama" value="<?php echo htmlspecialchars($data['nama']); ?>" required />
        </div>
        <div class="form-group">
            <label>Universitas:</label>
            <input type="text" name="universitas" class="form-control" placeholder="Masukan Nama Universitas" value="<?php echo htmlspecialchars($data['universitas']); ?>" required/>
        </div>
        <div class="form-group">
            <label>Jurusan:</label>
            <input type="text" name="jurusan" class="form-control" placeholder="Masukan Jurusan" value="<?php echo htmlspecialchars($data['jurusan']); ?>" required/>
        </div>
        <div class="form-group">
            <label>No HP:</label>
            <input type="text" name="no_hp" class="form-control" placeholder="Masukan No HP" value="<?php echo htmlspecialchars($data['no_hp']); ?>" required/>
        </div>
        <div class="form-group">
            <label>Foto KTM:</label>
            <input type="file" name="foto_ktm" class="form-control" accept="image/*" />
            <small class="form-text text-muted">Upload foto KTM (jpg, jpeg, png, gif).</small>
        </div>

        <input type="hidden" name="id_peserta" value="<?php echo $data['id_peserta']; ?>" />

        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</body>
</html>
