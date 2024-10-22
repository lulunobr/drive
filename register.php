<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root"; // Verifique suas credenciais aqui
$password = "cielopulse";
$dbname = "meu_sistema_de_arquivos";

// Conecte ao banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifique se a conexão falhou
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Verifica se o nome de usuário ou senha estão vazios
    if (empty($user) || empty($pass)) {
        echo "Por favor, preencha todos os campos.";
    } else {
        // Hash da senha
        $pass_hashed = password_hash($pass, PASSWORD_DEFAULT);

        // Preparar a inserção no banco de dados
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $user, $pass_hashed);

        // Verificar se a inserção foi bem-sucedida
        if ($stmt->execute()) {
            echo "Registro criado com sucesso!";
            echo '<br><a href="index.php">Voltar ao Login</a>';
        } else {
            echo "Erro: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Registrar</title>
</head>
<body>
    <h2>Registrar Novo Usuário</h2>
    <form method="post" action="">
        Nome de Usuário: <input type="text" name="username" required><br>
        Senha: <input type="password" name="password" required><br>
        <input type="submit" value="Registrar">
    </form>
    <p>Já tem uma conta? <a href="index.php">Login</a></p>
</body>
</html>
