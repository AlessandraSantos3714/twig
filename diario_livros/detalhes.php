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
?>

<div class="detalhes">

    <?php if ($livro['capa']): ?>
        <img src="uploads/<?= $livro['capa'] ?>" alt="Capa do livro">
    <?php endif; ?>

    <h2><?= htmlspecialchars($livro['titulo']) ?></h2>
    <p><strong>Autor:</strong> <?= htmlspecialchars($livro['autor']) ?></p>
    <p><strong>Avaliação:</strong> ⭐ <?= $livro['avaliacao'] ?>/5</p>

    <?php if ($livro['data_inicio']): ?>
        <p><strong>Início da leitura:</strong> <?= date('d/m/Y', strtotime($livro['data_inicio'])) ?></p>
    <?php endif; ?>

    <?php if ($livro['data_termino']): ?>
        <p><strong>Término da leitura:</strong> <?= date('d/m/Y', strtotime($livro['data_termino'])) ?></p>
    <?php endif; ?>

    <?php if ($livro['resenha']): ?>
        <h3>Minha Resenha</h3>
        <p><?= nl2br(htmlspecialchars($livro['resenha'])) ?></p>
    <?php endif; ?>

    <?php if ($livro['frases']): ?>
        <h3>Frases Marcantes</h3>
        <p><?= nl2br(htmlspecialchars($livro['frases'])) ?></p>
    <?php endif; ?>

    <div class="acoes">
        <a href="editar.php?id=<?= $livro['id'] ?>">✏️ Editar</a>
        <a href="deletar.php?id=<?= $livro['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir este livro?')">🗑️ Excluir</a>
    </div>

</div>

<?php require 'includes/footer.php'; ?>