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
        <link rel="stylesheet" href="../assets/css/desktop/sobre.css">
    <?php  } else { ?>
        <link rel="stylesheet" href="../assets/css/mobile/index-mobile.css">
        <link rel="stylesheet" href="../assets/css/mobile/sobre-mobile.css">
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

    <main class="sobre-main">
        <div class="sobre-container">
            <div class="about">
                <h1>Sobre o Projeto</h1>
                <p>
                    O projeto da cápsula do tempo desenvolvido na ETEC Jardim Ângela em 2015 foi idealizado para preservar memórias e experiências significativas de um grupo de estudantes. A iniciativa consiste em reunir mensagens, objetos e registros que refletem os principais sentimentos, expectativas e vivências daquele período escolar. O caráter sentimental presente nas contribuições demonstra a importância do afeto, das relações interpessoais e das experiências compartilhadas para a formação da identidade individual e coletiva.
                </p>

                <p>
                    A cápsula do tempo também desempenha um papel simbólico ao permitir que, em um futuro determinado, participantes revisitem as lembranças e compreendam as transformações ocorridas ao longo dos anos. Certos aspectos, tais como perdas e ausências, estão presentes de modo sutil entre os registros, conferindo profundidade à reflexão e reforçando o valor da memória. Assim, o projeto se estabelece como um convite à valorização do passado, à empatia e ao reconhecimento da importância da trajetória vivida na escola.
                </p>

                <p>
                    Esta cápsula do tempo não guarda apenas objetos, mas a essência de quem passou pela ETEC Jardim Ângela em 2015. Ao ser reaberta, espera-se que cada lembrança resgatada sirva como um abraço no passado e uma inspiração para o futuro, mantendo viva a memória daqueles dias e daqueles que fizeram parte dessa história.
                </p>
            </div>

            <div class="creditos">
                <h2>Créditos</h2>
                <ul>
                    <li><strong>Orientador(a):</strong> Prof. Valéria Silva</li>
                    <li><strong>Instituição:</strong> ETEC Jardim Ângela</li>
                    <li><strong>Projeto realizado por:</strong> 2DSA - 2025 & 2XXX - 2015</li>
                    <li><strong>Desenvolvedores: <br> </strong> Gabriel P. <br> Wilson R. <br> Carlos V.</li>
                    <li><strong>Redes de Divulgação: <br> </strong> <a href="#" target="_blank">@capsula_etec (Instagram)</a> <br> <a href="#" target="_blank">capsula_etec (Facebook)</a></li>
                </ul>
            </div>
        </div>
    </main>

    <footer>capsula 2015 - 2025</footer>
    <script src="../assets/js/sidebar.js"></script>
</body>
</html>