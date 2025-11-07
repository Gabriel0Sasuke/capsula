<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link rel="stylesheet" href="assets/css/index.css">
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
        <a href="#"><i class="material-icons-round">login</i>Login</a>
        <a href="#"><i class="material-icons-round">person_add</i>Cadastro</a>
    </div>
    
    <button id="sidebar-toggle">☰</button>

    <header>CAPSULA DO TEMPO</header>

    <main>
        <section class="blog">
            <h1>Novidades da capsula!</h1>

            <article class="noticias">
                <img src="assets/img/ui/placeholder.png" alt="" class="news-img">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Impedit alias earum blanditiis reprehenderit excepturi error corrupti iure voluptate magni accusantium quis obcaecati voluptatibus praesentium in ab velit, dicta ex. Quaerat.
                Dignissimos suscipit, et officiis commodi asperiores fugiat id sapiente, dolorem quos pariatur fugit sed, porro alias. Quo dignissimos obcaecati culpa fuga laudantium voluptates, impedit repudiandae possimus nostrum sapiente reiciendis eius?</p>

                <div class="news-data" id="news-data">20/12/2007</div>
            </article>

            <article class="noticias">
                <img src="assets/img/ui/placeholder.png" alt="" class="news-img">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Impedit alias earum blanditiis reprehenderit excepturi error corrupti iure voluptate magni accusantium quis obcaecati voluptatibus praesentium in ab velit, dicta ex. Quaerat.
                Dignissimos suscipit, et officiis commodi asperiores fugiat id sapiente, dolorem quos pariatur fugit sed, porro alias. Quo dignissimos obcaecati culpa fuga laudantium voluptates, impedit repudiandae possimus nostrum sapiente reiciendis eius?</p>

                <div class="news-data" id="news-data">20/12/2007</div>
            </article>
        </section>

        <div class="container-direita">
            <section class="relogio">
                <h1>FALTAM <strong>99</strong> DIAS PARA O EVENTO</h1>
                <div id="clock">00:00:00</div>
            </section>

            <button id="btn-quest">Questionário</button>
        </div>
        
    </main>
    
    <footer>capsula 2015 - 2025</footer>

    <script src="assets/js/sidebar.js"></script>
</body>
</html>