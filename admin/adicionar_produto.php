<?php
session_start();
include('../server/connection.php');

if (!isset($_SESSION['admin_logged_in'])) {
    header('location: login.php');
    exit();
}

// Lógica para adicionar o produto, agora com o campo de categoria
if (isset($_POST['adicionar_btn'])) {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $categoria = $_POST['categoria']; // <-- NOVO CAMPO

    // Para a imagem, precisamos de um tratamento especial
    $imagem_file = $_FILES['imagem']['tmp_name'];
    $nome_imagem = $nome."_".$_FILES['imagem']['name'];

    // Move a imagem enviada para a pasta de imagens do projeto
    move_uploaded_file($imagem_file, "../assets/imgs/" . $nome_imagem);

    // Inserir o novo produto no banco de dados, incluindo a categoria
    $stmt = $conn->prepare("INSERT INTO produtos (product_name, product_description, product_price, product_image, product_category) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('ssdss', $nome, $descricao, $preco, $nome_imagem, $categoria);

    if ($stmt->execute()) {
        header('location: produtos.php?produto_adicionado=Produto foi adicionado com sucesso!');
    } else {
        header('location: produtos.php?erro_adicionar=Erro, não foi possível adicionar o produto.');
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Novo Produto</title>
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
                        <li class="nav-item"><a class="nav-link" href="produtos.php"><i class="fas fa-shopping-cart"></i> Produtos</a></li>
                        <li class="nav-item"><a class="nav-link active" href="adicionar_produto.php"><i class="fas fa-plus-square"></i> Adicionar Produtos</a></li>
                        <li class="nav-item mt-5"><a class="nav-link" href="logout.php?logout=1"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Adicionar Novo Produto</h1>
                </div>

                <div class="mx-auto container">
                    <form id="add-product-form" enctype="multipart/form-data" method="POST" action="adicionar_produto.php">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome do Produto</label>
                            <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome do produto" required>
                        </div>
                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control" id="descricao" name="descricao" rows="3" placeholder="Descrição detalhada do produto" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="preco" class="form-label">Preço</label>
                            <input type="text" class="form-control" id="preco" name="preco" placeholder="Ex: 59.90" required>
                        </div>
                        <div class="mb-3">
                            <label for="categoria" class="form-label">Categoria do Produto</label>
                            <input type="text" class="form-control" id="categoria" name="categoria" placeholder="Ex: Camisetas" required>
                        </div>
                        <div class="mb-3">
                            <label for="imagem" class="form-label">Imagem do Produto</label>
                            <input type="file" class="form-control" id="imagem" name="imagem" required>
                        </div>
                        <button type="submit" name="adicionar_btn" class="btn btn-primary">Adicionar Produto</button>
                    </form>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>