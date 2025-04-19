<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Bukti Transfer</title>
</head>
<body>
    <h2>Upload Bukti Transfer</h2>
    <form action="upload_process.php" method="POST" enctype="multipart/form-data">
        <label for="nama">Nama Customer:</label><br>
        <input type="text" name="nama" required><br><br>
        
        <label for="bukti">Upload Bukti Transfer:</label><br>
        <input type="file" name="bukti" accept="image/*" required><br><br>
        
        <button type="submit">Upload</button>
    </form>
</body>
</html>
