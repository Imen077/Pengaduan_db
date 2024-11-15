

<?php
session_start();
include 'db.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// Proses pengiriman pengaduan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil dan membersihkan input pengaduan
    $complaint = htmlspecialchars(trim($_POST['complaint']));
    
    // Pastikan user_id ada di session
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // Simpan pengaduan ke dalam database
        $stmt = $conn->prepare("INSERT INTO complaints (user_id, complaint) VALUES (?, ?)");
        if ($stmt) {
            $stmt->bind_param("is", $user_id, $complaint);
            
            if ($stmt->execute()) {
                echo "<h1>Pengaduan Anda telah dikirim!</h1>";
            } else {
                echo "Error saat menyimpan pengaduan: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error dalam persiapan statement: " . $conn->error;
        }
    } else {
        echo "User  ID tidak ditemukan dalam session.";
    }
} else {
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kirim Pengaduan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Form Pengaduan</h1>
    <form action="submit.php" method="post">
        <label for="complaint">Pengaduan:</label><br>
        <textarea id="complaint" name="complaint" required></textarea><br><br>
        
        <input type="submit" value="Kirim Pengaduan">
    </form>
    <a href="view.php">Lihat Pengaduan</a>
    <a href="logout.php">Logout</a>
</body>
</html>
<?php
}
$conn->close();
?>