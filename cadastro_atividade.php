<?php
// cadastro_atividade.php
include("dbconnect.php");

session_start();
if (!isset($_SESSION['professor_id'])) {
    header("Location: login.php");
    exit;
}

$turma_id = $_GET['turma_id'];

if (isset($_POST['cadastrar'])) {
    $descricao = mysqli_real_escape_string($conn, $_POST['descricao']);
    
    $query = "INSERT INTO atividades (descricao, turma_id) VALUES ('$descricao', $turma_id)";
    mysqli_query($conn, $query);
    header("Location: atividades.php?turma_id=$turma_id");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Atividade - SAEP</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            color: #34495e;
            font-size: 24px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #34495e;
            font-weight: 500;
        }

        input[type="text"] {
            width: 100%;
            padding: 14px;
            border: 1px solid #dddfe2;
            border-radius: 6px;
            font-size: 16px;
            color: #34495e;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus {
            border-color: #3498db;
            outline: none;
        }

        .btn {
            width: 100%;
            padding: 14px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #2980b9;
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
                width: 90%;
            }

            h2 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Cadastrar Nova Atividade</h2>
        <form method="POST">
            <div class="form-group">
                <label for="descricao">Descrição da Atividade</label>
                <input type="text" id="descricao" name="descricao" placeholder="Digite a descrição da atividade" required>
            </div>
            <button type="submit" name="cadastrar" class="btn">Cadastrar</button>
        </form>
    </div>
</body>
</html>