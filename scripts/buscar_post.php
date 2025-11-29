<?php
session_start();
require_once 'conn.php';

header('Content-Type: application/json');

// Verificar se está logado
if (!isset($_SESSION['nome_admin'])) {
    echo json_encode(['success' => false, 'message' => 'Não autorizado']);
    exit;
}

// Verificar se o ID foi passado
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'ID inválido']);
    exit;
}

$postId = intval($_GET['id']);

// Buscar o post
$stmt = $conn->prepare("SELECT * FROM post WHERE id = ?");
$stmt->bind_param("i", $postId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Post não encontrado']);
    exit;
}

$post = $result->fetch_assoc();

echo json_encode([
    'success' => true,
    'post' => $post
]);

$stmt->close();
$conn->close();
?>