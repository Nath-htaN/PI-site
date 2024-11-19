function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}
const menu = document.querySelector('.submenu')
// Verifica se o token existe nos cookies
if (getCookie('token')) {
    menu.innerHTML ="";
    console.log('Token encontrado no cookie!');
    const link = document.createElement('a');
    link.textContent = 'alterar produto'
    link.href = 'alteracao.html';
    menu.appendChild(link)
} else {
    menu.innerHTML ="";
    console.log('Token não encontrado no cookie!');
    const link = document.createElement('a');
    link.textContent = 'login'
    link.href = 'login.html';
    menu.appendChild(link);
}

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