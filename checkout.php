<?php
session_start();

// Se o carrinho estiver vazio, não permite o acesso ao checkout
if (empty($_SESSION['carrinho'])) {
    header('location: index.php');
    exit();
}

include('layouts/header.php');
?>

<section class="container my-5 py-5">
    <div class="text-center">
        <h2 class="display-5">Checkout</h2>
        <hr class="mx-auto" style="width: 100px;">
    </div>

    <div class="mx-auto" style="max-width: 700px;">
        <form id="checkout-form" method="POST" action="server/efetuar_pedido.php">
            
            <div class="mb-3">
                <label for="checkout-name" class="form-label">Nome Completo</label>
                <input type="text" class="form-control" id="checkout-name" name="name" placeholder="Seu nome completo" required>
            </div>
            
            <div class="mb-3">
                <label for="checkout-email" class="form-label">Email</label>
                <input type="email" class="form-control" id="checkout-email" name="email" placeholder="seu@email.com" required>
            </div>
            
            <div class="mb-3">
                <label for="checkout-phone" class="form-label">Telefone</label>
                <input type="tel" class="form-control" id="checkout-phone" name="phone" placeholder="(11) 99999-8888" required>
            </div>
            
            <div class="mb-3">
                <label for="checkout-city" class="form-label">Cidade</label>
                <input type="text" class="form-control" id="checkout-city" name="city" placeholder="Sua cidade" required>
            </div>
            
            <div class="mb-3">
                <label for="checkout-address" class="form-label">Endereço Completo</label>
                <textarea class="form-control" id="checkout-address" name="address" rows="3" placeholder="Rua, número, complemento, bairro..." required></textarea>
            </div>

            <div class="mt-4 text-end">
                <p class="fw-bold">Total do Pedido: R$ <?php echo number_format($_SESSION['total_carrinho'], 2, ',', '.'); ?></p>
                <button type="submit" class="btn btn-primary btn-lg" name="efetuar_pedido">Finalizar Pedido</button>
            </div>

        </form>
    </div>
</section>

<?php include('layouts/footer.php'); ?>