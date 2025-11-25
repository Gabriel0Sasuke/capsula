<?php
session_start();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    require_once 'conn.php';
    $nome = $_POST['nome'];

    $nota_satisfacao = $_POST['satisf_geral'];
    $nota_organizacao = $_POST['organizacao'];
    $nota_apresentacoes = $_POST['apresentacoes'];
    $nota_local = $_POST['local'];
    $nota_divulgacao = $_POST['divulgacao'];

    try{
        $stmt = $conn->prepare("INSERT INTO quest (user_nome) VALUES (?)");
        $stmt->bind_param("s", $nome);
        $stmt->execute();
        $quest_id = $stmt->insert_id; // Pega o ID do questionário inserido

        if($stmt->affected_rows === 0){
            throw new Exception("10"); // Código de erro 10 = falha ao inserir questionário 
        }

        $stmt->close();
        if(isset($quest_id)){
            $stmt = $conn->prepare("INSERT INTO respostas (quest_id, pergunta, resposta) VALUES (?, ?, ?)");
            $stmt->bind_param("isi", $quest_id, $pergunta, $resposta);

            // Inserir cada resposta
            $respostas_inseridas = 0;
            
            $pergunta = 'satisf_geral';
            $resposta = $nota_satisfacao;
            if($stmt->execute()) $respostas_inseridas++;

            $pergunta = 'organizacao';
            $resposta = $nota_organizacao;
            if($stmt->execute()) $respostas_inseridas++;

            $pergunta = 'apresentacoes';
            $resposta = $nota_apresentacoes;
            if($stmt->execute()) $respostas_inseridas++;

            $pergunta = 'local';
            $resposta = $nota_local;
            if($stmt->execute()) $respostas_inseridas++;

            $pergunta = 'divulgacao';
            $resposta = $nota_divulgacao;
            if($stmt->execute()) $respostas_inseridas++;

            if($respostas_inseridas < 5){
                throw new Exception("11"); // Código de erro 11 = falha ao inserir respostas
            }else{
                $_SESSION['msg_id'] = 12; // 12 = sucesso ao enviar questionário e respostas
            }
            $stmt->close();
        }
    }catch(Exception $e){
        $_SESSION['msg_id'] = intval($e->getMessage());
    }finally{
        $conn->close();
        header("Location: ../index.php");
        exit();
    }
}
?>