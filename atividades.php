<?php
session_start();

include("dbconnect.php");

if (!isset($_SESSION['professor_id'])) {
    header("Location: login.php");
    exit;
}

$professor_id = $_SESSION['professor_id'];
$turma_id = $_GET['turma_id'];

$query = "SELECT * FROM atividades WHERE turma_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $turma_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atividades - SAEP</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            color: #2c3e50;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 25px 40px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #3498db;
            color: white;
            padding: 20px 30px;
            border-radius: 10px 10px 0 0;
        }

        .header h1 {
            font-size: 28px;
            font-weight: 600;
        }

        .header .button {
            background-color: #e74c3c;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 6px;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .header .button:hover {
            background-color: #c0392b;
        }

        h2 {
            text-align: center;
            color: #34495e;
            font-size: 26px;
            margin-top: 20px;
        }

        .button-success {
            background-color: #2ecc71;
        }

        .button-success:hover {
            background-color: #27ae60;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 15px 20px;
            text-align: left;
            border-bottom: 1px solid #e4e7e8;
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

        table td button {
            padding: 8px 15px;
            font-size: 14px;
            border-radius: 6px;
            background-color: #e74c3c;
            color: white;
            border: none;
            transition: background-color 0.3s;
        }

        table td button:hover {
            background-color: #c0392b;
        }

        table td a {
            padding: 8px 15px;
            font-size: 14px;
            border-radius: 6px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        table td a:hover {
            background-color: #2980b9;
        }

        .empty-message {
            text-align: center;
            font-size: 18px;
            color: #7f8c8d;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            color: #7f8c8d;
        }

        .footer a {
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            .header h1 {
                font-size: 22px;
            }

            h2 {
                font-size: 22px;
            }

            table th, table td {
                padding: 12px;
            }

            .button {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Atividades da Turma</h1>
            <a href="logout.php" class="button">Sair</a>
        </div>

        <h2>Atividades - Turma <?php echo htmlspecialchars($turma_id, ENT_QUOTES, 'UTF-8'); ?></h2>

        <a href="cadastro_atividade.php?turma_id=<?php echo urlencode($turma_id); ?>" class="button button-success">Cadastrar Nova Atividade</a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Data de Entrega</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($atividade = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($atividade['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($atividade['titulo'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($atividade['data_entrega'])); ?></td>
                            <td>
                                <button onclick="excluirAtividade(<?php echo $atividade['id']; ?>)">Excluir</button>
                                <a href="detalhes_atividade.php?id=<?php echo urlencode($atividade['id']); ?>">Visualizar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="empty-message">Nenhuma atividade cadastrada.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>