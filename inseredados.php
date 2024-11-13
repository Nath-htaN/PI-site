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
                     $idproduto = $conexao->lastInsertId();
                     $html_content = "
                     <!DOCTYPE html>
                     <html lang='pt-br'>
                     
                     <head>
                         <meta charset='UTF-8'>
                         <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                         <title>$nome</title>
                         <link rel='stylesheet' href='css/produtos.css'>
                     </head>
                     
                     <body>
                         <header>
                             <div class='menu'>
                                 <div class='leftmenu'>
                                     <div class='logo'>
                                         <img src='img/logoplaceholder.png' alt='Logo'>
                                     </div>
                                     <nav>
                                         <ul>
                                             <li><a href=''>Perfumaria</a></li>
                                             <li><a href=''>Banho</a></li>
                                             <li><a href=''>Aromas</a></li>
                                             <li><a href=''>Infantil</a></li>
                                             <li><a href=''>Masculino</a></li>
                                         </ul>
                                     </nav>
                                 </div>
                                 <div class='rightmenu'>
                                     <a href='' class='cart'><img src='img/iconplaceholder2.jpg' alt='Carrinho'></a>
                                     <a href='' class='incon-avatar'><img src='img/iconplaceholder2.jpg' alt='Avatar'></a>
                                 </div>
                             </div>
                             <div class='linha'></div>
                         </header>
                         <main>
                             <section>
                                 <div class='pagina'>
                                     <div class='caixaesquerda'>
                                         <div class='items'>
                                             <div class='imagem-selecionada'>
                                                 <img src='$caminhoImagem' alt='$nome'>
                                             </div>
                                         </div>
                                     </div>
                                     <div class='caixadireita'>
                                         <div class='borda'>
                                             <div class='conteudo'>
                                                 <h1>$nome</h1>
                                                 <p>$descricao</p>
                                                 <span class='preco'>R$ " . number_format($preco, 2, ',', '.') . "</span>
                                                 <div class='opcoes'>
                                                     <div class='quantidade'>
                                                         <div class='menos'>
                                                             <img src='img/menor.png' alt='Diminuir quantidade'>
                                                         </div>
                                                         <span>1</span>
                                                         <div class='mais'>
                                                             <img src='img/maior.png' alt='Aumentar quantidade'>
                                                         </div>
                                                     </div>
                                                     <a href='' class='botão'><img src='img/placeholder.webp' alt='Carrinho'>Adicionar ao carrinho</a>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                                 <div class='pagina2'>
                                     <div class='caixabaixo'>
                                         <div class='borda2'>
                                             <div id='conteudo'>
                                                 <h2>Ingredientes:</h2>
                                                 <p>$ingredientes</p>
                                                 <h2>Como Usar:</h2>
                                                 <p>$usar</p>
                                                 <h2>Ocasião:</h2>
                                                 <p>$ocasiao</p>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </section>
                         </main>
                     </body>
                     
                     </html>
                     ";
                     $file_path = "produto_$idproduto.html";

                     // Salva o conteúdo HTML em um arquivo
                     if (file_put_contents($file_path, $html_content)) {
                        echo "<br>Página do produto criada com sucesso! <a href='$file_path'>Ver Produto</a>";
                     }
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