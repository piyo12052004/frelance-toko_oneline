<?php
$db = new mysqli("localhost", "root", "", "shop_db");

if ($db->connect_error) {
    die("Koneksi gagal: " . $db->connect_error);
}

$result = $db->query("SELECT * FROM bukti_transfer ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Bukti Transfer</title>
</head>
<body>
    <h2>Daftar Bukti Transfer</h2>
    <table border="1">
        <tr>
            <th>Nama Customer</th>
            <th>Bukti Transfer</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= htmlspecialchars($row['nama_customer']) ?></td>
                <td><img src="<?= $row['file_path'] ?>" width="150"></td>
                <td><a href="<?= $row['file_path'] ?>" download>Download</a></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>

<?php
$db->close();
?>
