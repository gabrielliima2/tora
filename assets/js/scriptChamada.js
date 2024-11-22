const backFormChamada = document.querySelector('.backFormChamada')
const formChamada = document.querySelector('.formChamada')
const novaChamada = document.querySelector('.novaChamada')
const cancelarChamada = document.querySelector('.cancelarChamada')
const formEditarChamada = document.querySelector('.formEditarChamada')
const editarChamada = document.querySelector('.editarChamada')

novaChamada.addEventListener('click', ()=>{
    backFormChamada.classList.remove('hide')
    formChamada.classList.remove('hide')
    novaChamada.classList.add('hide')
})

editarChamada.addEventListener('click', ()=>{
    window.location.href = "editarChamada.php";

})

cancelarChamada.addEventListener('click', ()=>{
    window.location.href = "telaChamada.php";
})
