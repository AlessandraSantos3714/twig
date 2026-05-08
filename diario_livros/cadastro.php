<?php
require 'db.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $confirmar = $_POST['confirmar'];

    if (empty($nome) || empty($email) || empty($senha)) {
        $erro = 'Todos os campos são obrigatórios!';
    } elseif ($senha !== $confirmar) {
        $erro = 'As senhas não coincidem!';
    } elseif (strlen($senha) < 6) {
        $erro = 'A senha deve ter pelo menos 6 caracteres!';
    } else {
        
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $erro = 'Este email já está cadastrado!';
        } else {
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
            $stmt->execute([$nome, $email, $senha_hash]);
            header('Location: login.php');
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="auth-container">
    <h2>Criar conta</h2>

    <?php if ($erro): ?>
        <p style="color:red"><?= $erro ?></p>
    <?php endif; ?>

    <form action="cadastro.php" method="POST">
        <label>Nome</label>
        <input type="text" name="nome" id="nome">

        <label>Email</label>
        <input type="email" name="email" id="email">

        <label>Senha</label>
        <input type="password" name="senha" id="senha">

        <label>Confirmar senha</label>
        <input type="password" name="confirmar" id="confirmar">

        <button type="submit">Cadastrar</button>
    </form>

    <p>Já tem conta? <a href="login.php">Entrar</a></p>
</div>

<script src="script.js"></script>
</body>
</html>