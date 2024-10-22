<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php'); // Redireciona se não estiver logado
    exit();
}

$servername = "localhost";
$username = "root";
$password = "cielopulse";
$dbname = "meu_sistema_de_arquivos";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT filename, filepath FROM files";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Meus Arquivos</title>
</head>
<body>
    <h2>Meus Arquivos</h2>
    <ul>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<li><a href="'.$row['filepath'].'" download>'.$row['filename'].'</a></li>';
            }
        } else {
            echo '<li>Nenhum arquivo encontrado.</li>';
        }
        ?>
    </ul>
    <p><a href="upload.php">Upload Novo Arquivo</a></p>
    <p><a href="index.php">Sair</a></p>
</body>
</html>
