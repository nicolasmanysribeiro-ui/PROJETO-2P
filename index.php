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

function moeda($valor) {
    return 'R$ ' . number_format($valor, 2, ',', '.');
}

include __DIR__ . '/inc/header.inc.php';
?>

<div class="container-fluid px-0 flex-grow-1">
    <div class="row g-0">

        <?php include __DIR__ . '/inc/menu-esq.inc.php'; ?>

        <main class="col-lg-9 p-3">

            <div id="banner" class="carousel slide mb-4" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <?php foreach ($banners as $i => $b): ?>
                        <button type="button" data-bs-target="#banner" data-bs-slide-to="<?= $i ?>"<?= $i === 0 ? ' class="active" aria-current="true"' : '' ?> aria-label="Banner <?= $i + 1 ?>"></button>
                    <?php endforeach; ?>
                </div>

                <div class="carousel-inner rounded">
                    <?php foreach ($banners as $i => $b): ?>
                        <div class="carousel-item<?= $i === 0 ? ' active' : '' ?>" data-bs-interval="4000">
                            <img src="img/<?= $b['img'] ?>" class="d-block w-100" alt="<?= $b['alt'] ?>">
                        </div>
                    <?php endforeach; ?>
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#banner" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#banner" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Próximo</span>
                </button>
            </div>

            <h2 class="titulo-secao text-center p-3 rounded shadow mb-4">Promoções</h2>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-4 g-3">
                <?php foreach ($produtos as $p): ?>
                    <div class="col">
                        <div class="card produto h-100 text-center text-bg-dark">
                            <img src="img/<?= $p['img'] ?>" class="card-img-top produto-img" alt="<?= $p['alt'] ?>">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <p class="preco fw-bold fs-5">
                                    de <span class="preco-antigo fw-normal"><?= moeda($p['de']) ?></span><br>
                                    por <span class="preco-novo"><?= moeda($p['por']) ?></span>
                                </p>
                                <div class="acao-produto" data-quantidade="0">
                                    <button type="button" class="btn btn-shelfy btn-adicionar">Adicionar</button>
                                    <div class="controle-qtd d-flex d-none justify-content-center align-items-center gap-3">
                                        <button type="button" class="btn btn-shelfy btn-menos" aria-label="Diminuir quantidade">-</button>
                                        <span class="qtd fw-bold">1</span>
                                        <button type="button" class="btn btn-shelfy btn-mais" aria-label="Aumentar quantidade">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </main>
    </div>
</div>

<script src="js/loja.js"></script>

<?php include __DIR__ . '/inc/footer.inc.php'; ?>
