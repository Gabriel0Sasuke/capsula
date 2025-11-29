<?php
session_start();
require_once 'conn.php';

header('Content-Type: application/json');

// Verificar se está logado
if (!isset($_SESSION['nome_admin'])) {
    echo json_encode(['success' => false, 'message' => 'Não autorizado']);
    exit;
}

// Verificar se é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método inválido']);
    exit;
}

// Validar dados obrigatórios
if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    echo json_encode(['success' => false, 'message' => 'ID inválido']);
    exit;
}

$postId = intval($_POST['id']);
$tipoPost = $_POST['tipo_post'] ?? 'post_geral';
$conteudo = $_POST['conteudo'] ?? '';
$dataPublicacao = $_POST['data_publicacao'] ?? date('Y-m-d H:i:s');

// Buscar post atual para pegar imagem antiga
$stmtBusca = $conn->prepare("SELECT imagem FROM post WHERE id = ?");
$stmtBusca->bind_param("i", $postId);
$stmtBusca->execute();
$resultBusca = $stmtBusca->get_result();

if ($resultBusca->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Post não encontrado']);
    exit;
}

$postAtual = $resultBusca->fetch_assoc();
$imagemAtual = $postAtual['imagem'];
$novaImagem = $imagemAtual; // Mantém a imagem atual por padrão

// Processar nova imagem se enviada
if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
    $arquivo = $_FILES['imagem'];
    
    // Validar tamanho (máximo 10MB)
    if ($arquivo['size'] > 10 * 1024 * 1024) {
        echo json_encode(['success' => false, 'message' => 'Imagem muito grande (máximo 10MB)']);
        exit;
    }
    
    // Validar tipo
    $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (!in_array($arquivo['type'], $tiposPermitidos)) {
        echo json_encode(['success' => false, 'message' => 'Formato de imagem inválido']);
        exit;
    }
    
    // Criar pasta de uploads se não existir
    $pastaUpload = '../uploads/';
    if (!is_dir($pastaUpload)) {
        if (!mkdir($pastaUpload, 0755, true)) {
            echo json_encode(['success' => false, 'message' => 'Erro ao criar pasta de uploads']);
            exit;
        }
    }
    
    // Gerar nome único para o arquivo
    $extensao = pathinfo($arquivo['name'], PATHINFO_EXTENSION);
    $nomeArquivo = 'post_' . $postId . '_' . time() . '.' . $extensao;
    $caminhoCompleto = $pastaUpload . $nomeArquivo;
    
    // Mover arquivo
    if (move_uploaded_file($arquivo['tmp_name'], $caminhoCompleto)) {
        // Excluir imagem antiga se existir
        if ($imagemAtual && file_exists('../' . $imagemAtual)) {
            unlink('../' . $imagemAtual);
        }
        $novaImagem = 'uploads/' . $nomeArquivo;
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao fazer upload da imagem']);
        exit;
    }
}

// Atualizar no banco de dados
$stmtUpdate = $conn->prepare("UPDATE post SET tipo_post = ?, conteudo = ?, imagem = ?, data_publicacao = ? WHERE id = ?");
$stmtUpdate->bind_param("ssssi", $tipoPost, $conteudo, $novaImagem, $dataPublicacao, $postId);

if ($stmtUpdate->execute()) {
    echo json_encode(['success' => true, 'message' => 'Post atualizado com sucesso']);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao atualizar o post: ' . $conn->error]);
}

$stmtBusca->close();
$stmtUpdate->close();
$conn->close();
?>