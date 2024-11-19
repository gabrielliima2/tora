const botaoNovaNoticia = document.querySelector('#botaoNovaNoticia')
const backContainerNewPost = document.querySelector('.backContainerNewPost')
const containerNewPost = document.querySelector('.containerNewPost')
const btnCloseNews = document.querySelector('.btnCloseNews')


botaoNovaNoticia.addEventListener('click', ()=>{
    containerNewPost.classList.remove('hide')
    backContainerNewPost.classList.remove('hide')
})


btnCloseNews.addEventListener('click', () => {


        containerNewPost.classList.add('hide');
        backContainerNewPost.classList.add('hide');
});

