<?php
// INICIA A SESSÃO (A "MOCHILA" DO VISITANTE)
// Este comando deve ser o PRIMEIRO de tudo na página.
session_start();

// Inclui o arquivo de conexão
include('server/connection.php');

// --- LÓGICA PARA ADICIONAR AO CARRINHO ---
if (isset($_POST['add_to_cart'])) {
    // Se o usuário já tem um carrinho na sessão
    if (isset($_SESSION['carrinho'])) {
        $products_array_ids = array_column($_SESSION['carrinho'], "product_id");
        // Verifica se o produto já foi adicionado
        if (!in_array($_POST['product_id'], $products_array_ids)) {
            $product_id = $_POST['product_id'];
            $product_array = array(
                'product_id' => $_POST['product_id'],
                'product_name' => $_POST['product_name'],
                'product_price' => $_POST['product_price'],
                'product_image' => $_POST['product_image'],
                'product_quantity' => $_POST['product_quantity']
            );
            $_SESSION['carrinho'][$product_id] = $product_array;
        } else {
            // Se o produto já existe, apenas avisa o usuário
            echo '<script>alert("Este produto já está no seu carrinho!");</script>';
        }
    } else { // Se este é o primeiro produto a ser adicionado
        $product_id = $_POST['product_id'];
        $product_array = array(
            'product_id' => $product_id,
            'product_name' => $_POST['product_name'],
            'product_price' => $_POST['product_price'],
            'product_image' => $_POST['product_image'],
            'product_quantity' => $_POST['product_quantity']
        );
        $_SESSION['carrinho'][$product_id] = $product_array;
    }
}

// --- LÓGICA PARA BUSCAR OS DETALHES DO PRODUTO (JÁ EXISTENTE) ---
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $stmt = $conn->prepare("SELECT * FROM produtos WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();
} else {
    header('location: index.php');
    exit();
}
?>

<?php include('layouts/header.php'); ?>

<section class="container single-product my-5 pt-5">
    <div class="row mt-5">
        <div class="col-lg-5 col-md-6 col-sm-12">
            <img class="img-fluid w-100 pb-1" src="assets/imgs/<?php echo $product['product_image']; ?>" id="mainImg" alt="<?php echo $product['product_name']; ?>">
        </div>
        <div class="col-lg-6 col-md-12 col-12">
            <h6>Home / Produto</h6>
            <h3 class="py-4"><?php echo $product['product_name']; ?></h3>
            <h2>R$ <?php echo number_format($product['product_price'], 2, ',', '.'); ?></h2>
            
            <form method="POST" action="single_product.php?product_id=<?php echo $product['product_id']; ?>">
                <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                <input type="hidden" name="product_name" value="<?php echo $product['product_name']; ?>">
                <input type="hidden" name="product_price" value="<?php echo $product['product_price']; ?>">
                <input type="hidden" name="product_image" value="<?php echo $product['product_image']; ?>">
                
                <input type="number" name="product_quantity" value="1" min="1" class="form-control w-25 mb-3">
                <button class="btn btn-primary" type="submit" name="add_to_cart">Adicionar ao Carrinho</button>
            </form>

            <h4 class="mt-5 mb-3">Descrição do Produto</h4>
            <span><?php echo $product['product_description']; ?></span>
        </div>
    </div>
</section>

<?php include('layouts/footer.php'); ?>
<?php include('layouts/footer.php'); ?>