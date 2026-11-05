    <footer>
        <p>&copy; <?= date('Y') ?> Shelfy - Todos os direitos reservados</p>
    </footer>

    <script src="js/loja.js"></script>
    <?php if (isset($extraJs)): ?>
        <script src="<?= $extraJs ?>"></script>
    <?php endif; ?>
</body>
</html>
