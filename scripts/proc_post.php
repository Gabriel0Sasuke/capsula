<?php
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
        http_response_code(400);
        echo 'Nenhuma imagem enviada.';
        exit;
    }

    if ($imagem['error'] !== UPLOAD_ERR_OK) {
        http_response_code(400);
        echo 'Erro no upload da imagem.';
        exit;
    }

    if ($imagem['size'] > $maxFileSize) {
        http_response_code(400);
        echo 'Imagem excede 10MB.';
        exit;
    }

    // Valida MIME real do arquivo
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($imagem['tmp_name']);
    if ($mimeType === false || !array_key_exists($mimeType, $allowedMimeTypes)) {
        http_response_code(400);
        echo 'Formato de imagem inválido. Use JPG, PNG, GIF ou WEBP.';
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
            http_response_code(500);
            echo 'Erro ao criar diretório de uploads.';
            exit;
        }
    }

    $destino = $uploadDir . DIRECTORY_SEPARATOR . $novoNome;
    if (!move_uploaded_file($imagem['tmp_name'], $destino)) {
        http_response_code(500);
        echo 'Falha ao mover a imagem enviada.';
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
        http_response_code(500);
        echo 'Erro ao preparar a query.';
        exit;
    }
    $stmt->bind_param('sss', $conteudo, $dataFormatada, $caminhoRelativo);
    if (!$stmt->execute()) {
        http_response_code(500);
        echo 'Erro ao salvar no banco.';
        exit;
    }

    if ($stmt->affected_rows > 0) {
        echo '<script>alert("blog cadastrado com sucesso."); window.location.href = "../pages/admin.php";</script>';
    } else {
        echo '<script>alert("Falha ao cadastrar o post."); window.location.href = "../pages/admin.php";</script>';
    }    
    $stmt->close();

}