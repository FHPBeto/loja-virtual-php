<?php
session_start();
include('server/connection.php');

// Se o usuário não estiver logado, redireciona para a futura página de login
// Por enquanto, se não estiver logado, apenas ficará na página, mas não mostrará dados.
if (!isset($_SESSION['logged_in'])) {
    // header('location: login_cliente.php?message=Você precisa estar logado para ver sua conta.');
    // exit;
}
?>

<?php include('layouts/header.php'); ?>

<section class="container my-5 py-5">
    <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-12">
            <div class="list-group">
                <a href="conta.php" class="list-group-item list-group-item-action active" aria-current="true">
                    Minha Conta
                </a>
                <a href="#" class="list-group-item list-group-item-action">Meus Pedidos</a>
                <a href="logout.php?logout=1" class="list-group-item list-group-item-action text-danger">Sair</a>
            </div>
        </div>

        <div class="col-lg-9 col-md-8 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Informações do Perfil</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($_GET['register_success'])) { ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo htmlspecialchars($_GET['register_success']); ?>
                        </div>
                    <?php } ?>

                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nome:</strong> <?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Não disponível'; ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Email:</strong> <?php echo isset($_SESSION['user_email']) ? $_SESSION['user_email'] : 'Não disponível'; ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h4 class="card-title">Histórico de Pedidos</h4>
                </div>
                <div class="card-body">
                    <p>Você ainda não fez nenhum pedido.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include('layouts/footer.php'); ?>