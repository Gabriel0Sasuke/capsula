<?php
session_start();

require_once 'scripts/conn.php';

$sql = 'SELECT * FROM post ORDER BY data_publicacao DESC';
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Capsula - Home</title>

    <?php
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    if (!preg_match('/Mobi|Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i', $user_agent)) {
    ?>
        <link rel="stylesheet" href="assets/css/index.css">
    <?php  } else { ?>
        <link rel="stylesheet" href="assets/css/index-mobile.css">
    <?php } ?>

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+Round">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Quintessential&display=swap">
</head>

<body>

    <div id="sidebar" class="sidebar">
        <a href=""><i class="material-icons-round">home</i>Início</a>
        <a href="#"><i class="material-icons-round">info</i>Sobre o Projeto</a>
        <a href="#"><i class="material-icons-round">rate_review</i>Questionário</a>
        <a href="pages/admin.php"><i class="material-icons-round">shield</i>Admin</a>
    </div>

    <button id="sidebar-toggle">☰</button>

    <header>CAPSULA DO TEMPO</header>

    <main>
        <section class="blog">
            <h1>Novidades da capsula!</h1>

            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <?php
                    $img = $row['imagem'];
                    $texto = $row['conteudo'];
                    $dataRaw = $row['data_publicacao'];

                    $imgSrc = 'assets/img/ui/placeholder.png';
                    if ($img) {
                        if (preg_match('#^(https?:)?//#', $img) || strpos($img, '/') === 0) {
                            $imgSrc = $img;
                        } elseif (strpos($img, 'uploads/') === 0) {
                            $imgSrc = $img;
                        } else {
                            $imgSrc = 'uploads/' . $img;
                        }
                    }

                    $dataFmt = $dataRaw ? date('d/m/Y', strtotime($dataRaw)) : '';
                    ?>
                    <article class="noticias">
                        <img src="<?php echo htmlspecialchars($imgSrc); ?>" alt="" class="news-img">
                        <p><?php echo nl2br(htmlspecialchars($texto)); ?></p>
                        <?php if ($dataFmt): ?>
                            <div class="news-data" id="news-data"><?php echo htmlspecialchars($dataFmt); ?></div>
                        <?php endif; ?>
                    </article>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Nenhum post encontrado.</p>
            <?php endif; ?>
        </section>

        <div class="container-direita">
            <section class="relogio">
                <h1>FALTAM <strong id="dias_evento">99</strong> DIAS PARA O EVENTO</h1>
                <div id="clock">00:00:00</div>
            </section>

            <button id="btn-quest">Questionário</button>
        </div>

    </main>

    <footer>capsula 2015 - 2025</footer>

    <script src="assets/js/sidebar.js"></script>
    <script src="assets/js/relogio.js"></script>
</body>

</html>