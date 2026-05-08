<?php
require 'db.php';
require 'includes/header.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM livros WHERE id = ?");
$stmt->execute([$id]);
$livro = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$livro) {
    header('Location: index.php');
    exit;
}

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
        $capa = $livro['capa'];
        if (!empty($_FILES['capa']['name'])) {
            $capa = time() . '_' . $_FILES['capa']['name'];
            move_uploaded_file($_FILES['capa']['tmp_name'], 'uploads/' . $capa);
        }

        $stmt = $pdo->prepare("UPDATE livros SET titulo=?, autor=?, capa=?, avaliacao=?, resenha=?, frases=?, data_inicio=?, data_termino=? WHERE id=?");
        $stmt->execute([$titulo, $autor, $capa, $avaliacao, $resenha, $frases, $data_inicio, $data_termino, $id]);
        header('Location: detalhes.php?id=' . $id);
        exit;
    }
}
?>

<form action="editar.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data">

    <label>Título *</label>
    <input type="text" name="titulo" id="titulo" value="<?= htmlspecialchars($livro['titulo']) ?>">

    <label>Autor *</label>
    <input type="text" name="autor" id="autor" value="<?= htmlspecialchars($livro['autor']) ?>">

    <label>Capa atual</label>
    <?php if ($livro['capa']): ?>
        <img src="uploads/<?= $livro['capa'] ?>" alt="Capa" width="100">
    <?php endif; ?>
    <input type="file" name="capa" accept="image/*">

    <label>Avaliação *</label>
    <select name="avaliacao" id="avaliacao">
        <option value="">Selecione</option>
        <?php for ($i = 1; $i <= 5; $i++): ?>
            <option value="<?= $i ?>" <?= $livro['avaliacao'] == $i ? 'selected' : '' ?>>
                <?= str_repeat('⭐', $i) ?> <?= $i ?>
            </option>
        <?php endfor; ?>
    </select>

    <label>Resenha</label>
    <textarea name="resenha" rows="4"><?= htmlspecialchars($livro['resenha']) ?></textarea>

    <label>Frases marcantes</label>
    <textarea name="frases" rows="4"><?= htmlspecialchars($livro['frases']) ?></textarea>

    <label>Data de início</label>
    <input type="date" name="data_inicio" value="<?= $livro['data_inicio'] ?>">

    <label>Data de término</label>
    <input type="date" name="data_termino" value="<?= $livro['data_termino'] ?>">

    <button type="submit">Salvar Alterações</button>
</form>

<script src="script.js"></script>

<?php require 'includes/footer.php'; ?>