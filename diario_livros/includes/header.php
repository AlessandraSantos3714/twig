<?php
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diário de Leituras</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1> Meu Diário de Leituras</h1>
    <div id="menu">
        <span>Olá, <?= $_SESSION['usuario_nome'] ?>!</span>
        <a href="index.php">Início</a>
        <a href="form.php">+ Adicionar Livro</a>
        <a href="logout.php">Sair</a>
    </div>
</header>

<div id="conteudo">