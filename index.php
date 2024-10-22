<?php
session_start(); // Inicia a sessão
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="post" action="login.php">
        Nome de Usuário: <input type="text" name="username" required><br>
        Senha: <input type="password" name="password" required><br>
        <input type="submit" value="Entrar">
    </form>
    <p>Ainda não tem uma conta? <a href="register.php">Registrar</a></p>
</body>
</html>
