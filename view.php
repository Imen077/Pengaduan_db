<?php
session_start();
include 'db.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// Ambil pengaduan dari database
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM complaints WHERE user_id = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<h1>Daftar Pengaduan Anda</h1>";
        echo "<table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Pengaduan</th>
                    <th>Tanggal</th>
                </tr>";
        
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['id']) . "</td>
                    <td>" . htmlspecialchars($row['complaint']) . "</td>
                    <td>" . htmlspecialchars($row['created_at']) . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<h1>Tidak ada pengaduan yang ditemukan.</h1>";
    }

    $stmt->close();
} else {
    echo "Error dalam persiapan statement: " . $conn->error;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Pengaduan</title>
</head>
<body>
    <a href="submit.php">Kirim Pengaduan</a>
    <a href="logout.php">Logout</a>
</body>
</html>