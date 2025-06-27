<?php
session_start();
// O include precisa "voltar" uma pasta para encontrar o 'server'
include('../server/connection.php');

// Se o admin já estiver logado, redireciona para o painel
if (isset($_SESSION['admin_logged_in'])) {
    header('location: index.php');
    exit;
}

// Quando o formulário de login for enviado
if (isset($_POST['login_btn'])) {
    $email = $_POST['email'];
    $password = $_POST['password']; // Para um site real, use: md5($_POST['password']);

    // Busca no banco um admin com o email e senha correspondentes
    $stmt = $conn->prepare("SELECT admin_id, admin_name FROM admins WHERE admin_email = ? AND admin_password = ? LIMIT 1");
    $stmt->bind_param('ss', $email, $password);

    if ($stmt->execute()) {
        $stmt->bind_result($admin_id, $admin_name);
        $stmt->store_result();

        // Se encontrou um resultado (login bem-sucedido)
        if ($stmt->num_rows() == 1) {
            $stmt->fetch();
            // Guarda as informações do admin na sessão
            $_SESSION['admin_id'] = $admin_id;
            $_SESSION['admin_name'] = $admin_name;
            $_SESSION['admin_logged_in'] = true;

            // Redireciona para o painel principal
            header('location: index.php?login_success=Login realizado com sucesso!');
        } else {
            // Se não encontrou (login falhou)
            header('location: login.php?error=Email ou senha incorretos.');
        }
    } else {
        // Erro ao executar a query
        header('location: login.php?error=Algo deu errado, tente novamente.');
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login do Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="card shadow-sm" style="width: 25rem;">
            <div class="card-header text-center bg-primary text-white">
                <h4>Login do Administrador</h4>
            </div>
            <div class="card-body p-4">

                <?php if (isset($_GET['error'])) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo htmlspecialchars($_GET['error']); ?>
                    </div>
                <?php } ?>

                <form id="login-form" method="POST" action="login.php">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Digite sua senha" required>
                    </div>
                    <div class="d-grid mt-4">
                        <button type="submit" name="login_btn" class="btn btn-primary">Entrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>