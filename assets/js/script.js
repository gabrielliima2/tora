const buttonOpenNav = document.querySelector('#buttonOpenNav')
const buttonCloseNav = document.querySelector('#buttonCloseNav')
const backNavMenu = document.querySelector('#backNavMenu')
const navMenu = document.querySelector('#navMenu')
const novaTurma = document.querySelector('#novaTurma')
const FormularioNovaTurma = document.querySelector('#FormularioNovaTurma')
const buttonCriarTurma = document.querySelector('#buttonCriarTurma')

buttonOpenNav.addEventListener('click', ()=>{
    buttonOpenNav.classList.add('hide')
    navMenu.classList.remove('hide')
    backNavMenu.classList.remove('hide')
})

backNavMenu.addEventListener('click', ()=>{
    buttonOpenNav.classList.remove('hide')
    navMenu.classList.add('hide')
    backNavMenu.classList.add('hide')
})

buttonCloseNav.addEventListener('click', ()=>{
    buttonOpenNav.classList.remove('hide')
    navMenu.classList.add('hide')
    backNavMenu.classList.add('hide')
})

novaTurma.addEventListener('click', ()=>{
    FormularioNovaTurma.classList.remove('hide')
    novaTurma.classList.add('hide')
})

buttonCriarTurma.addEventListener('click', ()=>{

})


function editarTurma(id) {
    const formData = new FormData();
    formData.append('id', id);

    fetch("alterarTurma.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        document.body.innerHTML = data; // Atualiza o conteúdo da página com o HTML da edição
    })
    .catch(error => console.error("Erro ao editar turma:", error));
}


function excluirTurma(id) {
    if (confirm("Tem certeza que deseja excluir esta turma?")) {
        const formData = new FormData();
        formData.append('id', id);

        fetch("excluirTurma.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert(data); // Exibe a resposta (sucesso ou erro)
            window.location.reload(); // Recarrega a página para atualizar a lista de turmas
        })
        .catch(error => console.error("Erro ao excluir turma:", error));
    }
}


