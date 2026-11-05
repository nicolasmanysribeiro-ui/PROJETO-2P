<?php
$setores = [
    'Setor de Alimentos Frescos' => [
        'Horti-Frúti' => ['Frutas', 'Legumes', 'Verduras', 'Temperos'],
        'Padaria' => ['Pão', 'Bolo', 'Salgados', 'Doces'],
        'Açougue' => ['Carnes Vermelhas', 'Aves', 'Peixes', 'Suínos'],
        'Frios e Laticínios' => ['Queijo', 'Presunto', 'Iogurte', 'Manteiga', 'Leite'],
    ],
    'Setor de Despensa e Bebidas' => [
        'Mercearia' => ['Arroz', 'Feijão', 'Massas', 'Óleos', 'Açúcar', 'Café', 'Empanados'],
        'Bebidas' => ['Águas', 'Sucos', 'Refrigerantes', 'Cerveja', 'Vinhos', 'Destilados'],
        'Congelados' => ['Pratos Prontos', 'Pizzas', 'Pão de Queijo', 'Vegetais Congelados'],
    ],
    'Setor de Uso Pessoal e da Casa' => [
        'Higiene e Perfumaria' => ['Sabonetes', 'Shampoos', 'Cremes', 'Desodorantes', 'Papel Higiênico'],
        'Limpeza' => ['Sabão em Pó', 'Desinfetante', 'Amaciantes', 'Esponjas'],
        'Utilidades e Pet Shop' => ['Ração', 'Sachês', 'Brinquedos', 'Petiscos', 'Sacos de Lixo', 'Roupas de Pet'],
    ],
];
?>
<aside class="col-lg-3 side p-3">
    <section class="mb-4">
        <h2 class="h5">Buscar Item</h2>
        <form class="input-group" role="search" action="index.php" method="get">
            <input type="search" name="busca" class="form-control" placeholder="O que você procura?" aria-label="Buscar item">
            <button class="btn btn-shelfy" type="submit">Buscar 🔍</button>
        </form>
    </section>

    <button class="btn btn-shelfy w-100 d-lg-none mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#departamentos" aria-expanded="false" aria-controls="departamentos">
        Departamentos
    </button>

    <section class="collapse d-lg-block" id="departamentos">
        <h2 class="h5 titulo-secao text-center p-3 rounded shadow mb-3">Departamentos</h2>

        <?php $s = 0; foreach ($setores as $setor => $departamentos): $s++; ?>
            <h3 class="h6 titulo-setor p-2 rounded shadow-sm"><?= $setor ?></h3>
            <div class="accordion accordion-flush mb-4" id="setor<?= $s ?>" data-bs-theme="dark">
                <?php $d = 0; foreach ($departamentos as $nome => $categorias): $d++; $id = "setor{$s}dep{$d}"; ?>
                    <div class="accordion-item">
                        <h4 class="accordion-header">
                            <button class="accordion-button collapsed py-2" type="button" data-bs-toggle="collapse" data-bs-target="#<?= $id ?>" aria-expanded="false" aria-controls="<?= $id ?>">
                                <?= $nome ?>
                            </button>
                        </h4>
                        <div id="<?= $id ?>" class="accordion-collapse collapse" data-bs-parent="#setor<?= $s ?>">
                            <ul class="list-unstyled mb-0 px-3 py-2">
                                <?php foreach ($categorias as $categoria): ?>
                                    <li><a class="d-block py-1 link-light link-underline-opacity-0 link-underline-opacity-75-hover" href="#"><?= $categoria ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </section>
</aside>
