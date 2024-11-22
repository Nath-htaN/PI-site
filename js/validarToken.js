// Função para obter o token do cookie
function getTokenFromCookies() {
    return document.cookie
        .split('; ')
        .find(row => row.startsWith('accountholder='))
        ?.split('=')[1];
}
function deslogar(nome){
    document.cookie = nome + "=; expires = Thu 01 jan 1970 00:00 UTC; path=/aa/pi;"
    location.reload();
  }

// Função para validar o token via backend
async function validateToken(token) {
    try {
        const response = await fetch('validarToken.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ token }),
        });

        if (!response.ok) {
            console.error('Erro na validação do token:', response.statusText);
            return false;
        }

        const result = await response.json();
        return result.valid === true;
    } catch (error) {
        console.error('Erro ao validar o token:', error);
        return false;
    }
}

// Função principal para verificar se o usuário está logado
async function isUserLoggedIn() {
    const token = getTokenFromCookies();

    if (!token) {
        console.warn('Token não encontrado nos cookies.');
        return false;
    }

    // Cache simples para evitar validação repetida
    if (isUserLoggedIn.cache && isUserLoggedIn.cache.token === token) {
        return isUserLoggedIn.cache.isValid;
    }

    const isValid = await validateToken(token);

    // Salvar o resultado no cache
    isUserLoggedIn.cache = { token, isValid };
    return isValid;
}
(async function updateMenu(){
    const isLogged= await isUserLoggedIn();
    const menu = document.querySelector('.submenu')
    menu.innerHTML="";
    if(isLogged){
        menu.innerHTML ="";
        console.log('Token encontrado no cookie!');
        const link = document.createElement('a');
        link.textContent = 'alterar produto'
        link.href = 'alteracao.html';
        const log = document.createElement('a');
        log.onclick = function(){
            deslogar('acountholder');
        }
        log.textContent = 'logout'
        menu.appendChild(link)
        menu.appendChild(log)
    }else{
        menu.innerHTML ="";
        console.log('Token não encontrado no cookie!');
        const link = document.createElement('a');
        link.textContent = 'login'
        link.href = 'login.html';
        menu.appendChild(link);
    }
    
})();

function abreomenu(){
    const submenu = document.getElementById("loginsubmenu")
    submenu.style.display = submenu.style.display === "block" ? "none" : "block";
}
document.addEventListener("DOMContentLoaded", function() {
    document.addEventListener("click",function(event){
        const usericon = document.querySelector(".incon-avatar");
        const submenu = document.getElementById("loginsubmenu");
        if(!usericon.contains(event.target) && !submenu.contains(event.target)){
            submenu.style.display = "none";
        }
    })
})