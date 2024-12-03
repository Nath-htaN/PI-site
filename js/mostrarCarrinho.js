function PegarCookie() {
    return document.cookie
        .split('; ')
        .find(row => row.startsWith('accountholder='))
        ?.split('=')[1];
}

// Função para validar o token via backend
async function IdToken() {
    const token = PegarCookie();

    if (!token) {
        console.warn('Token não encontrado nos cookies.');
        return false;
    }
    try {
        const response = await fetch('pegaridtoken.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ token }),
        });

        if (!response.ok) {
            console.error('Erro ao receber o ID do Token', response.statusText);
            return false;
        }

        const result = await response.json();
        return result.idusuario;
    } catch (error) {
        console.error('Erro no Token', error);
        return false;
    }
}

const idlista=document.getElementById('cart');


async function mostrarCarrinho(){
    const idusuario= await IdToken();
    const xhr=new XMLHttpRequest();
    xhr.open('GET',`mostrarCarrinho.php?idusuario=${idusuario}`,true);

    xhr.onreadystatechange = function() {
        if (xhr.readyState=== 4 && xhr.status === 200){
            const produtos = JSON.parse(xhr.responseText);
            console.log(produtos);

            idlista.innerHTML =" ";
            if(produtos.length > 0 ){
                produtos.forEach(produto =>{
                    const item = document.createElement('li');
                    item.className='item'
                    item.idproduto = produto.idproduto;

                    const texto = document.createElement('div');
                    texto.className = 'texto';
                    
                    const imagem = document.createElement('img')
                    imagem.src = produto.imagem;
                    imagem.alt = produto.nome;

                    const nome = document.createElement('h4')
                    nome.textContent = produto.nome;

                    const preco = document.createElement('span');
                    preco.className = 'preco';
                    preco.textContent = `R$ ${produto.preco}`;

                    const quant = document.createElement('span');
                    quant.className = 'quantidade';
                    quant.textContent = produto.quantidade;

                    const sub = document.createElement('span');
                    sub.className = 'subtotal';
                    sub.textContent = produto.subtotal;
                    sub.style.display = 'none';

                    const idcarrinho = document.createElement('h5');
                    idcarrinho.textContent = produto.idcarrinho;
                    idcarrinho.style.display = 'none';

                    item.appendChild(imagem);
                    texto.appendChild(nome);
                    texto.appendChild(quant);
                    texto.appendChild(preco);
                    texto.appendChild(idcarrinho);
                    texto.appendChild(sub);
                    item.appendChild(texto);
                    idlista.appendChild(item);
            })
            } else {
                idlista.innerHTML = "Nenhum item no carrinho";
            }
            const subtotais = document.querySelectorAll('.subtotal');
            let total = 0;
            subtotais.forEach(subtotal =>{
                total += parseFloat(subtotal.textContent) || 0;
            });
            document.getElementById('total').textContent = total.toFixed(2);
        }
    }
    xhr.send()
}
document.addEventListener("DOMContentLoaded", mostrarCarrinho);