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

document.addEventListener("DOMContentLoaded", () => {
    const toggleButtons = document.querySelectorAll(".menu-toggle");
    
    toggleButtons.forEach(button => {
        button.addEventListener("click", (event) => {
            const menu = event.target.nextElementSibling;
            
            // Fecha todos os menus abertos antes de abrir outro
            document.querySelectorAll(".menu-options").forEach(menuItem => {
                if (menuItem !== menu) {
                    menuItem.classList.add("hide");
                }
            });
            
            // Alterna a visibilidade do menu
            menu.classList.toggle("hide");
        });
    });
    
    // Fechar o menu se clicar fora
    document.addEventListener("click", (event) => {
        if (!event.target.closest(".userInfo")) {
            document.querySelectorAll(".menu-options").forEach(menu => {
                menu.classList.add("hide");
            });
        }
    });
});

document.querySelectorAll(".menu-cancel").forEach(button => {
    button.addEventListener("click", () => {
        button.closest(".menu-options").classList.add("hide");
    });
});


document.addEventListener("DOMContentLoaded", () => {
    const deleteButtons = document.querySelectorAll(".delete-confirm");
    
    deleteButtons.forEach(button => {
        button.addEventListener("click", (event) => {
            const form = button.closest(".delete-form");
            
            // Exibir popup de confirmação
            const confirmDelete = confirm("Você tem certeza de que deseja excluir esta postagem?");
            if (confirmDelete) {
                form.submit(); // Submete o formulário apenas se o usuário confirmar
            }
        });
    });
});


document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("imageModal");
    const modalImage = document.getElementById("modalImage");
    const closeModal = document.querySelector(".close-modal");
    
    // Adiciona evento de clique para todas as imagens clicáveis
    document.querySelectorAll(".img-clickable").forEach(img => {
        img.addEventListener("click", () => {
            modal.style.display = "block";
            modalImage.src = img.src;
        });
    });
    
    // Fecha o modal
    closeModal.addEventListener("click", () => {
        modal.style.display = "none";
    });
    
    // Fecha o modal clicando fora da imagem
    modal.addEventListener("click", (event) => {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });
});

