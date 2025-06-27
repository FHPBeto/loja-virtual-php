<?php include('layouts/header.php'); ?>

<section class="container my-5 py-5 text-center">
    <div class="col-md-6 mx-auto">
        <i class="fas fa-check-circle fa-5x text-success mb-4"></i>
        <h1 class="display-4">Obrigado!</h1>
        <p class="lead">Seu pedido foi realizado com sucesso.</p>
        
        <?php if(isset($_GET['order_id'])) { ?>
            <p>O número do seu pedido é: <strong>#<?php echo $_GET['order_id']; ?></strong></p>
        <?php } ?>
        
        <p>Enviamos um email de confirmação com os detalhes da sua compra.</p>
        <a href="index.php" class="btn btn-primary mt-3">Voltar para a Loja</a>
    </div>
</section>

<?php include('layouts/footer.php'); ?>