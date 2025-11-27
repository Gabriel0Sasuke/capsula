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

    <title>Sobre o projeto</title>
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

                <p>O tempo é uma força inexorável que, em seu fluxo contínuo, tende a diluir memórias e transformar realidades. Contra essa efemeridade, o projeto da cápsula do tempo, idealizado e concretizado na ETEC Jardim Ângela em 2015, ergue-se como um ato de resistência e afeto. A iniciativa não se limitou a ser um mero arquivamento de objetos físicos; ela constituiu um esforço coletivo para cristalizar a essência de uma geração, capturando o espírito, as angústias e as esperanças de um grupo de estudantes em um momento singular de suas trajetórias. Ao reunir cartas, fotografias, artefatos e registros escritos, o projeto transcendeu a materialidade para se tornar um guardião da identidade daquele período escolar.</p>

                <img src="../assets/img/content/imagens-2015/sala-2015.jpg" alt="" id="foto-sobre">

                <p>O ambiente da ETEC, em 2015, serviu como o cenário de vivências intensas e formadoras. A cápsula, nesse contexto, funcionou como um espelho do cotidiano estudantil, refletindo a importância das relações interpessoais e do convívio diário na construção da subjetividade. O caráter sentimental impregnado em cada contribuição demonstra que a escola era mais do que um espaço de aprendizado técnico; era um território de encontros, de construção de laços e de descobertas pessoais. As mensagens ali depositadas carregam a autenticidade de quem vivia o presente com intensidade, sem a consciência plena das transformações que a década seguinte traria.</p>

                <img src="" alt="" id="foto-sobre"> <!-- achei melhor colocar as imagens do projeto pronto, depois do postifólio -->

                <p>À medida que os anos avançam, a função simbólica da cápsula se amplifica. Ela deixa de ser apenas um registro do passado para se tornar uma ponte de diálogo entre tempos distintos. Para os participantes, a reabertura desse arquivo representa um confronto inevitável com o próprio amadurecimento. O reencontro com as expectativas de outrora permite mensurar o quanto se caminhou, quais sonhos foram realizados e quais rotas foram recalculadas. É um exercício pedagógico e existencial que valida a história individual dentro da narrativa coletiva, reforçando o sentimento de pertencimento àquela comunidade escolar.</p>

                <img src="" alt="" id="foto-sobre">

                <p>Entretanto, é na sutileza dos silêncios que o projeto revela sua camada mais profunda. Entre as memórias preservadas, há também o registro implícito das ausências. A cápsula do tempo, ao congelar um instante de 2015, torna evidente o contraste com o presente, marcando o espaço daquilo — e daqueles — que não atravessaram a década da mesma forma. O luto e a saudade, embora não ditos explicitamente, permeiam a experiência de revisitar o passado, conferindo ao projeto uma dignidade solene. Essas lacunas não diminuem o valor da memória; pelo contrário, elas ensinam que recordar é também uma forma de honrar a permanência do afeto, mesmo diante da transitoriedade da vida.</p>
                
                <img src="" alt="" id="foto-sobre">

                <p>Em suma, a cápsula do tempo da ETEC Jardim Ângela não é um monumento estático, mas um organismo vivo de memória. Ela guarda a ingenuidade, a força e a verdade de 2015, oferecendo-as como um presente ao futuro. Ao ser reaberta, espera-se que seu conteúdo atue como um abraço acolhedor vindo do passado, lembrando a cada ex-aluno que, independentemente dos caminhos trilhados ou das perdas enfrentadas, a história vivida naquele lugar permanece intacta, valorosa e fundamental para a compreensão de quem eles se tornaram hoje.</p>

                <img src="" alt="" id="foto-sobre">

            </div>

            <div class="creditos">
                <h2>Créditos</h2>
                <ul>
                    <li><strong>Orientador(a):</strong> Prof. Valéria Silva</li>
                    <li><strong>Instituição:</strong> ETEC Jardim Ângela</li>
                    <li><strong>Projeto realizado por:</strong> 2º Ano 2015</li>
                    <li><strong>Desenvolvedores: <br> </strong> Gabriel P. <br> Wilson R. <br> Carlos V.</li>
                </ul>
            </div>
        </div>
    </main>

    <footer>capsula 2015 - 2025</footer>
    <script src="../assets/js/sidebar.js"></script>
</body>
</html>