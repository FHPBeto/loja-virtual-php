<?php
include('layouts/header.php');
include('server/connection.php');

// Define um título padrão
$page_title = "Nossos Produtos";

// --- LÓGICA DE BUSCA E FILTRO ---

// Se o formulário de busca foi enviado
if (isset($_POST['search_btn'])) {
    $search_term = $_POST['search_term'];
    $page_title = "Resultados para \"" . htmlspecialchars($search_term) . "\"";
    // Prepara a query para buscar produtos cujo nome contenha o termo pesquisado
    $stmt = $conn->prepare("SELECT * FROM produtos WHERE product_name LIKE ?");
    $search_pattern = "%" . $search_term . "%";
    $stmt->bind_param('s', $search_pattern);

// Se uma categoria foi selecionada na URL
} else if (isset($_GET['category'])) {
    $category = $_GET['category'];
    $page_title = "Categoria: " . htmlspecialchars($category);
    // Prepara a query para buscar produtos APENAS daquela categoria
    $stmt = $conn->prepare("SELECT * FROM produtos WHERE product_category = ?");
    $stmt->bind_param('s', $category);

// Se NENHUMA busca ou filtro foi feito, busca TODOS os produtos
} else {
    $stmt = $conn->prepare("SELECT * FROM produtos");
}

$stmt->execute();
$products = $stmt->get_result();
?>

<section class="container my-5 py-5">
    <div class="text-center">
        <h2 class="display-5"><?php echo $page_title; ?></h2>
        <hr class="mx-auto" style="width: 100px;">
    </div>

    <?php if (!isset($_POST['search_btn'])) { ?>
    <div class="row mx-auto container text-center my-5">
        <div class="col-12">
            <a href="produtos.php" class="btn btn-outline-primary me-2 mb-2">Todos</a>
            <?php
            $stmt_cat = $conn->prepare("SELECT DISTINCT product_category FROM produtos");
            $stmt_cat->execute();
            $categories = $stmt_cat->get_result();
            while ($row_cat = $categories->fetch_assoc()) {
            ?>
                <a href="produtos.php?category=<?php echo $row_cat['product_category']; ?>" class="btn btn-outline-primary me-2 mb-2"><?php echo $row_cat['product_category']; ?></a>
            <?php } ?>
        </div>
    </div>
    <?php } ?>

    <div class="row mt-5">
        <?php while ($row = $products->fetch_assoc()) { ?>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card product-card h-100 border-0 shadow-sm">
                    <a href="single_product.php?product_id=<?php echo $row['product_id']; ?>">
                        <img src="assets/imgs/<?php echo $row['product_image']; ?>" class="card-img-top product-image" alt="<?php echo $row['product_name']; ?>">
                    </a>
                    <div class="card-body text-center">
                        <h5 class="card-title product-name"><?php echo $row['product_name']; ?></h5>
                        <p class="card-text product-price">R$ <?php echo number_format($row['product_price'], 2, ',', '.'); ?></p>
                        <a href="single_product.php?product_id=<?php echo $row['product_id']; ?>" class="btn btn-primary">Ver Detalhes</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</section>

<?php include('layouts/footer.php'); ?>