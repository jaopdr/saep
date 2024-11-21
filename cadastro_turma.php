<?php
// cadastro_turma.php
include("dbconnect.php");

session_start();
if (!isset($_SESSION['professor_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['cadastrar'])) {
    $nome = $_POST['nome'];
    $professor_id = $_SESSION['professor_id'];
    
    $query = "INSERT INTO turmas (nome, professor_id) VALUES ('$nome', $professor_id)";
    mysqli_query($conn, $query);
    header("Location: principal.php");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Turma - SAEP</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f7f9fb;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #ffffff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-size: 28px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: #444;
        }

        input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
            outline: none;
        }

        input[type="text"]:focus {
            border-color: #4e73df;
        }

        .btn {
            width: 100%;
            padding: 14px;
            background-color: #4e73df;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #3558a8;
        }

        .btn:active {
            background-color: #2c478e;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            color: #777;
            font-size: 14px;
        }

        .footer a {
            text-decoration: none;
            color: #4e73df;
            font-weight: 600;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Cadastrar Nova Turma</h2>
        <form method="POST">
            <div class="form-group">
                <label for="nome">Nome da Turma</label>
                <input type="text" name="nome" id="nome" placeholder="Digite o nome da turma" required>
            </div>
            <button type="submit" name="cadastrar" class="btn">Cadastrar</button>
        </form>
        </div>
    </div>
</body>
</html>