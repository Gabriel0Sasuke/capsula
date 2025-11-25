<?php
session_start();

require_once '../scripts/conn.php';

$sql = 'SELECT * FROM post ORDER BY data_publicacao DESC';
$result = $conn->query($sql);
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$celular = false;
if (!preg_match('/Mobi|Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i', $user_agent)) {
    $celular = false;
} else {
    $celular = true;
}

?>

<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+Round">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Quintessential&display=swap">

    <?php
    if ($celular == false) {
    ?>
        <link rel="stylesheet" href="../assets/css/desktop/index.css">
        <link rel="stylesheet" href="../assets/css/desktop/quest.css">
    <?php  } else { ?>
        <link rel="stylesheet" href="../assets/css/mobile/index-mobile.css">
        <link rel="stylesheet" href="../assets/css/mobile/quest-mobile.css">
    <?php }?>

    <title>Questionário</title>
</head>
<body>

    <div id="sidebar" class="sidebar">
        <a href="../index.php"><i class="material-icons-round">home</i>Início</a>
        <a href="sobre.php"><i class="material-icons-round">info</i>Sobre o Projeto</a>
        <a href="quest.php"><i class="material-icons-round">rate_review</i>Questionário</a>
        <a href="admin.php"><i class="material-icons-round">shield</i>Admin</a>
    </div>

    <button id="sidebar-toggle">☰</button>

    <header>CAPSULA DO TEMPO</header>
    
    <main>
        <form action="../scripts/submit_quest.php" method="POST" class="quest-form">
            <h2>Questionário de Satisfação</h2>
            <p>Agradecemos por participar! Por favor, avalie os seguintes pontos de 0 (péssimo) a 5 (excelente).</p>

            <div class="form-group">
                <label for="nome">Seu Nome:</label>
                <input type="text" id="nome" name="nome" required>
            </div>

            <div class="form-group">
                <label>Qual seu nível de satisfação geral com o evento?</label>
                <div class="radio-group">
                    <input type="radio" id="satisf-geral-0" name="satisf-geral" value="0" required><label for="satisf-geral-0">0</label>
                    <input type="radio" id="satisf-geral-1" name="satisf-geral" value="1"><label for="satisf-geral-1">1</label>
                    <input type="radio" id="satisf-geral-2" name="satisf-geral" value="2"><label for="satisf-geral-2">2</label>
                    <input type="radio" id="satisf-geral-3" name="satisf-geral" value="3"><label for="satisf-geral-3">3</label>
                    <input type="radio" id="satisf-geral-4" name="satisf-geral" value="4"><label for="satisf-geral-4">4</label>
                    <input type="radio" id="satisf-geral-5" name="satisf-geral" value="5"><label for="satisf-geral-5">5</label>
                </div>
            </div>

            <div class="form-group">
                <label>Como você avalia a organização do evento?</label>
                <div class="radio-group">
                    <input type="radio" id="organizacao-0" name="organizacao" value="0" required><label for="organizacao-0">0</label>
                    <input type="radio" id="organizacao-1" name="organizacao" value="1"><label for="organizacao-1">1</label>
                    <input type="radio" id="organizacao-2" name="organizacao" value="2"><label for="organizacao-2">2</label>
                    <input type="radio" id="organizacao-3" name="organizacao" value="3"><label for="organizacao-3">3</label>
                    <input type="radio" id="organizacao-4" name="organizacao" value="4"><label for="organizacao-4">4</label>
                    <input type="radio" id="organizacao-5" name="organizacao" value="5"><label for="organizacao-5">5</label>
                </div>
            </div>

            <div class="form-group">
                <label>Como você avalia as apresentações do evento?</label>
                <div class="radio-group">
                    <input type="radio" id="apresentacoes-0" name="apresentacoes" value="0" required><label for="apresentacoes-0">0</label>
                    <input type="radio" id="apresentacoes-1" name="apresentacoes" value="1"><label for="apresentacoes-1">1</label>
                    <input type="radio" id="apresentacoes-2" name="apresentacoes" value="2"><label for="apresentacoes-2">2</label>
                    <input type="radio" id="apresentacoes-3" name="apresentacoes" value="3"><label for="apresentacoes-3">3</label>
                    <input type="radio" id="apresentacoes-4" name="apresentacoes" value="4"><label for="apresentacoes-4">4</label>
                    <input type="radio" id="apresentacoes-5" name="apresentacoes" value="5"><label for="apresentacoes-5">5</label>
                </div>
            </div>

            <div class="form-group">
                <label>Como você avalia o local e a estrutura?</label>
                <div class="radio-group">
                    <input type="radio" id="local-0" name="local" value="0" required><label for="local-0">0</label>
                    <input type="radio" id="local-1" name="local" value="1"><label for="local-1">1</label>
                    <input type="radio" id="local-2" name="local" value="2"><label for="local-2">2</label>
                    <input type="radio" id="local-3" name="local" value="3"><label for="local-3">3</label>
                    <input type="radio" id="local-4" name="local" value="4"><label for="local-4">4</label>
                    <input type="radio" id="local-5" name="local" value="5"><label for="local-5">5</label>
                </div>
            </div>

            <div class="form-group">
                <label>Como você avalia a divulgação do evento?</label>
                <div class="radio-group">
                    <input type="radio" id="divulgacao-0" name="divulgacao" value="0" required><label for="divulgacao-0">0</label>
                    <input type="radio" id="divulgacao-1" name="divulgacao" value="1"><label for="divulgacao-1">1</label>
                    <input type="radio" id="divulgacao-2" name="divulgacao" value="2"><label for="divulgacao-2">2</label>
                    <input type="radio" id="divulgacao-3" name="divulgacao" value="3"><label for="divulgacao-3">3</label>
                    <input type="radio" id="divulgacao-4" name="divulgacao" value="4"><label for="divulgacao-4">4</label>
                    <input type="radio" id="divulgacao-5" name="divulgacao" value="5"><label for="divulgacao-5">5</label>
                </div>
            </div>

            <div class="form-group">
                <button type="submit">Enviar Avaliação</button>
            </div>
        </form>
    </main>

    <footer>capsula 2015 - 2025</footer>
    <script src="../assets/js/sidebar.js"></script>
</body>
</html>