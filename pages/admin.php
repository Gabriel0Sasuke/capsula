<?php
session_start();

require_once '../scripts/conn.php';

// Detecção de dispositivo móvel
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$celular = false;
if (!preg_match('/Mobi|Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i', $user_agent)) {
    $celular = false;
} else {
    $celular = true;
}

// Dados pras tabelas de estatísticas
$visitas = $conn->query("SELECT COUNT(*) FROM visitas");
$formularios = $conn->query("SELECT COUNT(*) FROM quest");
$nav_data = $conn->query("SELECT user_navegador, COUNT(*) as total FROM visitas GROUP BY user_navegador");
$device_data = $conn->query("SELECT user_sistema_operacional, COUNT(*) as total FROM visitas GROUP BY user_sistema_operacional");

// Dados pra tabela de editar os posts
$resultpost = $conn->query("SELECT * FROM post ORDER BY data_publicacao DESC");
?>



<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Capsula - Admin</title>

    <?php
    if ($celular == false) {
    ?>
        <link rel="stylesheet" href="../assets/css/desktop/admin.css">
    <?php  } else { ?>
        <link rel="stylesheet" href="../assets/css/mobile/admin-mobile.css">
    <?php } ?>

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+Round">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Quintessential&display=swap">
    <link rel="icon" type="image/svg+xml" href="../assets/img/ui/ampulheta.svg">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

    <header>ADMIN CAPSULA</header>

    <?php if (isset($_SESSION['nome_admin'])) { ?>
        <main>
            <aside>
                <div onclick="trocarJanela(1)" id="inicio"><i class="material-icons-round">dashboard</i>Inicio</div>
                <div onclick="trocarJanela(2)" id="blog"><i class="material-icons-round">article</i>Cadastrar Blog</div>
                <div onclick="trocarJanela(3)" id="quest"><i class="material-icons-round">question_answer</i>Visualizar Quest</div>
                <div onclick="trocarJanela(4)" id="galeria"><i class="material-icons-round">photo_library</i>Posts Cadastrados</div>
                <div onclick="showDeslogar()"><i class="material-icons-round">logout</i>Log-Out</div>
            </aside>
            <section>
                <div id="div_inicio">
                    <h1>Bem-vindo ao Painel de Admin, <?php echo $_SESSION['nome_admin']; ?></h1>
                    <div class="card-row">
                        <div class="cards">Acessos Totais <img src="../assets/img/ui/bar_chart.svg" id="grafico-barra"> <strong><?php echo $visitas->fetch_row()[0]; ?></strong></div>
                        <div class="cards">Formulários Enviados <img src="../assets/img/ui/edit_document.svg" id="grafico-barra"> <strong><?php echo $formularios->fetch_row()[0]; ?></strong></div>
                    </div>
                    <div class="card-row">
                        <div class="cards-grande">Navegador mais Utilizado<br>
                            <div class="grafico"><canvas id="myChartNav"></canvas></div>
                        </div>
                        <div class="cards-grande">Dispositivo mais Utilizado<br>
                            <div class="grafico"><canvas id="myChartDevice"></canvas></div>
                        </div>
                    </div>
                </div>

                <div id="div_blog">
                    <form action="../scripts/proc_post.php" method="POST" enctype="multipart/form-data">
                        <div class="campo">
                            <label for="blog_content">Texto</label>
                            <textarea id="blog_content" name="blog_content" rows="5" required maxlength="1000"></textarea>
                        </div>


                        <div class="campo">
                            <label for="blog_image" id="upload" class="blob-btn">
                                <i class="material-icons-round">upload</i>
                                <span class="upload-text">Fazer Upload de Imagem</span>

                                <span class="blob-btn__inner" aria-hidden="true">
                                    <span class="blob-btn__blobs">
                                        <span class="blob-btn__blob"></span>
                                        <span class="blob-btn__blob"></span>
                                        <span class="blob-btn__blob"></span>
                                        <span class="blob-btn__blob"></span>
                                    </span>
                                </span>
                            </label>

                            <input type="file" id="blog_image" name="blog_image" accept="image/*" hidden>
                            <div id="preview"></div>
                        </div>

                        <!-- filtro gooey -->
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" style="position:absolute;width:0;height:0;overflow:hidden">
                            <defs>
                                <filter id="goo">
                                    <feGaussianBlur in="SourceGraphic" result="blur" stdDeviation="10"></feGaussianBlur>
                                    <feColorMatrix in="blur" mode="matrix"
                                        values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 21 -7"
                                        result="goo"></feColorMatrix>
                                    <feBlend in2="goo" in="SourceGraphic" result="mix"></feBlend>
                                </filter>
                            </defs>
                        </svg>
                        <div class="campo">
                            <label for="blog_data">Data</label>
                            <input type="datetime-local" id="blog_data" name="blog_data" required value="<?php echo (new DateTime('now', new DateTimeZone('America/Sao_Paulo')))->format('Y-m-d\TH:i'); ?>">
                        </div>
                        <button type="submit">Cadastrar</button>
                    </form>
                </div>
                <div id="div_quest">
                    <h2>Visualizar Questionários</h2>
                    <p>Selecione uma opção no menu lateral para começar.</p>
                </div>
                <div id="div_galeria">
                    <h2>Posts Cadastrados</h2>
                    <div class="posts-container">
                        <?php
                        if ($resultpost->num_rows > 0) {
                            while ($post = $resultpost->fetch_assoc()) {
                                $postId = $post['id'];
                                $postImagem = $post['imagem'] ?? '';
                                $postConteudo = $post['conteudo'] ?? '';
                                $postData = $post['data_publicacao'] ?? '';
                                
                                echo '<div class="post-card">';
                                echo '<img src="../' . htmlspecialchars($postImagem) . '" alt="Imagem do post">';
                                echo '<div class="post-info">';
                                echo '<p class="post-text">' . htmlspecialchars($postConteudo) . '</p>';
                                echo '<span class="post-date">' . ($postData ? date('d/m/Y H:i', strtotime($postData)) : '') . '</span>';
                                echo '<div class="post-actions">';
                                echo '<button class="btn-editar" onclick="editarPost(' . $postId . ')"><i class="material-icons-round">edit</i>Editar</button>';
                                echo '<button class="btn-excluir" onclick="excluirPost(' . $postId . ')"><i class="material-icons-round">delete</i>Excluir</button>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                            }
                        } else {
                            echo '<p>Nenhum post cadastrado ainda.</p>';
                        }
                        ?>
                    </div>
                </div>
            </section>
        <?php } else { ?>
            <main class="form-main">
                <div class="login-container">
                    <form action="../scripts/admin_login.php" method="POST" id="login" class="formulario">
                        <div class="campo">
                            <label for="admin_username">Insira seu Nome</label>
                            <input type="text" id="admin_username" name="nome" required>
                        </div>

                        <div class="campo">
                            <label for="admin_password" id="">Senha</label>
                            <input type="password" id="admin_password" name="senha" required>
                        </div>
                        <button type="submit" class="submit-btn">Entrar</button>
                    </form>
                </div>
            </main>
        <?php } ?>
        </main>

        <footer>capsula 2015 - 2025</footer>

        <script src="../assets/js/sidebar.js"></script>
        <script src="../assets/js/admin.js"></script>
        
        <script> // Codigo pras notificações
        function showDeslogar() {
            Swal.fire({
                title: 'Deseja Deslogar?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Sim',
                cancelButtonText: 'Não',
                confirmButtonColor: '#4CAF50', // Verde
                cancelButtonColor: '#F44336', // Vermelho
                background: '#fef7e8',
                color: '#333333'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../scripts/admin_logout.php';
                }
            });
        }
        <?php
        if (isset($_SESSION['msg_id'])) {
            $msg = $_SESSION['msg_id'];
            switch ($msg) {
                case 0:
                    echo "Swal.fire({
                            toast: true,
                            position: 'bottom-end', // canto inferior direito
                            icon: 'success',
                            title: 'Sucesso!',
                            text: 'Post cadastrado com sucesso.',
                            showConfirmButton: false,
                            timer: 4000,              // 4 segundos
                            timerProgressBar: true    // barrinha embaixo
                            });";
                    break;
                case 1:
                    echo "Swal.fire({
                            toast: true,
                            position: 'bottom-end', // canto inferior direito
                            icon: 'error',
                            title: 'Erro!',
                            text: 'Nenhuma imagem enviada.',
                            showConfirmButton: false,
                            timer: 4000,              // 4 segundos
                            timerProgressBar: true    // barrinha embaixo
                            });";
                    break;
                case 2:
                    echo "Swal.fire({
                            toast: true,
                            position: 'bottom-end', // canto inferior direito
                            icon: 'error',
                            title: 'Erro!',
                            text: 'Erro no upload da imagem.',
                            showConfirmButton: false,
                            timer: 4000,              // 4 segundos
                            timerProgressBar: true    // barrinha embaixo
                            });";
                    break;
                case 3:
                    echo "Swal.fire({
                            toast: true,
                            position: 'bottom-end', // canto inferior direito
                            icon: 'error',
                            title: 'Erro!',
                            text: 'Tamanho da imagem maior que 10MB.',
                            showConfirmButton: false,
                            timer: 4000,              // 4 segundos
                            timerProgressBar: true    // barrinha embaixo
                            });";
                    break;
                case 4:
                    echo "Swal.fire({
                            toast: true,
                            position: 'bottom-end', // canto inferior direito
                            icon: 'error',
                            title: 'Erro!',
                            text: 'Formato de imagem inválido.',
                            showConfirmButton: false,
                            timer: 4000,              // 4 segundos
                            timerProgressBar: true    // barrinha embaixo
                            });";
                    break;
                case 5:
                    echo "Swal.fire({
                            toast: true,
                            position: 'bottom-end', // canto inferior direito
                            icon: 'error',
                            title: 'Erro!',
                            text: 'Falha ao criar a pasta de uploads.',
                            showConfirmButton: false,
                            timer: 4000,              // 4 segundos
                            timerProgressBar: true    // barrinha embaixo
                            });";
                    break;
                case 6:
                    echo "Swal.fire({
                            toast: true,
                            position: 'bottom-end', // canto inferior direito
                            icon: 'error',
                            title: 'Erro!',
                            text: 'Falha ao mover o arquivo para a pasta de uploads.',
                            showConfirmButton: false,
                            timer: 4000,              // 4 segundos
                            timerProgressBar: true    // barrinha embaixo
                            });";
                    break;
                default:
                    echo "Swal.fire({
                            toast: true,
                            position: 'bottom-end', // canto inferior direito
                            icon: 'error',
                            title: 'Erro Desconhecido!',
                            text: 'Um erro desconhecido ocorreu.',
                            showConfirmButton: false,
                            timer: 4000,              // 4 segundos
                            timerProgressBar: true    // barrinha embaixo
                            });";
            }
            unset($_SESSION['msg_id']);
        }
        ?>
        </script>

        <script> // Codigo pro Chart
          const ctxNav = document.getElementById('myChartNav');
          const ctxDevice = document.getElementById('myChartDevice');

          // Dados vindos do PHP
          <?php
            $navLabels = [];
            $navData = [];
            while($row = $nav_data->fetch_assoc()) {
                $navLabels[] = $row['user_navegador'];
                $navData[] = $row['total'];
            }

            $deviceLabels = [];
            $deviceData = [];
            while($row = $device_data->fetch_assoc()) {
                $deviceLabels[] = $row['user_sistema_operacional'];
                $deviceData[] = $row['total'];
            }
          ?>

          new Chart(ctxNav, {
            type: 'pie', // Tipo do gráfico: 'pie' (pizza)
            
            data: {
                labels: <?php echo json_encode($navLabels); ?>,
                
                datasets: [{
                    label: 'Acessos', // Texto que aparece ao passar o mouse
                    
                    data: <?php echo json_encode($navData); ?>, 
                    
                    // AQUI: Mude as cores das fatias
                    backgroundColor: [
                        '#FFC107', // Amarelo (Chrome)
                        '#36A2EB', // Azul (Safari)
                        '#FF6384', // Vermelho/Rosa (Firefox)
                        '#4BC0C0',  // Verde água (Edge)
                        '#9966FF',
                        '#FF9F40'
                    ],
                    borderColor: '#ffffff', // Cor da borda entre as fatias
                    borderWidth: 2
                }]
            },
            
            options: {
                responsive: true,
                maintainAspectRatio: false, // Importante para ele obedecer a altura da div pai
                plugins: {
                    legend: {
                        position: 'right', // Joga a legenda para a direita igual na sua foto
                        labels: {
                            boxWidth: 15, // Tamanho do quadradinho da cor
                            color: '#ffffff',
                            padding: 15,
                            font: {
                                size: 14,
                                family: 'Arial'
                            }
                        }
                    }
                }
            }
        });
        new Chart(ctxDevice, {
            type: 'pie', // Tipo do gráfico: 'pie' (pizza)
            
            data: {
                labels: <?php echo json_encode($deviceLabels); ?>,
                
                datasets: [{
                    label: 'Acessos', // Texto que aparece ao passar o mouse
                    
                    data: <?php echo json_encode($deviceData); ?>, 
                    
                    // AQUI: Mude as cores das fatias
                    backgroundColor: [
                        '#36A2EB', // Azul
                        '#FF6384', // Vermelho/Rosa
                        '#FFCE56', // Amarelo
                        '#4BC0C0', // Verde
                        '#9966FF'  // Roxo
                    ],
                    borderColor: '#ffffff', // Cor da borda entre as fatias
                    borderWidth: 2
                }]
            },
            
            options: {
                responsive: true,
                maintainAspectRatio: false, // Importante para ele obedecer a altura da div pai
                plugins: {
                    legend: {
                        position: 'right', // Joga a legenda para a direita igual na sua foto
                        labels: {
                            boxWidth: 15, // Tamanho do quadradinho da cor
                            color: '#ffffff',
                            padding: 15,
                            font: {
                                size: 14,
                                family: 'Arial'
                            }
                        }
                    }
                }
            }
        });
        </script>
</body>

</html>