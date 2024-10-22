<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php'); // Redireciona se não estiver logado
    exit();
}

$target_dir = "uploads/";

// Verifica o tipo do arquivo e define o diretório correto
$fileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));

switch ($fileType) {
    case "mp3":
    case "wav":
    case "flac":
        $target_dir .= "audio/";
        break;
    case "mp4":
    case "avi":
    case "mov":
        $target_dir .= "video/";
        break;
    case "jpg":
    case "jpeg":
    case "png":
    case "gif":
        $target_dir .= "images/";
        break;
    default:
        $target_dir .= "other/";
        break;
}

$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

$servername = "localhost";
$username = "root";
$password = "cielopulse";
$dbname = "meu_sistema_de_arquivos";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $file = $_FILES['fileToUpload'];
    
    // Verifica se o arquivo é um tipo permitido
    $allowedTypes = ['image/jpeg', 'image/png', 'audio/mpeg', 'video/mp4', 'application/zip', 'application/x-rar-compressed', 'application/octet-stream'];
    
    if (in_array($file['type'], $allowedTypes)) {
        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            // Salvar informações do arquivo no banco de dados
            $stmt = $conn->prepare("INSERT INTO files (filename, filepath) VALUES (?, ?)");
            $stmt->bind_param("ss", $file['name'], $target_file);
            $stmt->execute();
            echo "Arquivo enviado com sucesso!";
        } else {
            echo "Erro ao enviar o arquivo.";
        }
    } else {
        echo "Tipo de arquivo não permitido.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Upload de Arquivos</title>
</head>
<body>
    <h2>Upload de Arquivos</h2>
    <form method="post" action="" enctype="multipart/form-data">
        Selecione o arquivo para enviar:
        <input type="file" name="fileToUpload" required>
        <input type="submit" value="Upload">
    </form>
    <p><a href="files.php">Ver Arquivos</a></p>
    <p><a href="index.php">Sair</a></p>
</body>
</html>
