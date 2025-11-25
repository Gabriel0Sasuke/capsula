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
</head>
<body>

    <div id="sidebar" class="sidebar">
        <a href="../index.php"><i class="material-icons-round">home</i>Início</a>
        <a href="sobre.php"><i class="material-icons-round">info</i>Sobre o Projeto</a>
        <a href="quest.php"><i class="material-icons-round">rate_review</i>Questionário</a>
        <a href="admin.php"><i class="material-icons-round">shield</i>Admin</a>
    </div>
    
    <button id="sidebar-toggle">☰</button>

    <header>ADMIN CAPSULA</header>

    <?php if(isset($_SESSION['nome_admin'])) { ?>
    <main>
        <aside>
            <div onclick="trocarJanela(1)" id="inicio"><i class="material-icons-round">dashboard</i>Inicio</div>
            <div onclick="trocarJanela(2)" id="blog"><i class="material-icons-round">article</i>Cadastrar Blog</div>
            <div onclick="trocarJanela(3)" id="quest"><i class="material-icons-round">question_answer</i>Visualizar Quest</div>
            <div onclick="window.location.href = '../scripts/admin_logout.php'"><i class="material-icons-round">logout</i>Log-Out</div>
        </aside>
        <section>
            <div id="div_inicio">
                <h1>Bem-vindo ao Painel de Admin, <?php echo $_SESSION['nome_admin']; ?></h1>
                <div class="cards"></div>
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
                <h2>Bem-vindo ao Painel de Visualizar Quest</h2>
                <p>Selecione uma opção no menu lateral para começar.</p>
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
</body>
</html>