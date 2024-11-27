<?php
header('Content-Type: application/json');


// Conexão com o banco de dados
require_once 'conexao.php';

$data = json_decode(file_get_contents('php://input'), true);

// Valida os dados recebidos
if (!isset($data['idproduto'], $data['quantidade'], $data['idusuario'])) {
    echo json_encode(['status' => 'error', 'message' => 'Dados incompletos.']);
    exit;
}

$idproduto = (int)$data['idproduto'];
$quantidade = (int)$data['quantidade'];
$idusuario = (int)$data['idusuario'];

// Insere ou atualiza o produto no carrinho
try {
    $sql = "INSERT INTO carrinho (idproduto, idusuario, quantidade)
    VALUES (:idproduto, :idusuario, :quantidade)
    ON DUPLICATE KEY UPDATE quantidade = quantidade + :quantidade";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':idusuario', $idusuario, PDO::PARAM_INT);
    $stmt->bindParam(':idproduto', $idproduto, PDO::PARAM_INT);
    $stmt->bindParam(':quantidade', $quantidade, PDO::PARAM_INT);    
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        echo json_encode(['status' => 'success', 'message' => 'Produto adicionado ao carrinho.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Nenhuma alteração foi feita.']);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao adicionar ao carrinho: ' .$idusuario.$idproduto.$quantidade]);
}

$conexao=null;
?>