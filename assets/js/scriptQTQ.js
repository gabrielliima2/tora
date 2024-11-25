const botaoCriarQTQ = document.querySelector('#botaoCriarQTQ')
const backFormCriarNovoQuadro = document.querySelector('.backFormCriarNovoQuadro')
const formCriarNovoQuadro = document.querySelector('.formCriarNovoQuadro')

botaoCriarQTQ.addEventListener('click', ()=>{
    backFormCriarNovoQuadro.classList.remove('hide')
    formCriarNovoQuadro.classList.remove('hide')
})