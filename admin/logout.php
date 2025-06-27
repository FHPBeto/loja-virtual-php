<?php
session_start();

if (isset($_GET['logout']) && $_GET['logout'] == 1) {
    if (isset($_SESSION['admin_logged_in'])) {
        // Destrói todas as variáveis da sessão
        unset($_SESSION['admin_id']);
        unset($_SESSION['admin_name']);
        unset($_SESSION['admin_logged_in']);
        
        // Finaliza a sessão
        session_destroy();
        
        // Redireciona para o login com uma mensagem de sucesso
        header('location: login.php?message=Você saiu com sucesso');
        exit();
    }
}
?>