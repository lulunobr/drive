<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "cielopulse";
$dbname = "meu_sistema_de_arquivos";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $stmt = $conn->prepare("SELECT password FROM users WHERE username=?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($pass, $row['password'])) {
            $_SESSION['username'] = $user; // Salva o nome de usuário na sessão
            header('Location: upload.php'); // Redireciona para a página de upload
            exit();
        } else {
            echo "Senha incorreta!";
        }
    } else {
        echo "Usuário não encontrado!";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="post" action="">
        Nome de Usuário: <input type="text" name="username" required><br>
        Senha: <input type="password" name="password" required><br>
        <input type="submit" value="Entrar">
    </form>
    <p>Ainda não tem uma conta? <a href="register.php">Registrar</a></p>
</body>
</html>
