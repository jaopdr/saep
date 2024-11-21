<?php 
include("dbconnect.php");

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['entrar'])) {
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    // Evitando injeção SQL usando prepared statements
    $stmt = $conn->prepare("SELECT id, nome FROM professores WHERE email = ? AND senha = ?");
    $stmt->bind_param("ss", $email, $senha);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $professor = $result->fetch_assoc();
        $_SESSION['professor_id'] = $professor['id'];
        $_SESSION['nome'] = $professor['nome'];
        header("Location: principal.php");
        exit();
    } else {
        $erro = "E-mail ou senha inválidos. Tente novamente.";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SAEP</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(120deg, #4c669f, #3b5998, #192f6a);
            color: #ffffff;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
            width: 350px;
            text-align: center;
            color: #333333;
        }
        h2 {
            font-size: 26px;
            color: #444444;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 18px;
            text-align: left;
        }
        label {
            display: block;
            font-size: 14px;
            margin-bottom: 8px;
        }
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #dddddd;
            border-radius: 6px;
            font-size: 15px;
        }
        input[type="email"]:focus, input[type="password"]:focus {
            border-color: #4c669f;
            box-shadow: 0 0 5px rgba(76, 102, 159, 0.5);
            outline: none;
        }
        .button {
            width: 100%;
            padding: 12px;
            background-color: #4c669f;
            color: #ffffff;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .button:hover {
            background-color: #3b5998;
        }
        .error-message {
            color: #d9534f;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Acesso ao Sistema</h2>
        <form method="POST">
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" placeholder="Digite seu e-mail" required>
            </div>
            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
            </div>
            <button type="submit" name="entrar" class="button">Entrar</button>
            <?php if (isset($erro)): ?>
                <p class="error-message"><?php echo htmlspecialchars($erro); ?></p>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>