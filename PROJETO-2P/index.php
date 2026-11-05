<?php
$banners = [
    ['img' => 'carrocel1.png', 'alt' => 'Banner de promoções 1'],
    ['img' => 'carrocel2.png', 'alt' => 'Banner de promoções 2'],
    ['img' => 'carrocel3.png', 'alt' => 'Banner de promoções 3'],
];

$produtos = [
    ['img' => 'carne.png',      'alt' => 'Carne fresca',       'de' => 39.90, 'por' => 32.90],
    ['img' => 'pao.png',        'alt' => 'Pão fresco',         'de' => 9.00,  'por' => 7.50],
    ['img' => 'energetico.png', 'alt' => 'Energético',         'de' => 7.99,  'por' => 5.99],
    ['img' => 'leite.png',      'alt' => 'Leite',              'de' => 5.29,  'por' => 4.49],
    ['img' => 'cafe.png',       'alt' => 'Café',               'de' => 15.90, 'por' => 12.90],
    ['img' => 'cerveja.png',    'alt' => 'Cerveja',            'de' => 4.99,  'por' => 3.99],
    ['img' => 'morango.png',    'alt' => 'Morangos frescos',   'de' => 8.90,  'por' => 6.90],
    ['img' => 'limpeza.png',    'alt' => 'Desinfetante Veja',  'de' => 5.49,  'por' => 4.29],
];

// formata o numero como dinheiro brasileiro
function moeda($valor) {
    return 'R$ ' . number_format($valor, 2, ',', '.');
}

include __DIR__ . '/inc/header.inc.php';
?>

<div class="container">

    <?php include __DIR__ . '/inc/menu-esq.inc.php'; ?>

    <main>
        <div class="carrossel">
            <?php foreach ($banners as $i => $b): ?>
                <img src="img/<?= $b['img'] ?>" alt="<?= $b['alt'] ?>" class="slide<?= $i === 0 ? ' ativo' : '' ?>">
            <?php endforeach; ?>
            <button type="button" id="anterior" class="seta esq">&lsaquo;</button>
            <button type="button" id="proximo" class="seta dir">&rsaquo;</button>
        </div>

        <h2 class="titulo">Promoções</h2>

        <div class="produtos">
            <?php foreach ($produtos as $id => $p): ?>
                <div class="produto" data-id="<?= $id ?>" data-nome="<?= $p['alt'] ?>" data-preco="<?= $p['por'] ?>" data-img="<?= $p['img'] ?>">
                    <img src="img/<?= $p['img'] ?>" alt="<?= $p['alt'] ?>">
                    <p>
                        de <span class="preco-antigo"><?= moeda($p['de']) ?></span><br>
                        por <span class="preco-novo"><?= moeda($p['por']) ?></span>
                    </p>
                    <button type="button" class="btn btn-adicionar">Adicionar</button>
                    <div class="controle-qtd escondido">
                        <button type="button" class="btn escuro btn-menos">-</button>
                        <span class="qtd">1</span>
                        <button type="button" class="btn escuro btn-mais">+</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</div>

<?php include __DIR__ . '/inc/footer.inc.php'; ?>
