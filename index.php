<?php include('layouts/header.php'); ?>

<main class="container my-5 py-5">
    <div class="text-center">
        <h2 class="display-6">Explore Nossas Coleções</h2>
        <p class="lead">Designs únicos para todos os estilos.</p>
        <hr class="mx-auto" style="width: 80px;">
    </div>
    
    <div class="row mt-5">
        <div class="col-md-4 text-center">
            <a href="produtos.php?category=camisetas">
                <div class="image-container">
                    <img src="assets/imgs/camisetas-destaque.jpg" class="img-fluid main-feature-image" alt="Sua Estampa Aqui">
                </div>
            </a>
        </div>

        <div class="col-md-4 text-center">
            <a href="produtos.php?category=vestidos">
                <div class="image-container">
                     <img src="assets/imgs/vestido-destaque.jpg" class="img-fluid main-feature-image" alt="Vestido Elegante">
                </div>
            </a>
        </div>

        <div class="col-md-4 text-center">
            <a href="produtos.php?category=esportivo">
                <div class="image-container">
                    <img src="assets/imgs/esportivo-destaque.jpg" class="img-fluid main-feature-image" alt="Moda Esportiva">
                </div>
            </a>
        </div>
    </div>
</main>

<?php include('layouts/footer.php'); ?>