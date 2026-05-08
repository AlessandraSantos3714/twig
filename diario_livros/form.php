<?php
require 'db.php';
require 'includes/header.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo']);
    $autor = trim($_POST['autor']);
    $avaliacao = $_POST['avaliacao'];
    $resenha = trim($_POST['resenha']);
    $frases = trim($_POST['frases']);
    $data_inicio = $_POST['data_inicio'];
    $data_termino = $_POST['data_termino'];

    if (empty($titulo) || empty($autor) || empty($avaliacao)) {
        $erro = 'Título, autor e avaliação são obrigatórios!';
    } else {

        $capa = '';
        if (!empty($_FILES['capa']['name'])) {
            $capa = time() . '_' . $_FILES['capa']['name'];
            move_uploaded_file($_FILES['capa']['tmp_name'], 'uploads/' . $capa);
        }

       $stmt = $pdo->prepare("INSERT INTO livros (titulo, autor, capa, avaliacao, resenha, frases, data_inicio, data_termino, usuario_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$titulo, $autor, $capa, $avaliacao, $resenha, $frases, $data_inicio, $data_termino, $_SESSION['usuario_id']]);
        header('Location: index.php');
        exit;
    }
}
?>

<form action="form.php" method="POST" enctype="multipart/form-data">
    <label>Título *</label>
    <input type="text" name="titulo" id="titulo">

    <label>Autor *</label>
    <input type="text" name="autor" id="autor">

    <label>Capa do livro</label>
    <input type="file" name="capa" accept="image/*">

    <label>Avaliação *</label>
    <select name="avaliacao" id="avaliacao">
        <option value="">Selecione</option>
        <option value="1">⭐ 1</option>
        <option value="2">⭐⭐ 2</option>
        <option value="3">⭐⭐⭐ 3</option>
        <option value="4">⭐⭐⭐⭐ 4</option>
        <option value="5">⭐⭐⭐⭐⭐ 5</option>
    </select>

    <label>Resenha</label>
    <textarea name="resenha" rows="4"></textarea>

    <label>Frases marcantes</label>
    <textarea name="frases" rows="4"></textarea>

    <label>Data de início</label>
    <input type="date" name="data_inicio">

    <label>Data de término</label>
    <input type="date" name="data_termino">

    <button type="submit">Salvar Livro</button>
</form>

<script src="script.js"></script>

<?php require 'includes/footer.php'; ?>