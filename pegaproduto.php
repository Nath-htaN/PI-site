<?php
include 'conexao.php';

if (isset($_GET['nome'])) {
    $nome = $_GET['nome'];

    // Consulta SQL com JOIN para obter informações do produto e o nome da categoria
    $stmt = $conexao->prepare("
        SELECT 
            p.idproduto, p.nome, p.preco, p.descricao, p.ingredientes, p.usar, p.ocasiao, p.imagem, c.nome AS categoria_nome, p.idcategoria
        FROM 
            produto p
        JOIN 
            categoria c ON p.idcategoria = c.idcategoria
        WHERE 
            p.nome LIKE :nome
        LIMIT 10
    ");
    $stmt->execute([':nome' => "%$nome%"]);

    // Exibe os resultados
    if ($stmt->rowCount() > 0) {
        while ($produto = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<form action="atualizar_produto.php" method="POST" enctype="multipart/form-data">';
            echo '<input type="hidden" name="idproduto" value="' . htmlspecialchars($produto['idproduto']) . '">';
            echo '<label>Nome:</label><input type="text" name="nome" value="' . htmlspecialchars($produto['nome']) . '"><br>';
            echo '<label>Preço:</label><input type="text" name="preco" value="' . htmlspecialchars($produto['preco']) . '"><br>';
            echo '<label>Descrição:</label><textarea name="descricao">' . htmlspecialchars($produto['descricao']) . '</textarea><br>';
            echo '<label>Ingredientes:</label><textarea name="ingredientes">' . htmlspecialchars($produto['ingredientes']) . '</textarea><br>';
            echo '<label>Como Usar:</label><textarea name="usar">' . htmlspecialchars($produto['usar']) . '</textarea><br>';
            echo '<label>Ocasião:</label><textarea name="ocasiao">' . htmlspecialchars($produto['ocasiao']) . '</textarea><br>';
            echo '<label>Categoria:</label><input type="text" value="' . htmlspecialchars($produto['categoria_nome']) . '" readonly><br>';
            echo '<input type="hidden" name="idcategoria" value="' . htmlspecialchars($produto['idcategoria']) . '">';
            
            if ($produto['imagem']) {
                echo '<label>Imagem Atual:</label><br><img src="' . htmlspecialchars($produto['imagem']) . '" alt="Imagem do Produto" style="width:100px; height:auto;"><br>';
            }
            echo '<label>Nova Imagem:</label><input type="file" name="imagem"><br>';
            
            echo '<button type="submit">Atualizar Produto</button>';
            echo '</form><hr>';
        }
    } else {
        echo "<p>Nenhum produto encontrado.</p>";
    }
} else {
    echo "<p>Parâmetro de busca não especificado.</p>";
}
?>
