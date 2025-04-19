<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $uploadDir = "uploads/";

    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileName = basename($_FILES["bukti"]["name"]);
    $filePath = $uploadDir . time() . "_" . $fileName;
    $fileType = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
    $allowedTypes = ['jpg', 'jpeg', 'png', 'pdf'];

    if (in_array($fileType, $allowedTypes)) {
        if (move_uploaded_file($_FILES["bukti"]["tmp_name"], $filePath)) {
            $db = new mysqli("localhost", "root", "", "database_gelang");

            if ($db->connect_error) {
                die("Koneksi gagal: " . $db->connect_error);
            }

            $stmt = $db->prepare("INSERT INTO bukti_transfer (nama_customer, file_path) VALUES (?, ?)");
            $stmt->bind_param("ss", $nama, $filePath);

            if ($stmt->execute()) {
                $_SESSION['message'] = "Bukti transfer berhasil diunggah.";
            } else {
                $_SESSION['message'] = "Gagal menyimpan data.";
            }

            $stmt->close();
            $db->close();
        } else {
            $_SESSION['message'] = "Gagal mengunggah file.";
        }
    } else {
        $_SESSION['message'] = "Format file tidak didukung.";
    }
    header("Location: upload_bukti.php");
    exit();
}
?>
