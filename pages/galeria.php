<?php
session_start();

require_once '../scripts/conn.php';

// Pegar apenas posts do tipo galeria
$sql = "SELECT * FROM post WHERE tipo_post = 'galeria' ORDER BY data_publicacao DESC";
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
            <div class="posts-container">
                <?php
                if ($result && $result->num_rows > 0) {
                    $counter = 0;
                    while($row = $result->fetch_assoc()) {
                        $align_class = ($counter % 2 == 0) ? 'align-left' : 'align-right';
                        
                        $img = $row['imagem'];
                        $imgSrc = '../assets/img/ui/placeholder.png';
                        if ($img) {
                            if (strpos($img, 'uploads/') === 0) {
                                $imgSrc = '../' . $img;
                            } else {
                                $imgSrc = '../uploads/' . $img;
                            }
                        }
                        
                        echo '<div class="post-item ' . $align_class . '">';
                        echo '  <img src="' . htmlspecialchars($imgSrc) . '" alt="Imagem da galeria">';
                        echo '  <div class="post-caption">';
                        echo '      <p>' . nl2br(htmlspecialchars($row['conteudo'])) . '</p>';
                        echo '  </div>';
                        echo '</div>';
                        $counter++;
                    }
                } else {
                    echo "<p class='no-images'>Nenhuma imagem encontrada na galeria.</p>";
                }
                ?>
            </div>
        </div>
    </main>

    <footer>capsula 2015 - 2025</footer>
    <script src="../assets/js/sidebar.js"></script>
    <script>
            document.addEventListener('DOMContentLoaded', function() {
        const images = document.querySelectorAll('img');
    
        images.forEach(img => {
        img.addEventListener('error', function() {
            this.src = '../assets/img/content/placeholder.jpeg';
            this.alt = 'Imagem não encontrada';
            });
        });
    });
    </script>
</body>
</html>