<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'conn.php';
    $conteudo = $_POST['blog_content'];
    $data_publicacao = $_POST['blog_data'];
    $imagem = $_FILES['blog_image'];

    // Upload seguro da imagem
    $maxFileSize = 10 * 1024 * 1024; // 10MB
    $allowedMimeTypes = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif',
        'image/webp' => 'webp'
    ];

    if (!isset($imagem) || $imagem['error'] === UPLOAD_ERR_NO_FILE) {
        $_SESSION['msg_id'] = 1; // 1 = nenhuma imagem enviada
        header('Location: ../pages/admin.php');
        exit;
    }

    if ($imagem['error'] !== UPLOAD_ERR_OK) {
        $_SESSION['msg_id'] = 2; // 2 = erro no upload (PHP upload error)
        header('Location: ../pages/admin.php');
        exit;
    }

    if ($imagem['size'] > $maxFileSize) {
        $_SESSION['msg_id'] = 3; // 3 = tamanho maior que 10MB
        header('Location: ../pages/admin.php');
        exit;
    }

    // Valida MIME real do arquivo
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($imagem['tmp_name']);
    if ($mimeType === false || !array_key_exists($mimeType, $allowedMimeTypes)) {
        $_SESSION['msg_id'] = 4; // 4 = formato inválido
        header('Location: ../pages/admin.php');
        exit;
    }

    // Gera nome único
    $uniqueId = bin2hex(random_bytes(8));
    $ext = $allowedMimeTypes[$mimeType];
    $novoNome = 'blogImagem_' . $uniqueId . '.' . $ext;

    // Caminhos
    $root = dirname(__DIR__); // .../capsula
    $uploadDir = $root . DIRECTORY_SEPARATOR . 'uploads';
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0755, true) && !is_dir($uploadDir)) {
            $_SESSION['msg_id'] = 5; // 5 = falha ao criar diretório de uploads
            header('Location: ../pages/admin.php');
            exit;
        }
    }

    $destino = $uploadDir . DIRECTORY_SEPARATOR . $novoNome;
    if (!move_uploaded_file($imagem['tmp_name'], $destino)) {
        $_SESSION['msg_id'] = 6; // 6 = falha ao mover o arquivo para uploads
        header('Location: ../pages/admin.php');
        exit;
    }

    $caminhoRelativo = 'uploads/' . $novoNome; // para servir no site

    // Normaliza data
    $dataFormatada = null;
    if (!empty($data_publicacao)) {
        $ts = strtotime($data_publicacao);
        $dataFormatada = $ts !== false ? date('Y-m-d H:i:s', $ts) : null;
    }

    // Insere no banco (colunas conforme schema atual)
    $sql = 'INSERT INTO post (conteudo, data_publicacao, imagem) VALUES (?, ?, ?)';
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        $_SESSION['msg_id'] = 7; // 7 = erro ao preparar query
        header('Location: ../pages/admin.php');
        exit;
    }

    $stmt->bind_param('sss', $conteudo, $dataFormatada, $caminhoRelativo);
    if (!$stmt->execute()) {
        $_SESSION['msg_id'] = 8; // 8 = erro ao executar insert
        $stmt->close();
        header('Location: ../pages/admin.php');
        exit;
    }

    // sucesso: salva o id inserido na sessão
    $_SESSION['msg_id'] = 0; // 0 = sucesso

    $stmt->close();
    $conn->close();

    header('Location: ../pages/admin.php');
    exit;

}