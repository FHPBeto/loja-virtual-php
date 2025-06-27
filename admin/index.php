<?php
session_start();
include('../server/connection.php');

if (!isset($_SESSION['admin_logged_in'])) {
    header('location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    <link rel="stylesheet" href="../assets/css/admin-style.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item"><a class="nav-link active" href="index.php"><i class="fas fa-tachometer-alt"></i> Painel</a></li>
                        <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-box"></i> Pedidos</a></li>
                        <li class="nav-item"><a class="nav-link" href="produtos.php"><i class="fas fa-shopping-cart"></i> Produtos</a></li>
                        <li class="nav-item"><a class="nav-link" href="adicionar_produto.php"><i class="fas fa-plus-square"></i> Adicionar Produtos</a></li>
                        <li class="nav-item mt-5"><a class="nav-link" href="logout.php?logout=1"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Painel de Controle</h1>
                </div>
                <div class="container">
                    <?php if(isset($_GET['login_success'])){ ?>
                        <div class="alert alert-success"><?php echo htmlspecialchars($_GET['login_success']); ?></div>
                    <?php } ?>
                    <p>Olá, **<?php echo $_SESSION['admin_name']; ?>**! Bem-vindo(a) ao seu painel.</p>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>