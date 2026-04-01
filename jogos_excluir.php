<?php
//jogos_excluir.php
require('carregar_twig.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require('carregar_pdo.php');
    $id = (int) $_POST["id"] ?? false;   
    if ($id){
        $excluir = $pdo->prepare('DELETE FROM jogos WHERE id = :id');
        $excluir->bindParam(':id', $id);
        $excluir->execute();
    } 
    header('location:jogos.php');
}


$id = (int) $_GET["id"] ?? false;
require('carregar_twig.php');

if (!$id) {
    header('location:jogos.php');
    die;
};


require('carregar_pdo.php');

$dados = $pdo->prepare('SELECT * FROM jogos WHERE id= :id');
$dados->execute([':id' => $id]);

if($dados->rowCount() !=1) {
    header('location: jogos.php');
    die;
};

$jogo = $dados->fetch(PDO::FETCH_ASSOC);

echo $twig->render('jogos_excluir.html', [
    'jogo' => $jogo
]);