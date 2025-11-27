<?php
session_start();

require_once '../scripts/conn.php';

$sql = 'SELECT * FROM post ORDER BY data_publicacao DESC';
$result = $conn->query($sql);
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$celular = false;
if (preg_match('/Mobi|Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i', $user_agent)) {
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
        <link rel="stylesheet" href="../assets/css/desktop/galeria.css">
    <?php  } else { ?>
        <link rel="stylesheet" href="../assets/css/mobile/index-mobile.css">
        <link rel="stylesheet" href="../assets/css/mobile/galeria-mobile.css">
    <?php }?>

    <title>Galeria</title>
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
    
    <main class="gallery-main">
        <div class="gallery-header">
            <h1>Nossa Galeria de Memórias</h1>
            <p>Uma coleção de momentos e pensamentos compartilhados.</p>
            <hr class="divider">
        </div>

        <div class="posts-wrapper">
            <!-- <div class="posts-container">
                <?php
                if ($result->num_rows > 0) {
                    $counter = 0;
                    while($row = $result->fetch_assoc()) {
                        $align_class = ($counter % 2 == 0) ? 'align-left' : 'align-right';
                        echo '<div class="post-item ' . $align_class . '">';
                        echo '  <img src="../' . htmlspecialchars($row["imagem"]) . '" alt="Imagem da galeria">';
                        echo '  <div class="post-caption">';
                        echo '      <p>' . nl2br(htmlspecialchars($row["texto"])) . '</p>';
                        echo '  </div>';
                        echo '</div>';
                        $counter++;
                    }
                } else {
                    echo "<p class='no-images'>Nenhuma imagem encontrada na galeria.</p>";
                }
                $conn->close();
                ?>
            </div> -->

            <div class="posts-container">
                <!-- Imagens de Teste -->
                <div class="post-item align-left">
                  <img src="../assets/img/ui/placeholder.png" alt="Imagem de teste 1">
                  <div class="post-caption">
                      <p>Esta é uma legenda de teste para a primeira imagem. O texto aqui serve para demonstrar como a legenda se ajusta ao contêiner, permitindo uma breve descrição ou reflexão sobre o momento capturado.</p>
                  </div>
                </div>

                <div class="post-item align-right">
                  <img src="../assets/img/ui/placeholder.png" alt="Imagem de teste 2">
                  <div class="post-caption">
                      <p>Esta é a legenda para a segunda imagem de teste. A formatação alterna entre esquerda e direita para criar um layout mais dinâmico e interessante para o visitante.</p>
                  </div>
                </div>

                <div class="post-item align-left">
                  <img src="../assets/img/ui/placeholder.png" alt="Imagem de teste 1">
                  <div class="post-caption">
                      <p>Esta é uma legenda de teste para a primeira imagem. O texto aqui serve para demonstrar como a legenda se ajusta ao contêiner, permitindo uma breve descrição ou reflexão sobre o momento capturado.</p>
                  </div>
                </div>

                <div class="post-item align-right">
                  <img src="../assets/img/ui/placeholder.png" alt="Imagem de teste 2">
                  <div class="post-caption">
                      <p>Esta é a legenda para a segunda imagem de teste. A formatação alterna entre esquerda e direita para criar um layout mais dinâmico e interessante para o visitante.</p>
                  </div>
                </div>
            </div>
        </div>
    </main>

    <footer>capsula 2015 - 2025</footer>
    <script src="../assets/js/sidebar.js"></script>
</body>
</html>