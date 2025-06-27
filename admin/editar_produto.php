<?php
session_start();
include('../server/connection.php');

if (!isset($_SESSION['admin_logged_in'])) {
    header('location: login.php');
    exit();
}

// --- Lógica para ATUALIZAR o produto quando o formulário for enviado ---
if (isset($_POST['editar_btn'])) {
    $product_id = $_POST['product_id'];
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $categoria = $_POST['categoria'];

    // Prepara o comando UPDATE para incluir a categoria
    $stmt = $conn->prepare("UPDATE produtos SET product_name=?, product_description=?, product_price=?, product_category=? WHERE product_id=?");
    
    // --- A CORREÇÃO ESTÁ AQUI ---
    // A string de tipos agora tem 5 letras para 5 variáveis.
    $stmt->bind_param('ssdsi', $nome, $descricao, $preco, $categoria, $product_id);

    if ($stmt->execute()) {
        header('location: produtos.php?edicao_sucesso=Produto atualizado com sucesso!');
    } else {
        header('location: produtos.php?edicao_falha=Erro, não foi possível atualizar o produto.');
    }
    exit();
}
// --- Lógica para BUSCAR os dados do produto para preencher o formulário ---
else if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $stmt = $conn->prepare("SELECT * FROM produtos WHERE product_id = ?");
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();
} else {
    // Se não houver ID, redireciona
    header('location: produtos.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    <link rel="stylesheet" href="../assets/css/admin-style.css">
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header">
                <h2>Editar Produto</h2>
                <p>Altere os dados do produto abaixo.</p>
            </div>
            <div class="card-body">
                <form id="edit-product-form" method="POST" action="editar_produto.php">
                    <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>" />

                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome do Produto</label>
                        <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $product['product_name']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="3" required><?php echo $product['product_description']; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="preco" class="form-label">Preço</label>
                        <input type="text" class="form-control" id="preco" name="preco" value="<?php echo $product['product_price']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="categoria" class="form-label">Categoria</label>
                        <input type="text" class="form-control" id="categoria" name="categoria" value="<?php echo $product['product_category']; ?>" required>
                    </div>
                    
                    <button type="submit" name="editar_btn" class="btn btn-primary">Salvar Alterações</button>
                    <a href="produtos.php" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>