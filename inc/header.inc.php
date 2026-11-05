<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shelfy - Compre em nosso supermercado</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="img/favicon.png">
</head>
<body class="d-flex flex-column min-vh-100">
    <header>
        <nav class="navbar navbar-expand-md navbar-dark bg-shelfy">
            <div class="container-fluid">
                <a class="navbar-brand order-1" href="index.php">
                    <img src="img/logo.png" alt="Shelfy" class="logo">
                </a>

                <a href="carrinho.php" class="position-relative ms-auto order-2 order-md-3" aria-label="Carrinho de compras">
                    <img src="img/carrinho.png" alt="Carrinho de compras" class="icone-carrinho">
                    <span id="contadorCarrinho" class="badge rounded-pill text-bg-dark position-absolute top-0 start-100 translate-middle">0</span>
                </a>

                <button class="navbar-toggler order-3 order-md-4 ms-3" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal" aria-controls="menuPrincipal" aria-expanded="false" aria-label="Abrir menu">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse order-4 order-md-2" id="menuPrincipal">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item"><a class="nav-link" href="index.php">Início</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Cadastrar</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Produtos</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Sobre</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Contatos</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Ajuda</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
