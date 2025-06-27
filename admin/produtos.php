<?php
session_start();
include('../server/connection.php');

if (!isset($_SESSION['admin_logged_in'])) {
    header('location: login.php');
    exit();
}

// Buscar os produtos
$stmt = $conn->prepare("SELECT * FROM produtos");
$stmt->execute();
$products = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Produtos</title>
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
                        <li class="nav-item"><a class="nav-link" href="index.php"><i class="fas fa-tachometer-alt"></i> Painel</a></li>
                        <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-box"></i> Pedidos</a></li>
                        <li class="nav-item"><a class="nav-link active" href="produtos.php"><i class="fas fa-shopping-cart"></i> Produtos</a></li>
                        <li class="nav-item"><a class="nav-link" href="adicionar_produto.php"><i class="fas fa-plus-square"></i> Adicionar Produtos</a></li>
                        <li class="nav-item mt-5"><a class="nav-link" href="logout.php?logout=1"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Gerenciar Produtos</h1>
                </div>

                <?php if(isset($_GET['edicao_sucesso'])){ ?>
                    <p class="alert alert-success"><?php echo htmlspecialchars($_GET['edicao_sucesso']); ?></p>
                <?php } ?>
                <?php if(isset($_GET['edicao_falha'])){ ?>
                    <p class="alert alert-danger"><?php echo htmlspecialchars($_GET['edicao_falha']); ?></p>
                <?php } ?>
                <?php if(isset($_GET['exclusao_sucesso'])){ ?>
                    <p class="alert alert-success"><?php echo htmlspecialchars($_GET['exclusao_sucesso']); ?></p>
                <?php } ?>

                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Imagem</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Preço</th>
                                <th scope="col">Editar</th>
                                <th scope="col">Excluir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($products as $product) { ?>
                                <tr>
                                    <td><?php echo $product['product_id']; ?></td>
                                    <td><img src="../assets/imgs/<?php echo $product['product_image']; ?>" style="width: 70px; height: 70px; object-fit: cover;" /></td>
                                    <td><?php echo $product['product_name']; ?></td>
                                    <td>R$ <?php echo number_format($product['product_price'], 2, ',', '.'); ?></td>
                                    <td><a class="btn btn-primary btn-sm" href="editar_produto.php?product_id=<?php echo $product['product_id']; ?>">Editar</a></td>
                                    <td><a class="btn btn-danger btn-sm" href="excluir_produto.php?product_id=<?php echo $product['product_id']; ?>">Excluir</a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>