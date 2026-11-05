<?php
// lista dos setores, cada setor tem departamentos e cada departamento tem categorias
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
<aside class="side">
    <h2>Buscar Item</h2>
    <form action="index.php" method="get">
        <input type="search" name="busca" placeholder="O que você procura?">
        <button class="btn" type="submit">Buscar</button>
    </form>

    <h2 class="titulo">Departamentos</h2>

    <?php foreach ($setores as $setor => $departamentos): ?>
        <h3 class="setor"><?= $setor ?></h3>
        <?php foreach ($departamentos as $nome => $categorias): ?>
            <details>
                <summary><?= $nome ?></summary>
                <ul>
                    <?php foreach ($categorias as $categoria): ?>
                        <li><a href="#"><?= $categoria ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </details>
        <?php endforeach; ?>
    <?php endforeach; ?>
</aside>
