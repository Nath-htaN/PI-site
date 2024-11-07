<?php
include('conexao.php');
if ($_SERVER["REQUEST_METHOD"]=="POST"){
    $nome = htmlspecialchars($_POST['nome']);
    $descricao = htmlspecialchars($_POST['descricao']);
    $ingredientes = htmlspecialchars($_POST['ingredientes']);
    $usar= htmlspecialchars($_POST['usar']);
    $ocasiao = htmlspecialchars($_POST['ocasiao']);
    $preco = (float) $_POST['preco'];
    $categoria = (int) $_POST['categoria'];
    echo $categoria;
    if(isset($_FILES['imagem']) && $_FILES['imagem']['error'] ==0 ){
        $nomeImagem = basename($_FILES['imagem']['name']);
        $caminhoImagem = "img/".$nomeImagem;
        if(move_uploaded_file($_FILES['imagem']['tmp_name'],$caminhoImagem)){
            try{
                $sql = "INSERT INTO produto (nome, preco, descricao, ingredientes, usar, ocasiao, imagem, idcategoria) VALUES (:nome, :preco, :descricao, :ingredientes, :usar, :ocasiao, :imagem, :idcategoria)";
                $stmt = $conexao->prepare($sql);
                $stmt->bindParam(':nome',$nome);
                $stmt->bindParam(':preco',$preco);
                $stmt->bindParam(':descricao',$descricao);
                $stmt->bindParam(':ingredientes',$ingredientes);
                $stmt->bindParam(':usar',$usar);
                $stmt->bindParam(':ocasiao',$ocasiao);
                $stmt->bindParam(':imagem',$caminhoImagem);
                $stmt->bindParam(':idcategoria',$categoria);

                if ($stmt->execute()){
                    echo "Produto inserido com sucesso!";
                } else {
                    echo "erro ao inserir produto.";
                }
            } catch (PDOException $e){
                echo "Erro: ". $e->getMessage();
            }
        } else {
            echo "Erro ao fazer upload da imagem.";
        }
    }else {
        echo "Erro: imagem não foi enviada corretamente";
    }
}
?>