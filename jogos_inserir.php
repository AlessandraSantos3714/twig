<?php
//jogos_inserir.php
$erro = false;

if($_SERVER["REQUEST_METHOD"] == 'POST'){
    //preparar os dados para inserir no banco
    $nome = $_POST['nome'] ?? false;
    $estilo = $_POST['estilo'] ?? false;

        if(!$nome || !$estilo){
            $erro = 'Preencha todos os campos';
    } else{
        //tudo certo - gravar os dados
        //impotart pdo
    }
}

require('carregar_twig.php');

echo $twig->render('jogos_inserir.html', [
    'erro' => $erro,
]);