<?php
session_start();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    require_once 'conn.php';
    
    // Dados básicos
    $nome = $_POST['nome'];
    
    // Respostas de escala (0-5)
    $emocao = $_POST['emocao'];
    $conexao = $_POST['conexao'];
    $realizacao = $_POST['realizacao'];
    $contato = $_POST['contato'];
    $sentimento_geral = $_POST['sentimento_geral'];
    
    // Respostas de texto
    $lembranca_especial = $_POST['lembranca_especial'];
    $mudanca = $_POST['mudanca'];
    $sonho_2015 = $_POST['sonho_2015'] ?? '';
    $amigo_saudade = $_POST['amigo_saudade'] ?? '';
    $conselho_passado = $_POST['conselho_passado'];
    $mensagem_futuro = $_POST['mensagem_futuro'] ?? '';

    try{
        $stmt = $conn->prepare("INSERT INTO quest (user_nome) VALUES (?)");
        $stmt->bind_param("s", $nome);
        $stmt->execute();
        $quest_id = $stmt->insert_id;

        if($stmt->affected_rows === 0){
            throw new Exception("10");
        }

        $stmt->close();
        
        if(isset($quest_id)){
            // Preparar statement para respostas (agora com tipo TEXT)
            $stmt = $conn->prepare("INSERT INTO respostas (quest_id, pergunta, resposta_nota, resposta_texto) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isis", $quest_id, $pergunta, $nota, $texto);

            $respostas_inseridas = 0;
            
            // Respostas de escala (nota 0-5, texto NULL)
            $pergunta = 'emocao';
            $nota = $emocao;
            $texto = null;
            if($stmt->execute()) $respostas_inseridas++;

            $pergunta = 'conexao';
            $nota = $conexao;
            $texto = null;
            if($stmt->execute()) $respostas_inseridas++;

            $pergunta = 'realizacao';
            $nota = $realizacao;
            $texto = null;
            if($stmt->execute()) $respostas_inseridas++;

            $pergunta = 'contato';
            $nota = $contato;
            $texto = null;
            if($stmt->execute()) $respostas_inseridas++;

            $pergunta = 'sentimento_geral';
            $nota = $sentimento_geral;
            $texto = null;
            if($stmt->execute()) $respostas_inseridas++;

            // Respostas de texto (nota NULL, texto preenchido)
            $pergunta = 'lembranca_especial';
            $nota = null;
            $texto = $lembranca_especial;
            if($stmt->execute()) $respostas_inseridas++;

            $pergunta = 'mudanca';
            $nota = null;
            $texto = $mudanca;
            if($stmt->execute()) $respostas_inseridas++;

            $pergunta = 'sonho_2015';
            $nota = null;
            $texto = $sonho_2015;
            if($stmt->execute()) $respostas_inseridas++;

            $pergunta = 'amigo_saudade';
            $nota = null;
            $texto = $amigo_saudade;
            if($stmt->execute()) $respostas_inseridas++;

            $pergunta = 'conselho_passado';
            $nota = null;
            $texto = $conselho_passado;
            if($stmt->execute()) $respostas_inseridas++;

            $pergunta = 'mensagem_futuro';
            $nota = null;
            $texto = $mensagem_futuro;
            if($stmt->execute()) $respostas_inseridas++;

            if($respostas_inseridas < 11){
                throw new Exception("11");
            }else{
                $_SESSION['msg_id'] = 12;
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