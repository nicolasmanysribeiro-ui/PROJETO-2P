<?php
include __DIR__ . '/inc/produtos.inc.php';

$banners = [
    ['img' => 'carrocel1.png', 'alt' => 'Banner de promoções 1'],
    ['img' => 'carrocel2.png', 'alt' => 'Banner de promoções 2'],
    ['img' => 'carrocel3.png', 'alt' => 'Banner de promoções 3'],
];

// pega o que veio na url, categoria do menu ou palavra da busca
$cat = $_GET['cat'] ?? '';
$busca = trim($_GET['busca'] ?? '');

// escolhe quais produtos mostrar: categoria, busca ou promocoes
$lista = [];
foreach ($produtos as $p) {
    if ($cat !== '') {
        if ($p['cat'] === $cat) { $lista[] = $p; }
    } elseif ($busca !== '') {
        if (mb_stripos($p['nome'], $busca) !== false || mb_stripos($p['cat'], $busca) !== false) { $lista[] = $p; }
    } elseif ($p['de'] > 0) {
        $lista[] = $p;
    }
}

if ($cat !== '') { $titulo = $cat; }
elseif ($busca !== '') { $titulo = 'Resultados para ' . h($busca); }
else { $titulo = 'Promoções'; }

include __DIR__ . '/inc/header.inc.php';
?>

<div class="container">

    <?php include __DIR__ . '/inc/menu-esq.inc.php'; ?>

    <main>
        <?php if ($cat === '' && $busca === ''): ?>
            <div class="carrossel">
                <?php foreach ($banners as $i => $b): ?>
                    <img src="img/<?= $b['img'] ?>" alt="<?= $b['alt'] ?>" class="slide<?= $i === 0 ? ' ativo' : '' ?>">
                <?php endforeach; ?>
                <button type="button" id="anterior" class="seta esq">&lsaquo;</button>
                <button type="button" id="proximo" class="seta dir">&rsaquo;</button>
            </div>
        <?php endif; ?>

        <h2 class="titulo"><?= $titulo ?></h2>

        <?php if (count($lista) === 0): ?>
            <p class="vazio">Nenhum produto encontrado. Tente outra categoria ou palavra.</p>
        <?php endif; ?>

        <div class="produtos">
            <?php foreach ($lista as $p): ?>
                <div class="produto" data-id="<?= $p['id'] ?>" data-nome="<?= h($p['nome']) ?>" data-preco="<?= $p['preco'] ?>" data-emoji="<?= $p['emoji'] ?>">
                    <?php if ($p['de'] > 0): ?>
                        <span class="selo">-<?= round(($p['de'] - $p['preco']) / $p['de'] * 100) ?>%</span>
                    <?php endif; ?>
                    <div class="emoji"><?= $p['emoji'] ?></div>
                    <h3><?= h($p['nome']) ?></h3>
                    <p class="precos">
                        <?php if ($p['de'] > 0): ?>
                            <span class="preco-antigo"><?= moeda($p['de']) ?></span>
                        <?php endif; ?>
                        <span class="preco-novo"><?= moeda($p['preco']) ?></span>
                    </p>
                    <button type="button" class="btn btn-adicionar">Adicionar</button>
                    <div class="stepper controle-qtd escondido">
                        <button type="button" class="btn-menos">−</button>
                        <span class="qtd">1</span>
                        <button type="button" class="btn-mais">+</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</div>

<?php include __DIR__ . '/inc/footer.inc.php'; ?>
