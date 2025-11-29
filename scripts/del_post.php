<?php
session_start();
require_once 'conn.php';

// Verificar se está logado
if (!isset($_SESSION['nome_admin'])) {
    $_SESSION['msg_id'] = 99;
    header('Location: ../pages/admin.php');
    exit;
}

// Verificar se o ID foi passado
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['msg_id'] = 11;
    header('Location: ../pages/admin.php');
    exit;
}

$postId = intval($_GET['id']);

// Buscar o post para pegar o caminho da imagem
$stmt = $conn->prepare("SELECT imagem FROM post WHERE id = ?");
$stmt->bind_param("i", $postId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['msg_id'] = 11;
    $stmt->close();
    $conn->close();
    header('Location: ../pages/admin.php');
    exit;
}

$post = $result->fetch_assoc();
$imagemPath = $post['imagem'];
$stmt->close();

// Excluir o post do banco de dados
$stmtDelete = $conn->prepare("DELETE FROM post WHERE id = ?");
$stmtDelete->bind_param("i", $postId);

if ($stmtDelete->execute()) {
    // Excluir o arquivo da imagem se existir (só depois de confirmar exclusão no banco)
    if ($imagemPath) {
        $caminhoCompleto = '../' . $imagemPath;
        if (file_exists($caminhoCompleto)) {
            unlink($caminhoCompleto);
        }
    }
    $_SESSION['msg_id'] = 10; // Sucesso na exclusão
} else {
    $_SESSION['msg_id'] = 11; // Erro na exclusão
}

$stmtDelete->close();
$conn->close();

header('Location: ../pages/admin.php');
exit;
?>