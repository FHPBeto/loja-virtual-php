<?php
// Cria a conexão com o banco de dados que criamos
$conn = mysqli_connect("localhost", "root", "", "minha_loja_db");

// Se a conexão falhar, mostra uma mensagem de erro
if (!$conn) {
    die("Conexão com o banco de dados falhou: " . mysqli_connect_error());
}
?>