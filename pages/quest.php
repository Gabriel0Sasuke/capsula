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
        <form action="../scripts/proc_quest.php" method="POST" class="quest-form">
            <h2>Questionário de Satisfação</h2>
            <p>Agradecemos por participar! Por favor, avalie os seguintes pontos de 0 (péssimo) a 5 (excelente).</p>

            <div class="form-group">
                <label for="nome">Seu Nome:</label>
                <input type="text" id="nome" name="nome" required>
            </div>

            <div class="form-group">
                <label>Qual seu nível de satisfação geral com o evento?</label>
                <div class="radio-group">
                    <input type="radio" id="satisf-geral-0" name="satisf_geral" value="0" required><label for="satisf-geral-0">0</label>
                    <input type="radio" id="satisf-geral-1" name="satisf_geral" value="1"><label for="satisf-geral-1">1</label>
                    <input type="radio" id="satisf-geral-2" name="satisf_geral" value="2"><label for="satisf-geral-2">2</label>
                    <input type="radio" id="satisf-geral-3" name="satisf_geral" value="3"><label for="satisf-geral-3">3</label>
                    <input type="radio" id="satisf-geral-4" name="satisf_geral" value="4"><label for="satisf-geral-4">4</label>
                    <input type="radio" id="satisf-geral-5" name="satisf_geral" value="5"><label for="satisf-geral-5">5</label>
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
                <label>O quanto você se sentiu nostálgico(a) ou com 'saudade' durante o evento?</label>
                <div class="radio-group">
                    <input type="radio" id="nostalgia-0" name="nostalgia" value="0" required><label for="nostalgia-0">0</label>
                    <input type="radio" id="nostalgia-1" name="nostalgia" value="1"><label for="nostalgia-1">1</label>
                    <input type="radio" id="nostalgia-2" name="nostalgia" value="2"><label for="nostalgia-2">2</label>
                    <input type="radio" id="nostalgia-3" name="nostalgia" value="3"><label for="nostalgia-3">3</label>
                    <input type="radio" id="nostalgia-4" name="nostalgia" value="4"><label for="nostalgia-4">4</label>
                    <input type="radio" id="nostalgia-5" name="nostalgia" value="5"><label for="nostalgia-5">5</label>
                </div>
            </div>

            <div class="form-group">
                <label>O quanto a cápsula fez você lembrar de fatos ou sentimentos que já tinha esquecido?</label>
                <div class="radio-group">
                    <input type="radio" id="lembrar-0" name="lembrar" value="0" required><label for="lembrar-0">0</label>
                    <input type="radio" id="lembrar-1" name="lembrar" value="1"><label for="lembrar-1">1</label>
                    <input type="radio" id="lembrar-2" name="lembrar" value="2"><label for="lembrar-2">2</label>
                    <input type="radio" id="lembrar-3" name="lembrar" value="3"><label for="lembrar-3">3</label>
                    <input type="radio" id="lembrar-4" name="lembrar" value="4"><label for="lembrar-4">4</label>
                    <input type="radio" id="lembrar-5" name="lembrar" value="5"><label for="lembrar-5">5</label>
                </div>
            </div>

            <div class="form-group">
                <label>O quanto você se sentiu conectado(a) com a pessoa que você era há 10 anos?</label>
                <div class="radio-group">
                    <input type="radio" id="conectado-0" name="conectado" value="0" required><label for="conectado-0">0</label>
                    <input type="radio" id="conectado-1" name="conectado" value="1"><label for="conectado-1">1</label>
                    <input type="radio" id="conectado-2" name="conectado" value="2"><label for="conectado-2">2</label>
                    <input type="radio" id="conectado-3" name="conectado" value="3"><label for="conectado-3">3</label>
                    <input type="radio" id="conectado-4" name="conectado" value="4"><label for="conectado-4">4</label>
                    <input type="radio" id="conectado-5" name="conectado" value="5"><label for="conectado-5">5</label>
                </div>
            </div>

            <div class="form-group">
                <label>O quanto este evento fez você refletir sobre o quanto você mudou e amadureceu desde 2015?</label>
                <div class="radio-group">
                    <input type="radio" id="refletir-0" name="refletir" value="0" required><label for="refletir-0">0</label>
                    <input type="radio" id="refletir-1" name="refletir" value="1"><label for="refletir-1">1</label>
                    <input type="radio" id="refletir-2" name="refletir" value="2"><label for="refletir-2">2</label>
                    <input type="radio" id="refletir-3" name="refletir" value="3"><label for="refletir-3">3</label>
                    <input type="radio" id="refletir-4" name="refletir" value="4"><label for="refletir-4">4</label>
                    <input type="radio" id="refletir-5" name="refletir" value="5"><label for="refletir-5">5</label>
                </div>
            </div>

            <div class="form-group">
                <label>Qual foi a intensidade da emoção que você sentiu no momento da abertura da cápsula?</label>
                <div class="radio-group">
                    <input type="radio" id="emocao-0" name="emocao" value="0" required><label for="emocao-0">0</label>
                    <input type="radio" id="emocao-1" name="emocao" value="1"><label for="emocao-1">1</label>
                    <input type="radio" id="emocao-2" name="emocao" value="2"><label for="emocao-2">2</label>
                    <input type="radio" id="emocao-3" name="emocao" value="3"><label for="emocao-3">3</label>
                    <input type="radio" id="emocao-4" name="emocao" value="4"><label for="emocao-4">4</label>
                    <input type="radio" id="emocao-5" name="emocao" value="5"><label for="emocao-5">5</label>
                </div>
            </div>

            <div class="form-group">
                <label>O quanto você sentiu que a emoção das outras pessoas contagiou o ambiente?</label>
                <div class="radio-group">
                    <input type="radio" id="contagio-0" name="contagio" value="0" required><label for="contagio-0">0</label>
                    <input type="radio" id="contagio-1" name="contagio" value="1"><label for="contagio-1">1</label>
                    <input type="radio" id="contagio-2" name="contagio" value="2"><label for="contagio-2">2</label>
                    <input type="radio" id="contagio-3" name="contagio" value="3"><label for="contagio-3">3</label>
                    <input type="radio" id="contagio-4" name="contagio" value="4"><label for="contagio-4">4</label>
                    <input type="radio" id="contagio-5" name="contagio" value="5"><label for="contagio-5">5</label>
                </div>
            </div>

            <div class="form-group">
                <label>O quanto este evento trouxe uma sensação de 'fechamento de ciclo' ou de paz com o passado?</label>
                <div class="radio-group">
                    <input type="radio" id="fechamento-0" name="fechamento" value="0" required><label for="fechamento-0">0</label>
                    <input type="radio" id="fechamento-1" name="fechamento" value="1"><label for="fechamento-1">1</label>
                    <input type="radio" id="fechamento-2" name="fechamento" value="2"><label for="fechamento-2">2</label>
                    <input type="radio" id="fechamento-3" name="fechamento" value="3"><label for="fechamento-3">3</label>
                    <input type="radio" id="fechamento-4" name="fechamento" value="4"><label for="fechamento-4">4</label>
                    <input type="radio" id="fechamento-5" name="fechamento" value="5"><label for="fechamento-5">5</label>
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