<?php
// catalogo: categoria => lista de produtos, cada produto e [emoji, nome, preco, preco antigo opcional]
// quando tem preco antigo ele aparece na pagina de promocoes
$catalogo = [
    'Frutas' => [['🍓', 'Morangos frescos', 6.90, 8.90], ['🍎', 'Maçã Fuji kg', 7.90]],
    'Legumes' => [['🥕', 'Cenoura kg', 4.50], ['🍅', 'Tomate kg', 6.20]],
    'Verduras' => [['🥬', 'Alface crespa', 3.50]],
    'Temperos' => [['🌿', 'Cheiro-verde maço', 2.99]],

    'Pão' => [['🥖', 'Pão fresco kg', 7.50, 9.00]],
    'Bolo' => [['🍰', 'Bolo de cenoura fatia', 6.50]],
    'Salgados' => [['🥐', 'Folhado de queijo', 5.90]],
    'Doces' => [['🍩', 'Rosquinha glaceada', 4.20]],

    'Carnes Vermelhas' => [['🥩', 'Carne fresca kg', 32.90, 39.90]],
    'Aves' => [['🍗', 'Coxa e sobrecoxa kg', 12.90]],
    'Peixes' => [['🐟', 'Filé de tilápia kg', 34.90]],
    'Suínos' => [['🥓', 'Bacon fatiado 250g', 14.90]],

    'Queijo' => [['🧀', 'Queijo mussarela 200g', 11.90]],
    'Presunto' => [['🍖', 'Presunto fatiado 200g', 9.90]],
    'Iogurte' => [['🥣', 'Iogurte natural 170g', 3.49]],
    'Manteiga' => [['🧈', 'Manteiga 200g', 12.50]],
    'Leite' => [['🥛', 'Leite integral 1L', 4.49, 5.29]],

    'Arroz' => [['🍚', 'Arroz branco 5kg', 28.90]],
    'Feijão' => [['🫘', 'Feijão carioca 1kg', 8.90]],
    'Massas' => [['🍝', 'Macarrão espaguete 500g', 4.99]],
    'Óleos' => [['🫒', 'Azeite de oliva 500ml', 32.00]],
    'Açúcar' => [['🍬', 'Açúcar cristal 1kg', 4.80]],
    'Café' => [['☕', 'Café torrado 500g', 12.90, 15.90]],
    'Empanados' => [['🍤', 'Nuggets de frango 300g', 13.90]],

    'Águas' => [['💧', 'Água mineral 1,5L', 2.50]],
    'Sucos' => [['🧃', 'Suco de laranja 1L', 7.90]],
    'Refrigerantes' => [['⚡', 'Energético 269ml', 5.99, 7.99], ['🥤', 'Refrigerante cola 2L', 9.50]],
    'Cerveja' => [['🍺', 'Cerveja lata 350ml', 3.99, 4.99]],
    'Vinhos' => [['🍷', 'Vinho tinto 750ml', 39.90]],
    'Destilados' => [['🥃', 'Whisky 1L', 89.90]],

    'Pratos Prontos' => [['🍱', 'Lasanha congelada 600g', 18.90]],
    'Pizzas' => [['🍕', 'Pizza mussarela', 22.90]],
    'Pão de Queijo' => [['🥯', 'Pão de queijo 400g', 14.90]],
    'Vegetais Congelados' => [['🥦', 'Brócolis congelado 300g', 7.50]],

    'Sabonetes' => [['🧼', 'Sabonete 85g', 2.20]],
    'Shampoos' => [['🧴', 'Shampoo 350ml', 15.90]],
    'Cremes' => [['💆', 'Creme hidratante 200ml', 13.90]],
    'Desodorantes' => [['💨', 'Desodorante aerosol', 11.90]],
    'Papel Higiênico' => [['🧻', 'Papel higiênico 12 rolos', 17.90]],

    'Sabão em Pó' => [['🧺', 'Sabão em pó 1,6kg', 19.90]],
    'Desinfetante' => [['🧪', 'Desinfetante Veja 500ml', 4.29, 5.49]],
    'Amaciantes' => [['🌸', 'Amaciante 2L', 12.90]],
    'Esponjas' => [['🧽', 'Esponja multiuso 3un', 4.50]],

    'Ração' => [['🐶', 'Ração para cães 10kg', 89.90]],
    'Sachês' => [['🐱', 'Sachê para gatos 85g', 2.90]],
    'Brinquedos' => [['🎾', 'Bolinha para pets', 9.90]],
    'Petiscos' => [['🦴', 'Osso petisco', 6.90]],
    'Sacos de Lixo' => [['🗑️', 'Saco de lixo 30L 30un', 10.90]],
    'Roupas de Pet' => [['🧥', 'Casaquinho para pets', 29.90]],
];

// monta a lista unica de produtos e ja da um numero id pra cada um
$produtos = [];
$id = 0;
foreach ($catalogo as $categoria => $itens) {
    foreach ($itens as $i) {
        $id++;
        $produtos[] = [
            'id' => $id,
            'cat' => $categoria,
            'emoji' => $i[0],
            'nome' => $i[1],
            'preco' => $i[2],
            'de' => $i[3] ?? 0,
        ];
    }
}

// formata como dinheiro brasileiro
function moeda($valor) {
    return 'R$ ' . number_format($valor, 2, ',', '.');
}

// protege o texto antes de mostrar na pagina
function h($texto) {
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}
