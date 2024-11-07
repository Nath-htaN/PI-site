function cadastroUsuario(){
    const form=document.getElementById('usuarioForm');
    const formData=new FormData(form);

    fetch('cadastrousu.php', {
        method: 'POST',
        body: formData
    })
    .then(response=>response.text())
    .then(data=> {
        document.getElementById('mensagem').innerText=data;
        form.reset();
    })
    .catch(error=>{
        console.error('Erro: ', error);
        document.getElementById('mensagem').innerText='Erro ao cadastrar usuário.';
    });
}