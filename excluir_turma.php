<?php
// incluir a conexão com o banco de dados
include("dbconnect.php");

// Verificar se o ID da turma foi passado via GET
if (isset($_GET['id'])) {
    $turma_id = $_GET['id'];

    // Excluir todas as atividades relacionadas à turma
    $delete_atividades_query = "DELETE FROM atividades WHERE turma_id = $turma_id";
    $delete_atividades_result = mysqli_query($conn, $delete_atividades_query);

    // Verificar se a exclusão das atividades foi bem-sucedida
    if ($delete_atividades_result) {
        // Excluir a turma
        $delete_turma_query = "DELETE FROM turmas WHERE id = $turma_id";
        $delete_turma_result = mysqli_query($conn, $delete_turma_query);

        // Verificar se a exclusão da turma foi bem-sucedida
        if ($delete_turma_result) {
            // Redirecionar para a página principal com uma mensagem de sucesso
            header("Location: principal.php?status=sucesso");
            exit;
        } else {
            // Redirecionar para a página principal com uma mensagem de erro
            header("Location: principal.php?status=erro_turma");
            exit;
        }
    } else {
        // Redirecionar para a página principal com uma mensagem de erro
        header("Location: principal.php?status=erro_atividades");
        exit;
    }
} else {
    // Redirecionar para a página principal caso o ID não seja passado
    header("Location: principal.php");
    exit;
}
?>


<?php
// atividades.php
session_start();
if(!isset($_SESSION['professor_id'])) {
    header("Location: login.php");
    exit;
}

$turma_id = $_GET['turma_id'];
$query = "SELECT * FROM atividades WHERE turma_id = $turma_id";
$result = mysqli_query($conn, $query);

$query_turma = "SELECT nome FROM turmas WHERE id = $turma_id";
$result_turma = mysqli_query($conn, $query_turma);
$turma = mysqli_fetch_assoc($result_turma);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Atividades da Turma</title>
    <style>
        .container {
            width: 80%;
            margin: 20px auto;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #007bff;
            color: white;
            padding: 10px 20px;
        }
        .btn {
            background: #007bff;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Turma: <?php echo $turma['nome']; ?></h2>
            <a href="principal.php" class="btn">Voltar</a>
        </div>
        
        <button onclick="window.location='cadastro_atividade.php?turma_id=<?php echo $turma_id; ?>'" class="btn">
            Cadastrar Atividade
        </button>
        
        <table>
            <tr>
                <th>Número</th>
                <th>Descrição</th>
            </tr>
            <?php while($atividade = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $atividade['id']; ?></td>
                <td><?php echo $atividade['descricao']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
