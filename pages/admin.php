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

// Dados dos questionários
$resultquest = $conn->query("SELECT q.quest_id, q.user_nome, q.quest_data, 
    GROUP_CONCAT(CONCAT(r.pergunta, ':::', COALESCE(r.resposta_nota, ''), ':::', COALESCE(r.resposta_texto, '')) SEPARATOR '|||') as respostas
    FROM quest q 
    LEFT JOIN respostas r ON q.quest_id = r.quest_id 
    GROUP BY q.quest_id 
    ORDER BY q.quest_data DESC");
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
                            <label for="tipo_post">Tipo de Post</label>
                            <select id="tipo_post" name="tipo_post" required>
                                <option value="post_geral">Post Geral</option>
                                <option value="galeria">Galeria</option>
                            </select>
                        </div>

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
                    <h2>📋 Respostas do Questionário</h2>
                    <div class="quest-container">
                        <?php
                        // Mapeamento de nomes amigáveis para as perguntas
                        $perguntasNomes = [
                            'emocao' => '😢 Emoção ao abrir a cápsula',
                            'conexao' => '🔗 Conexão com quem você era',
                            'realizacao' => '🎯 Realização dos planos',
                            'contato' => '👥 Contato com colegas',
                            'sentimento_geral' => '💫 Sentimento geral',
                            'lembranca_especial' => '💝 Lembrança mais especial',
                            'mudanca' => '🪞 O que mais mudou em você',
                            'sonho_2015' => '✨ Sonho de 2015',
                            'amigo_saudade' => '👋 Colega que sentiu mais saudade',
                            'conselho_passado' => '💬 Conselho para você de 2015',
                            'mensagem_futuro' => '📬 Mensagem para 2035'
                        ];

                        if ($resultquest && $resultquest->num_rows > 0) {
                            while ($quest = $resultquest->fetch_assoc()) {
                                $questId = $quest['quest_id'];
                                $nome = htmlspecialchars($quest['user_nome']);
                                $data = date('d/m/Y H:i', strtotime($quest['quest_data']));
                                $respostasRaw = $quest['respostas'];
                                
                                echo '<div class="quest-card">';
                                echo '<div class="quest-header" onclick="toggleQuest(' . $questId . ')">';
                                echo '<div class="quest-info">';
                                echo '<span class="quest-nome"><i class="material-icons-round">person</i>' . $nome . '</span>';
                                echo '<span class="quest-data"><i class="material-icons-round">schedule</i>' . $data . '</span>';
                                echo '</div>';
                                echo '<i class="material-icons-round expand-icon" id="icon-' . $questId . '">expand_more</i>';
                                echo '</div>';
                                
                                echo '<div class="quest-body" id="quest-body-' . $questId . '">';
                                
                                if ($respostasRaw) {
                                    $respostasArray = explode('|||', $respostasRaw);
                                    
                                    // Separar respostas de nota e texto
                                    $notasHtml = '';
                                    $textosHtml = '';
                                    
                                    foreach ($respostasArray as $resposta) {
                                        $partes = explode(':::', $resposta);
                                        if (count($partes) >= 3) {
                                            $pergunta = $partes[0];
                                            $nota = $partes[1];
                                            $texto = $partes[2];
                                            
                                            $nomeAmigavel = $perguntasNomes[$pergunta] ?? $pergunta;
                                            
                                            if ($nota !== '') {
                                                // Resposta de nota (0-5)
                                                $notasHtml .= '<div class="resposta-item resposta-nota">';
                                                $notasHtml .= '<span class="pergunta-label">' . $nomeAmigavel . '</span>';
                                                $notasHtml .= '<div class="nota-display">';
                                                for ($i = 0; $i <= 5; $i++) {
                                                    $activeClass = ($i == $nota) ? 'nota-ativa' : '';
                                                    $notasHtml .= '<span class="nota-bolinha ' . $activeClass . '">' . $i . '</span>';
                                                }
                                                $notasHtml .= '</div>';
                                                $notasHtml .= '</div>';
                                            } elseif ($texto !== '') {
                                                // Resposta de texto
                                                $textosHtml .= '<div class="resposta-item resposta-texto">';
                                                $textosHtml .= '<span class="pergunta-label">' . $nomeAmigavel . '</span>';
                                                $textosHtml .= '<p class="texto-resposta">' . htmlspecialchars($texto) . '</p>';
                                                $textosHtml .= '</div>';
                                            }
                                        }
                                    }
                                    
                                    // Exibir notas primeiro
                                    if ($notasHtml) {
                                        echo '<div class="respostas-secao">';
                                        echo '<h4><i class="material-icons-round">star</i> Avaliações</h4>';
                                        echo $notasHtml;
                                        echo '</div>';
                                    }
                                    
                                    // Depois textos
                                    if ($textosHtml) {
                                        echo '<div class="respostas-secao">';
                                        echo '<h4><i class="material-icons-round">chat</i> Respostas Escritas</h4>';
                                        echo $textosHtml;
                                        echo '</div>';
                                    }
                                } else {
                                    echo '<p class="sem-respostas">Nenhuma resposta registrada.</p>';
                                }
                                
                                echo '</div>'; // quest-body
                                echo '</div>'; // quest-card
                            }
                        } else {
                            echo '<div class="sem-questionarios">';
                            echo '<i class="material-icons-round">inbox</i>';
                            echo '<p>Nenhum questionário enviado ainda.</p>';
                            echo '</div>';
                        }
                        ?>
                    </div>
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
        
        <script>
        // Função para expandir/colapsar questionários
        function toggleQuest(id) {
            const body = document.getElementById('quest-body-' + id);
            const icon = document.getElementById('icon-' + id);
            
            if (body.classList.contains('quest-expanded')) {
                body.classList.remove('quest-expanded');
                icon.textContent = 'expand_more';
            } else {
                body.classList.add('quest-expanded');
                icon.textContent = 'expand_less';
            }
        }
        </script>
        
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
                                case 10:
                echo "Swal.fire({
                        toast: true,
                        position: 'bottom-end',
                        icon: 'success',
                        title: 'Sucesso!',
                        text: 'Post excluído com sucesso.',
                        showConfirmButton: false,
                        timer: 4000,
                        timerProgressBar: true,
                        background: '#fef7e8',
                        color: '#333333'
                        });";
                break;
            case 11:
                echo "Swal.fire({
                        toast: true,
                        position: 'bottom-end',
                        icon: 'error',
                        title: 'Erro!',
                        text: 'Erro ao excluir o post.',
                        showConfirmButton: false,
                        timer: 4000,
                        timerProgressBar: true,
                        background: '#fef7e8',
                        color: '#333333'
                        });";
                break;
            case 99:
                echo "Swal.fire({
                        toast: true,
                        position: 'bottom-end',
                        icon: 'error',
                        title: 'Erro!',
                        text: 'Acesso não autorizado.',
                        showConfirmButton: false,
                        timer: 4000,
                        timerProgressBar: true,
                        background: '#fef7e8',
                        color: '#333333'
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
        <script>
            
function excluirPost(postId) {
    Swal.fire({
        title: 'Excluir Post?',
        text: 'Esta ação não pode ser desfeita!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sim, excluir',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#F44336',
        cancelButtonColor: '#9E9E9E',
        background: '#fef7e8',
        color: '#333333'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '../scripts/del_post.php?id=' + postId;
        }
    });
    
}

// Função para editar post
function editarPost(postId) {
    // Buscar dados do post via AJAX
    fetch('../scripts/buscar_post.php?id=' + postId)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                mostrarFormularioEdicao(data.post);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: 'Não foi possível carregar os dados do post.',
                    background: '#fef7e8',
                    color: '#333333'
                });
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: 'Erro ao conectar com o servidor.',
                background: '#fef7e8',
                color: '#333333'
            });
        });
}

// Função para mostrar formulário de edição
function mostrarFormularioEdicao(post) {
    const imgSrc = post.imagem ? '../' + post.imagem : '';
    
    Swal.fire({
        title: 'Editar Post',
        html: `
            <form id="form-editar" class="swal-form-editar">
                <input type="hidden" id="edit_post_id" value="${post.id}">
                
                <div class="swal-campo">
                    <label for="edit_tipo_post">Tipo de Post</label>
                    <select id="edit_tipo_post" class="swal2-select">
                        <option value="post_geral" ${post.tipo_post === 'post_geral' ? 'selected' : ''}>Post Geral</option>
                        <option value="galeria" ${post.tipo_post === 'galeria' ? 'selected' : ''}>Galeria</option>
                    </select>
                </div>
                
                <div class="swal-campo">
                    <label for="edit_conteudo">Texto</label>
                    <textarea id="edit_conteudo" class="swal2-textarea" rows="4">${post.conteudo || ''}</textarea>
                </div>
                
                <div class="swal-campo">
                    <label>Imagem Atual</label>
                    <div class="swal-preview">
                        ${imgSrc ? `<img src="${imgSrc}" alt="Imagem atual" style="max-width: 200px; max-height: 150px; border-radius: 8px;">` : '<p>Sem imagem</p>'}
                    </div>
                </div>
                
                <div class="swal-campo">
                    <label for="edit_imagem">Nova Imagem (opcional)</label>
                    <input type="file" id="edit_imagem" class="swal2-file" accept="image/*">
                </div>
                
                <div class="swal-campo">
                    <label for="edit_data">Data</label>
                    <input type="datetime-local" id="edit_data" class="swal2-input" value="${formatarDataParaInput(post.data_publicacao)}">
                </div>
            </form>
        `,
        showCancelButton: true,
        confirmButtonText: 'Salvar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#4CAF50',
        cancelButtonColor: '#9E9E9E',
        background: '#fef7e8',
        color: '#333333',
        width: '90%',
        maxWidth: '500px',
        customClass: {
            popup: 'swal-popup-editar'
        },
        preConfirm: () => {
            const formData = new FormData();
            formData.append('id', document.getElementById('edit_post_id').value);
            formData.append('tipo_post', document.getElementById('edit_tipo_post').value);
            formData.append('conteudo', document.getElementById('edit_conteudo').value);
            formData.append('data_publicacao', document.getElementById('edit_data').value);
            
            const novaImagem = document.getElementById('edit_imagem').files[0];
            if (novaImagem) {
                formData.append('imagem', novaImagem);
            }
            
            return formData;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            enviarEdicao(result.value);
        }
    });
}

// Função para formatar data para input datetime-local
function formatarDataParaInput(dataStr) {
    if (!dataStr) return '';
    const data = new Date(dataStr);
    const ano = data.getFullYear();
    const mes = String(data.getMonth() + 1).padStart(2, '0');
    const dia = String(data.getDate()).padStart(2, '0');
    const hora = String(data.getHours()).padStart(2, '0');
    const minuto = String(data.getMinutes()).padStart(2, '0');
    return `${ano}-${mes}-${dia}T${hora}:${minuto}`;
}

// Função para enviar edição via AJAX
function enviarEdicao(formData) {
    fetch('../scripts/edit_post.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Sucesso!',
                text: 'Post atualizado com sucesso.',
                background: '#fef7e8',
                color: '#333333'
            }).then(() => {
                location.reload();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: data.message || 'Erro ao atualizar o post.',
                background: '#fef7e8',
                color: '#333333'
            });
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        Swal.fire({
            icon: 'error',
            title: 'Erro',
            text: 'Erro ao conectar com o servidor.',
            background: '#fef7e8',
            color: '#333333'
        });
    });
}
        </script>
</body>

</html>