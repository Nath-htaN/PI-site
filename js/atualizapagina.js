document.addEventListener('DOMContentLoaded', function(){
    window.onload = function(){
        const idproduto = document.querySelector('.idproduto').innerText;
    
        console.log(idproduto)
    
        const xhr = new XMLHttpRequest();
    
        xhr.open('GET', `atualizapagina.php?id=${idproduto}`, true);
        xhr.onreadystatechange = function(){
            if (xhr.readyState === 4 && xhr.status === 200) {
                try {
                    const produto = JSON.parse(xhr.responseText);
                    console.log(produto) // Analisa a resposta JSON
    
                    if (produto.error) {
                        console.error("Erro ao carregar o produto: " + produto.error);
                        return;
                    }
                    document.querySelector('h1').innerText = produto.nome;
                    document.querySelector('.preco').innerText = 'R$: ' +produto.preco
                    document.querySelector('.descrição').innerText = produto.descricao
                    document.querySelector('.Ingredientes').innerText = produto.ingredientes
                    document.querySelector('.Como-Usar').innerText = produto.usar
                    document.querySelector('.Ocasiao').innerText = produto.ocasiao
                    document.querySelector('.imagem-selecionada img').src = produto.imagem   
                } catch (error) {
                    console.error("Erro ao analizar a resposta JSON" , error)
                }
            } else if (xhr.readyState === 4){
                console.error("erro na requisição:", xhr.status)
            }
        };
        xhr.send();
    }
        
})
