<?php
// setores, departamentos e categorias, os nomes das categorias precisam ser iguais aos do catalogo
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

// categoria que ta aberta agora, vem do link
$catAtual = $_GET['cat'] ?? '';
?>
<aside class="side">
    <h2>Buscar Item</h2>
    <form action="index.php" method="get">
        <input type="search" name="busca" placeholder="O que você procura?" value="<?= htmlspecialchars($_GET['busca'] ?? '') ?>">
        <button class="btn" type="submit">Buscar</button>
    </form>

    <a href="index.php" class="link-promo">🏷️ Promoções</a>

    <?php foreach ($setores as $setor => $departamentos): ?>
        <h3 class="setor"><?= $setor ?></h3>
        <?php foreach ($departamentos as $nome => $categorias): ?>
            <details <?= in_array($catAtual, $categorias) ? 'open' : '' ?>>
                <summary><?= $nome ?></summary>
                <ul>
                    <?php foreach ($categorias as $categoria): ?>
                        <li><a href="index.php?cat=<?= urlencode($categoria) ?>" class="<?= $categoria === $catAtual ? 'atual' : '' ?>"><?= $categoria ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </details>
        <?php endforeach; ?>
    <?php endforeach; ?>
</aside>
