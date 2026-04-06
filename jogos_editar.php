<?php
//jogos_editar.php

require('carregar_twig.php');
require('carregar_pdo.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int) $_POST['id'] ?? false;
    $nome = $_POST['nome'] ?? false;
    $estilo = $_POST['estilo'] ?? false;

    //verifica se há nova capa
    if (!$_FILES['capa']['error']) {
        
        //descobre o nome do arquivo anterior
        $dados = $pdo->prepare('SELECT capa FROM jogos WHERE id = :id');
        $dados->execute([':id' => $id]);
        $capa_velha = $dados->fetch(PDO::FETCH_ASSOC)['capa'];
        

        //apagar capa
        $capa_velha = __DIR__ . '/img/' . $capa_velha;
        if (file_exists($capa_velha)) {
            unlink($capa_velha);
        };

        //gravar a capa nova
        $ext = pathinfo($_FILES['capa']['name'], PATHINFO_EXTENSION);
        $capa = uniqid().'.'.$ext;
        move_uploaded_file($_FILES['capa']['tmp_name'], "img/{$capa}");
    };

    $dados = $pdo->prepare('UPDATE jogos SET nome= :nome, estilo= :estilo'.(isset($capa) ?', capa = :capa' : '').' WHERE id = :id');
    
    $params = [
        ':id' => $id,
        ':nome' => $nome,
        ':estilo' => $estilo,
    ];

    if(isset($capa)) {$params[':capa'] = $capa;}
    $dados->execute($params);

    header('location:jogos.php');
    die;
}


$id = (int) $_GET['id'] ?? false;

if (!$id) {
    header('location:jogos.php');
    die;
}

require('carregar_pdo.php');

$dados = $pdo->prepare('SELECT * FROM jogos WHERE id = :id');
$dados->execute([':id' => $id]);

if ($dados->rowCount() != 1) {
    header('location:jogos.php');
    die;
}

$jogo = $dados->fetch(PDO::FETCH_ASSOC);

echo $twig->render('jogos_editar.html', [
    'jogo' => $jogo,
]);
