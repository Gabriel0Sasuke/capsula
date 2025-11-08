<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();

    $senhapadrao = "capsulafodastica";

    $nome = $_POST['nome'];
    $senha = $_POST['senha'];

    if ($senha === $senhapadrao) {
        $_SESSION['nome_admin'] = $nome;
        header("Location: ../pages/admin.php");
        exit();
    } else {
        echo "<script>alert('Senha incorreta!'); window.location.href = '../pages/admin.php';</script>";
        exit();
    }
}