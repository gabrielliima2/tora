
const botaoAparecerGerarEscala = document.querySelector('#botaoAparecerGerarEscala')
const formGerarEscala = document.querySelector('.formGerarEscala')
const backFormEscala = document.querySelector('.backFormEscala')


botaoAparecerGerarEscala.addEventListener('click', ()=>{
    formGerarEscala.classList.remove('hide')
    backFormEscala.classList.remove('hide')
})

