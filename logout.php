<?php
session_start();

if (isset($_GET['logout']) && $_GET['logout'] == 1) {
    if (isset($_SESSION['logged_in'])) {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        unset($_SESSION['logged_in']);

        // Não usamos session_destroy() aqui para não interferir com o carrinho

        header('location: login_cliente.php?message=Você saiu com sucesso');
        exit();
    }
}
?>