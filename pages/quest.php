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
    <link rel="icon" type="image/svg+xml" href="../assets/img/ui/ampulheta.svg">

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
        <a href="galeria.php"><i class="material-icons-round">photo_library</i>Galeria</a>
        <a href="admin.php"><i class="material-icons-round">shield</i>Admin</a>
    </div>

    <button id="sidebar-toggle">☰</button>

    <header>CAPSULA DO TEMPO</header>
    
    <main>
        <form action="../scripts/proc_quest.php" method="POST" class="quest-form">
            <h2>💌 Questionário da Cápsula do Tempo</h2>
            <p>Passaram-se 10 anos desde 2015... Queremos saber como você se sente ao reencontrar memórias do passado. Responda com o coração! 💫</p>

            <div class="form-group">
                <label for="nome">Seu Nome:</label>
                <input type="text" id="nome" name="nome" placeholder="Como você gostaria de ser lembrado(a)?" required>
            </div>

            <!-- SEÇÃO: MEMÓRIAS E EMOÇÕES -->
            <div class="section-title">🕰️ Memórias e Emoções</div>

            <div class="form-group">
                <label>O quanto você se emocionou ao abrir a cápsula do tempo?</label>
                <p class="hint">0 = Não me emocionei | 5 = Chorei muito</p>
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
                <label for="lembranca_especial">Qual foi a lembrança mais especial que você reencontrou hoje?</label>
                <textarea id="lembranca_especial" name="lembranca_especial" rows="3" placeholder="Pode ser uma foto, um bilhete, um objeto... conte pra gente!" required></textarea>
            </div>

            <div class="form-group">
                <label>O quanto você se sentiu conectado(a) com a pessoa que você era em 2015?</label>
                <p class="hint">0 = Nem me reconheci | 5 = Ainda sou a mesma pessoa</p>
                <div class="radio-group">
                    <input type="radio" id="conexao-0" name="conexao" value="0" required><label for="conexao-0">0</label>
                    <input type="radio" id="conexao-1" name="conexao" value="1"><label for="conexao-1">1</label>
                    <input type="radio" id="conexao-2" name="conexao" value="2"><label for="conexao-2">2</label>
                    <input type="radio" id="conexao-3" name="conexao" value="3"><label for="conexao-3">3</label>
                    <input type="radio" id="conexao-4" name="conexao" value="4"><label for="conexao-4">4</label>
                    <input type="radio" id="conexao-5" name="conexao" value="5"><label for="conexao-5">5</label>
                </div>
            </div>

            <!-- SEÇÃO: REFLEXÕES PESSOAIS -->
            <div class="section-title">🪞 Reflexões Pessoais</div>

            <div class="form-group">
                <label for="mudanca">O que mais mudou em você nesses 10 anos?</label>
                <textarea id="mudanca" name="mudanca" rows="3" placeholder="Física, personalidade, sonhos, forma de pensar..." required></textarea>
            </div>

            <div class="form-group">
                <label for="sonho_2015">Você lembra de algum sonho que tinha em 2015? Ele se realizou?</label>
                <textarea id="sonho_2015" name="sonho_2015" rows="3" placeholder="Conte sobre seus sonhos de 10 anos atrás..."></textarea>
            </div>

            <div class="form-group">
                <label>O quanto você realizou dos planos que tinha quando era mais novo(a)?</label>
                <p class="hint">0 = Nada se realizou | 5 = Realizei tudo e mais</p>
                <div class="radio-group">
                    <input type="radio" id="realizacao-0" name="realizacao" value="0" required><label for="realizacao-0">0</label>
                    <input type="radio" id="realizacao-1" name="realizacao" value="1"><label for="realizacao-1">1</label>
                    <input type="radio" id="realizacao-2" name="realizacao" value="2"><label for="realizacao-2">2</label>
                    <input type="radio" id="realizacao-3" name="realizacao" value="3"><label for="realizacao-3">3</label>
                    <input type="radio" id="realizacao-4" name="realizacao" value="4"><label for="realizacao-4">4</label>
                    <input type="radio" id="realizacao-5" name="realizacao" value="5"><label for="realizacao-5">5</label>
                </div>
            </div>

            <!-- SEÇÃO: AMIZADES E CONEXÕES -->
            <div class="section-title">👥 Amizades e Conexões</div>

            <div class="form-group">
                <label for="amigo_saudade">De qual colega da turma de 2015 você sentiu mais saudade?</label>
                <input type="text" id="amigo_saudade" name="amigo_saudade" placeholder="Nome do(a) colega...">
            </div>

            <div class="form-group">
                <label>Você ainda mantém contato com os colegas de 2015?</label>
                <p class="hint">0 = Perdi contato com todos | 5 = Falo com todos frequentemente</p>
                <div class="radio-group">
                    <input type="radio" id="contato-0" name="contato" value="0" required><label for="contato-0">0</label>
                    <input type="radio" id="contato-1" name="contato" value="1"><label for="contato-1">1</label>
                    <input type="radio" id="contato-2" name="contato" value="2"><label for="contato-2">2</label>
                    <input type="radio" id="contato-3" name="contato" value="3"><label for="contato-3">3</label>
                    <input type="radio" id="contato-4" name="contato" value="4"><label for="contato-4">4</label>
                    <input type="radio" id="contato-5" name="contato" value="5"><label for="contato-5">5</label>
                </div>
            </div>

            <!-- SEÇÃO: MENSAGEM PARA O FUTURO -->
            <div class="section-title">✨ Mensagem para o Futuro</div>

            <div class="form-group">
                <label for="conselho_passado">Se pudesse voltar no tempo, que conselho daria para você de 2015?</label>
                <textarea id="conselho_passado" name="conselho_passado" rows="4" placeholder="O que você gostaria de ter ouvido quando era mais jovem?" required></textarea>
            </div>

            <div class="form-group">
                <label for="mensagem_futuro">Deixe uma mensagem para você daqui a 10 anos (2035):</label>
                <textarea id="mensagem_futuro" name="mensagem_futuro" rows="4" placeholder="O que você espera para o futuro? O que deseja lembrar?"></textarea>
            </div>

            <div class="form-group">
                <label>No geral, como você se sentiu participando deste momento especial?</label>
                <p class="hint">0 = Indiferente | 5 = Foi um dos melhores momentos da minha vida</p>
                <div class="radio-group">
                    <input type="radio" id="sentimento_geral-0" name="sentimento_geral" value="0" required><label for="sentimento_geral-0">0</label>
                    <input type="radio" id="sentimento_geral-1" name="sentimento_geral" value="1"><label for="sentimento_geral-1">1</label>
                    <input type="radio" id="sentimento_geral-2" name="sentimento_geral" value="2"><label for="sentimento_geral-2">2</label>
                    <input type="radio" id="sentimento_geral-3" name="sentimento_geral" value="3"><label for="sentimento_geral-3">3</label>
                    <input type="radio" id="sentimento_geral-4" name="sentimento_geral" value="4"><label for="sentimento_geral-4">4</label>
                    <input type="radio" id="sentimento_geral-5" name="sentimento_geral" value="5"><label for="sentimento_geral-5">5</label>
                </div>
            </div>

            <div class="form-group">
                <button type="submit">💌 Enviar Minhas Memórias</button>
            </div>
        </form>
    </main>

    <footer>capsula 2015 - 2025</footer>
    <script src="../assets/js/sidebar.js"></script>
</body>
</html>