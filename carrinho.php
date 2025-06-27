<?php
session_start();

// --- LÓGICA PARA REMOVER PRODUTO ---
if (isset($_POST['remover_produto'])) {
    $product_id = $_POST['product_id'];
    unset($_SESSION['carrinho'][$product_id]);
}

// --- LÓGICA PARA ATUALIZAR QUANTIDADE ---
if (isset($_POST['editar_quantidade'])) {
    $product_id = $_POST['product_id'];
    $product_quantity = $_POST['product_quantity'];

    // Garante que a quantidade é um número válido antes de atualizar
    if ($product_quantity > 0) {
        $_SESSION['carrinho'][$product_id]['product_quantity'] = $product_quantity;
    }
}

include('layouts/header.php');
?>

<section class="container my-5 py-5">
    <div class="text-center">
        <h2 class="display-5">Seu Carrinho</h2>
        <hr class="mx-auto" style="width: 100px;">
    </div>

    <table class="mt-5 pt-5 table table-striped align-middle">
        <thead>
            <tr>
                <th scope="col">Produto</th>
                <th scope="col">Subtotal</th>
                <th scope="col">Quantidade</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            
            <?php if (!empty($_SESSION['carrinho'])) { 
                $total_carrinho = 0;
                foreach ($_SESSION['carrinho'] as $key => $value) { 
                    
                    $preco_numerico = (float) $value['product_price'];
                    $quantidade_numerica = (int) $value['product_quantity'];
                    
                    $subtotal_item = $preco_numerico * $quantidade_numerica;
                    $total_carrinho += $subtotal_item;
                    $_SESSION['total_carrinho'] = $total_carrinho;
            ?>
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="assets/imgs/<?php echo $value['product_image']; ?>" style="width: 100px; height: auto; margin-right: 15px;" alt="<?php echo $value['product_name']; ?>">
                            <div>
                                <p class="m-0 fw-bold"><?php echo $value['product_name']; ?></p>
                                <small>Preço unitário: R$ <?php echo number_format($preco_numerico, 2, ',', '.'); ?></small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="fw-bold">R$ <?php echo number_format($subtotal_item, 2, ',', '.'); ?></span>
                    </td>
                    <td>
                        <form method="POST" action="carrinho.php" class="d-flex">
                            <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>">
                            <input type="number" name="product_quantity" value="<?php echo $quantidade_numerica; ?>" min="1" class="form-control form-control-sm" style="width: 70px;">
                            <button type="submit" name="editar_quantidade" class="btn btn-primary btn-sm ms-2">OK</button>
                        </form>
                    </td>
                    <td>
                        <form method="POST" action="carrinho.php">
                            <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>">
                            <button type="submit" name="remover_produto" class="btn btn-danger btn-sm">Remover</button>
                        </form>
                    </td>
                </tr>
            <?php } // Fim do foreach
                  } else { // Início do else ?> 
                <tr>
                    <td colspan="4">
                        <p class="text-center p-3">Seu carrinho está vazio.</p>
                    </td>
                </tr>
            <?php } // Fim do if/else ?>

        </tbody>
    </table>

    <?php if (!empty($_SESSION['carrinho'])) { ?>
        <div class="d-flex justify-content-end mt-4">
            <div style="width: 100%; max-width: 450px;">
                <h4 class="mb-3">Total do Pedido</h4>
                <div class="d-flex justify-content-between fw-bold">
                    <span>Total:</span>
                    <span>R$ <?php echo number_format($total_carrinho, 2, ',', '.'); ?></span>
                </div>
                <div class="d-grid gap-2 mt-4">
                    <a href="checkout.php" class="btn btn-primary">Finalizar Compra</a>
                </div>
            </div>
        </div>
    <?php } // <-- ESTA CHAVE ESTAVA FALTANDO! ?>

</section>

<?php include('layouts/footer.php'); ?>