<?php
session_start();

require_once 'scripts/conn.php';
//Implementação de detecção de dispostivo pra contagem de visitantes
if(isset($_SESSION['visited'])) {
    // Usuário já foi contado nesta sessão
} else {
    // Novo visitante nesta sessão
    $user_ip = $_SERVER['REMOTE_ADDR'] ?? 'IP desconhecido';
    $user_agent_completo = $_SERVER['HTTP_USER_AGENT'] ?? 'Navegador desconhecido';
    
    // Detecta o Navegador (Ordem importa pois Chrome inclui Safari, Edge inclui Chrome, etc)
    $user_navegador = 'Outro';
    if (stripos($user_agent_completo, 'Edg') !== false) {
        $user_navegador = 'Edge';
    } elseif (stripos($user_agent_completo, 'OPR') !== false || stripos($user_agent_completo, 'Opera') !== false) {
        $user_navegador = 'Opera';
    } elseif (stripos($user_agent_completo, 'Chrome') !== false) {
        $user_navegador = 'Chrome';
    } elseif (stripos($user_agent_completo, 'Firefox') !== false) {
        $user_navegador = 'Firefox';
    } elseif (stripos($user_agent_completo, 'Safari') !== false) {
        $user_navegador = 'Safari';
    }

    // Detecta o Sistema Operacional do Cliente
    $user_sistema_operacional = 'Outro';
    if (preg_match('/android/i', $user_agent_completo)) {
        $user_sistema_operacional = 'Android';
    } elseif (preg_match('/iphone|ipad|ipod/i', $user_agent_completo)) {
        $user_sistema_operacional = 'iOS';
    } elseif (preg_match('/windows/i', $user_agent_completo)) {
        $user_sistema_operacional = 'Windows';
    } elseif (preg_match('/linux/i', $user_agent_completo)) {
        $user_sistema_operacional = 'Linux';
    } elseif (preg_match('/macintosh|mac os x/i', $user_agent_completo)) {
        $user_sistema_operacional = 'Mac OS';
    }

    $stmt = $conn->prepare("INSERT INTO visitas (user_ip, user_navegador, user_sistema_operacional) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $user_ip, $user_navegador, $user_sistema_operacional);
    $stmt->execute();
    $stmt->close();

    $_SESSION['visited'] = true; // Marca que o usuário já foi contado
}

//Pegar Dados da tabela post (apenas posts gerais)
$sql = "SELECT * FROM post WHERE tipo_post = 'post_geral' ORDER BY data_publicacao DESC";
$result = $conn->query($sql);

//Implementação de detecção de dispostivos pra responsividade
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$celular = false;
if (!preg_match('/Mobi|Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i', $user_agent)) {
    $celular = false;
} else {
    $celular = true;
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Capsula - Home</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php
    if ($celular == false) {
    ?>
        <link rel="stylesheet" href="assets/css/desktop/index.css">
    <?php  } else { ?>
        <link rel="stylesheet" href="assets/css/mobile/index-mobile.css">
    <?php } ?>

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+Round">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Quintessential&display=swap">
    <link rel="icon" type="image/svg+xml" href="assets/img/ui/ampulheta.svg">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Biblioteca sweetalert2 --> 
</head>

<body>

    <div id="sidebar" class="sidebar">
        <a href="index.php"><i class="material-icons-round">home</i>Início</a>
        <a href="pages/sobre.php"><i class="material-icons-round">info</i>Sobre o Projeto</a>
        <a href="pages/quest.php"><i class="material-icons-round">rate_review</i>Questionário</a>
        <a href="pages/galeria.php"><i class="material-icons-round">photo_library</i>Galeria</a>
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
                        <img src="<?php echo htmlspecialchars($imgSrc); ?>" class="news-img">
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
                <?php if ($celular) { ?>
                    <div id="btn-close">
                        <button id="fechar"><svg xmlns="http://www.w3.org/2000/svg" height="60%" viewBox="0 -960 960 960" width="60%" fill="#d8d08b"><path d="m300-258-42-42 180-180-180-179 42-42 180 180 179-180 42 42-180 179 180 180-42 42-179-180-180 180Z"/></svg></button>
                    </div>
                <?php } ?>
                <h1>FALTAM <strong id="dias_evento">99</strong> DIAS PARA O EVENTO</h1>
                <div id="clock">00:00:00</div>
            </section>
            <?php if ($celular) { ?>
        </div>
        <button id="btn-quest" onclick="location.href='pages/quest.php'">Questionário</button>
    <?php } else { ?>
        <button id="btn-quest" onclick="location.href='pages/quest.php'">Questionário</button>
        </div>
    <?php } ?>

    </main>

    
    <?php
    if ($celular) {
        ?>
        <div id="btn-timer">
            <p>&#x23F1;</p>
        </div>
        <script src="assets/js/timer_click.js"></script>
        <?php } ?>
    <footer>capsula 2015 - 2025</footer>
    <script src="assets/js/sidebar.js"></script>
    <script src="assets/js/relogio.js"></script>
    <script>
    <?php
    if (isset($_SESSION['msg_id'])) {
        $id = $_SESSION['msg_id'];
         switch ($id) {
            case 9:
            echo "Swal.fire({
                            toast: true,
                            position: 'bottom-end', // canto inferior direito
                            icon: 'success',
                            title: 'Sucesso!',
                            text: 'Logout realizado com sucesso.',
                            showConfirmButton: false,
                            timer: 4000,              // 4 segundos
                            timerProgressBar: true    // barrinha embaixo
                            });";
                            break;
            case 10:
            echo "Swal.fire({
                            toast: true,
                            position: 'bottom-end', // canto inferior direito
                            icon: 'error',
                            title: 'Erro!',
                            text: 'Falha ao enviar questionário.',
                            showConfirmButton: false,
                            timer: 4000,              // 4 segundos
                            timerProgressBar: true    // barrinha embaixo
                            });";
                            break;
            case 11:
            echo "Swal.fire({
                            toast: true,
                            position: 'bottom-end', // canto inferior direito
                            icon: 'error',
                            title: 'Erro!',
                            text: 'Falha ao enviar respostas.',
                            showConfirmButton: false,
                            timer: 4000,              // 4 segundos
                            timerProgressBar: true    // barrinha embaixo
                            });";
                            break;
            case 12:
            echo "Swal.fire({
                            toast: true,
                            position: 'bottom-end', // canto inferior direito
                            icon: 'success',
                            title: 'Sucesso!',
                            text: 'Questionário enviado com sucesso.',
                            showConfirmButton: false,
                            timer: 4000,              // 4 segundos
                            timerProgressBar: true    // barrinha embaixo
                            });";
                            break;
        }
        unset($_SESSION['msg_id']);
    }
    ?>
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