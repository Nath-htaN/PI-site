<?php
include('conexao.php');
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $nome=htmlspecialchars($_POST['nome']);
    $sobrenome=htmlspecialchars($_POST['sobrenome']);
    $email=htmlspecialchars($_POST['email']);
    $cpf=(int)$_POST['cpf'];
    $datas=htmlspecialchars($_POST['datas']);
    $celular=(int)$_POST['celular'];
    $senha=htmlspecialchars($_POST['senha']);
    $genero=htmlspecialchars($_POST['genero']);
        try{
            $sql="INSERT INTO usuario(nome, sobrenome, email, cpf, datas, celular, senha, genero) VALUES (:nome, :sobrenome, :email, :cpf, :datas, :celular, :senha, :genero)";
            $stmt=$conexao->prepare($sql);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':sobrenome', $sobrenome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':cpf', $cpf);
            $stmt->bindParam(':datas', $datas);
            $stmt->bindParam(':celular', $celular);
            $stmt->bindParam(':senha', $senha);
            $stmt->bindParam(':genero', $genero);

            if($stmt->execute()){
                echo "Usuário cadastrado!";
            }else{
                echo "Erro ao cadastrar usuário.";
            }
        }catch(PDOException $e){
            echo "Erro ". $e->getMessage();
        }
}
?>