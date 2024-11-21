<?php
session_start();

include("dbconnect.php");

if (!isset($_SESSION['professor_id'])) {
    header("Location: login.php");
    exit;
}

$professor_id = $_SESSION['professor_id'];

$query = "SELECT * FROM turmas WHERE professor_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $professor_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAEP - Sistema de Avaliação Escolar para Professores</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 85%;
            max-width: 1200px;
            margin: 50px auto;
            padding: 30px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: #3498db;
            color: white;
            padding: 20px 30px;
            text-align: left;
            border-radius: 10px 10px 0 0;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .header h1 {
            font-size: 26px;
            margin: 0;
        }
        .header .button {
            float: right;
            background-color: #e74c3c;
            color: white;
            padding: 12px 18px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }
        .header .button:hover {
            background-color: #c0392b;
        }
        h2 {
            text-align: center;
            color: #34495e;
            margin-bottom: 20px;
            font-size: 24px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }
        table th, table td {
            padding: 12px 18px;
            text-align: left;
            border-bottom: 1px solid #dddfe2;
        }
        table th {
            background-color: #2980b9;
            color: white;
            font-size: 16px;
        }
        table td {
            background-color: #f9f9f9;
            font-size: 15px;
        }
        .button {
            padding: 10px 18px;
            text-decoration: none;
            color: white;
            border-radius: 5px;
            font-size: 14px;
            transition: background 0.3s ease;
        }
        .button-danger {
            background: #e74c3c;
        }
        .button-danger:hover {
            background: #c0392b;
        }
        .button-success {
            background: #2ecc71;
        }
        .button-success:hover {
            background: #27ae60;
        }
        .button:hover {
            opacity: 0.9;
        }
        .empty-message {
            text-align: center;
            font-size: 18px;
            color: #7f8c8d;
        }
        @media (max-width: 768px) {
            .container {
                width: 90%;
                padding: 20px;
            }
            .header h1 {
                font-size: 22px;
            }
            h2 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Bem-vindo, <?php echo htmlspecialchars($_SESSION['nome'], ENT_QUOTES, 'UTF-8'); ?></h1>
        <a href="logout.php" class="button">Sair</a>
    </div>

    <div class="container">
        <h2>Minhas Turmas</h2>
        <a href="cadastro_turma.php" class="button button-success">Cadastrar Turma</a>

        <table>
            <thead>
                <tr>
                    <th>Número</th>
                    <th>Nome</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($turma = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($turma['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($turma['nome'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <button onclick="excluirTurma(<?php echo $turma['id']; ?>)" class="button button-danger">Excluir</button>
                                <a href="atividades.php?turma_id=<?php echo urlencode($turma['id']); ?>" class="button button-success">Visualizar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="empty-message">Nenhuma turma cadastrada.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
        function excluirTurma(id) {
            if (confirm('Deseja realmente excluir esta turma?')) {
                window.location = 'excluir_turma.php?id=' + id;
            }
        }
    </script>
</body>
</html>