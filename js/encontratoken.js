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
    const item = document.createElement('li');
    const link = document.createElement('a');
    link.href = 'alteracao.html';
    item.appendChild(link)
    menu.appendChild(item)
} else {
    menu.innerHTML ="";
    console.log('Token não encontrado no cookie!');
    const item = document.createElement('li');
    const link = document.createElement('a');
    link.textContent = 'login'
    link.href = 'login.html';
    item.appendChild(link);
    menu.appendChild(item);
}

const avatar = document.querySelector('.incon-avatar')
const submenu = document.querySelectorAll('.submenu');
console.log(avatar);  
console.log(submenu);
avatar.addEventListener('click', function(event){
    event.preventDefault();
    if (submenu.style.display === 'block'){
        submenu.style.display = 'none';
    } else {
        submenu.style.display = 'block';
    }
})