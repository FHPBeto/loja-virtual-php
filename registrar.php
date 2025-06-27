<?php
session_start();
include('server/connection.php');

// Se o usuário já estiver logado, redireciona para a página da conta
if (isset($_SESSION['logged_in'])) {
    header('location: conta.php');
    exit;
}

// Quando o botão de registrar for clicado
if (isset($_POST['registrar_btn'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // --- VALIDAÇÕES ---
    // 1. Verifica se as senhas coincidem
    if ($password !== $confirm_password) {
        header('location: registrar.php?error=As senhas não coincidem.');
        exit;
    }
    // 2. Verifica se a senha tem pelo menos 6 caracteres
    if (strlen($password) < 6) {
        header('location: registrar.php?error=A senha precisa ter pelo menos 6 caracteres.');
        exit;
    }

    // 3. Verifica se já existe um usuário com este email
    $stmt_check = $conn->prepare("SELECT count(*) FROM users WHERE user_email = ?");
    $stmt_check->bind_param('s', $email);
    $stmt_check->execute();
    $stmt_check->bind_result($num_rows);
    $stmt_check->store_result();
    $stmt_check->fetch();

    if ($num_rows != 0) {
        header('location: registrar.php?error=Este email já está cadastrado.');
        exit;
    }

    // --- Se todas as validações passaram, cria o novo usuário ---
    $stmt = $conn->prepare("INSERT INTO users (user_name, user_email, user_password) VALUES (?, ?, ?)");
    // Criptografa a senha antes de salvar. md5() é simples para aprendizado.
    // Em um site real, prefira usar a função password_hash().
    $stmt->bind_param('sss', $name, $email, md5($password));

    // Se o usuário for criado com sucesso
    if ($stmt->execute()) {
        $user_id = $stmt->insert_id;
        // Guarda as informações na sessão para logar o usuário automaticamente
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_name'] = $name;
        $_SESSION['logged_in'] = true;
        
        // Redireciona para a página da conta com uma mensagem de sucesso
        header('location: conta.php?register_success=Você se cadastrou com sucesso!');
        exit;
    } else {
        // Se houver um erro de banco de dados
        header('location: registrar.php?error=Não foi possível criar sua conta no momento.');
        exit;
    }
}
?>

<?php include('layouts/header.php'); ?>

<section class="container my-5 py-5">
    <div class="text-center">
        <h2 class="display-5">Criar Conta</h2>
        <hr class="mx-auto" style="width: 100px;">
    </div>

    <div class="mx-auto" style="max-width: 500px;">
        <form id="register-form" method="POST" action="registrar.php">

            <?php if (isset($_GET['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo htmlspecialchars($_GET['error']); ?>
                </div>
            <?php } ?>

            <div class="mb-3">
                <label for="register-name" class="form-label">Nome</label>
                <input type="text" class="form-control" id="register-name" name="name" placeholder="Seu nome completo" required>
            </div>
            <div class="mb-3">
                <label for="register-email" class="form-label">Email</label>
                <input type="email" class="form-control" id="register-email" name="email" placeholder="seu@email.com" required>
            </div>
            <div class="mb-3">
                <label for="register-password" class="form-label">Senha</label>
                <input type="password" class="form-control" id="register-password" name="password" placeholder="Crie uma senha" required>
            </div>
            <div class="mb-3">
                <label for="register-confirm-password" class="form-label">Confirmar Senha</label>
                <input type="password" class="form-control" id="register-confirm-password" name="confirm_password" placeholder="Confirme sua senha" required>
            </div>
            <div class="d-grid">
                <button type="submit" name="registrar_btn" class="btn btn-primary">Cadastrar</button>
            </div>
            <div class="text-center mt-3">
                <p>Já tem uma conta? <a href="login_cliente.php">Faça login</a></p>
            </div>
        </form>
    </div>
</section>

<?php include('layouts/footer.php'); ?>