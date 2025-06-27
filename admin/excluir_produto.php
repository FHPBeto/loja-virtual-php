<?php
session_start();
include('../server/connection.php');

// Proteção da página
if (!isset($_SESSION['admin_logged_in'])) {
    header('location: login.php');
    exit();
}

// Verifica se o ID do produto foi passado pela URL
if(isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Prepara e executa o comando DELETE
    $stmt = $conn->prepare("DELETE FROM produtos WHERE product_id = ?");
    $stmt->bind_param('i', $product_id);

    if($stmt->execute()) {
        header('location: produtos.php?exclusao_sucesso=Produto excluído com sucesso!');
    } else {
        header('location: produtos.php?exclusao_falha=Não foi possível excluir o produto.');
    }
    exit();
} else {
    // Se nenhum ID foi passado, volta para a página de produtos
    header('location: produtos.php');
    exit();
}
?>