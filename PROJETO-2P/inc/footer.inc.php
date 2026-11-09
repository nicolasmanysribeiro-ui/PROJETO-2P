    <?php if (!isset($semBarra)): ?>
        <a href="carrinho.php" id="barraSacola" class="barra-sacola escondido">
            <span>🛒 <b id="barraItens">0</b> itens</span>
            <span>Ver sacola</span>
            <b id="barraTotal"></b>
        </a>
    <?php endif; ?>

    <footer>
        <p>&copy; <?= date('Y') ?> Shelfy - Todos os direitos reservados</p>
    </footer>

    <script src="js/loja.js"></script>
    <?php if (isset($extraJs)): ?>
        <script src="<?= $extraJs ?>"></script>
    <?php endif; ?>
</body>
</html>
