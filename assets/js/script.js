const buttonOpenNav = document.querySelector('#buttonOpenNav')
const buttonCloseNav = document.querySelector('#buttonCloseNav')
const backNavMenu = document.querySelector('#backNavMenu')
const navMenu = document.querySelector('#navMenu')
const novaTurma = document.querySelector('#novaTurma')
const FormularioNovaTurma = document.querySelector('#FormularioNovaTurma')

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

