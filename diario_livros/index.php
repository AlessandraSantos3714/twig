<?php
require 'db.php';
require 'includes/header.php';

$busca = trim($_GET['busca'] ?? '');

if ($busca !== '') {
    $stmt = $pdo->prepare("SELECT * FROM livros WHERE usuario_id = ? AND (titulo LIKE ? OR autor LIKE ?) ORDER BY id DESC");
    $stmt->execute([$_SESSION['usuario_id'], "%$busca%", "%$busca%"]);
} else {
    $stmt = $pdo->prepare("SELECT * FROM livros WHERE usuario_id = ? ORDER BY id DESC");
    $stmt->execute([$_SESSION['usuario_id']]);
}

$livros = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<form action="index.php" method="GET">
    <input type="text" name="busca" placeholder="Pesquisar por título ou autor..." value="<?= htmlspecialchars($busca) ?>">
    <button type="submit">🔍 Pesquisar</button>
    <?php if ($busca): ?>
        <a href="index.php">Limpar</a>
    <?php endif; ?>
</form>

<?php if (count($livros) === 0): ?>
    <p>Nenhum livro encontrado.</p>
<?php else: ?>
    <div class="grid">
        <?php foreach ($livros as $livro): ?>
            <div class="card">
                <?php if ($livro['capa']): ?>
                    <img src="uploads/<?= $livro['capa'] ?>" alt="Capa">
                <?php endif; ?>
                <h2><?= htmlspecialchars($livro['titulo']) ?></h2>
                <p><?= htmlspecialchars($livro['autor']) ?></p>
                <p>⭐ <?= $livro['avaliacao'] ?>/5</p>
                <a href="detalhes.php?id=<?= $livro['id'] ?>">Ver detalhes</a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php require 'includes/footer.php'; ?>