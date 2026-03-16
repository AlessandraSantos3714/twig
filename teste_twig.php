<?php
// teste_twig.php
require('carregar_twig.php');

$nome = 'Sr. Fulano';
$disciplinas = [
    'programaçõa',
    'banco de dados',
    'interface web',
    'desenvolvimento de sistemas',
];

echo $twig->render('teste_twig.html', [
    'nome'=> $nome,
    'legal' => true,
    'disciplinas' => $disciplinas
]);