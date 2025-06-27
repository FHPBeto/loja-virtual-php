<?php

session_start();
include('connection.php'); // Usa a conexão que já está na mesma pasta

// Se o usuário não clicou no botão "Finalizar Pedido", redireciona para a home
if (!isset($_POST['efetuar_pedido'])) {
    header('location: ../index.php');
    exit;
}

// Se o botão foi clicado, processa o pedido
if (isset($_POST['efetuar_pedido'])) {

    // 1. Pegar os dados do formulário de checkout
    $nome = $_POST['name'];
    $email = $_POST['email'];
    $telefone = $_POST['phone'];
    $cidade = $_POST['city'];
    $endereco = $_POST['address'];
    $custo_pedido = $_SESSION['total_carrinho'];
    $data_pedido = date('Y-m-d H:i:s'); // Data e hora atuais

    // 2. Inserir um novo registro na tabela `pedidos`
    // Usamos prepared statements para segurança
    $stmt = $conn->prepare("INSERT INTO pedidos (order_cost, user_name, user_email, user_phone, user_city, user_address, order_date) VALUES (?, ?, ?, ?, ?, ?, ?);");
    $stmt->bind_param('dssssss', $custo_pedido, $nome, $email, $telefone, $cidade, $endereco, $data_pedido);
    
    // Executa a query e verifica se foi bem-sucedida
    if (!$stmt->execute()) {
        // Se houver um erro, redireciona com uma mensagem
        header('location: ../index.php?error=Erro ao processar o pedido');
        exit;
    }

    // 3. Pegar o ID do pedido que acabamos de criar. É crucial para ligar os itens ao pedido.
    $order_id = $stmt->insert_id;

    // 4. Pegar os produtos do carrinho e inseri-los na tabela `itens_pedidos`
    foreach ($_SESSION['carrinho'] as $key => $value) {
        $product_id = $value['product_id'];
        $product_name = $value['product_name'];
        $product_image = $value['product_image'];
        
        $stmt1 = $conn->prepare("INSERT INTO itens_pedidos (order_id, product_id, product_name, product_image) VALUES (?, ?, ?, ?);");
        $stmt1->bind_param('iiss', $order_id, $product_id, $product_name, $product_image);
        $stmt1->execute();
    }

    // 5. Limpar o carrinho da sessão e o total
    unset($_SESSION['carrinho']);
    unset($_SESSION['total_carrinho']);

    // 6. Redirecionar para uma página de "Obrigado" com o ID do pedido
    header('location: ../pagina_obrigado.php?order_id=' . $order_id);
    exit;

}

?>
}

?>