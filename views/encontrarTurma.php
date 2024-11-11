<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">    
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../assets/js/script.js" defer></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js" defer></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js" defer></script>
    <title>Tóra</title>
    <script>
        function searchTurma() {
            const searchTerm = document.getElementById('search').value;

            // Cria uma requisição AJAX
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'buscarTurma.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            // Define a ação para processar o retorno da busca
            xhr.onload = function() {
                if (this.status === 200) {
                    document.getElementById('containerListaTurma').innerHTML = this.responseText;
                }
            };

            // Envia a consulta com o termo de busca, vazio ou não
            xhr.send('search=' + encodeURIComponent(searchTerm));
        }

        // Adiciona o evento de input para acionar a função de busca em tempo real
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('search').addEventListener('input', searchTurma);
            // Chama a função ao carregar a página para exibir todas as turmas inicialmente
            searchTurma();
        });
    </script>
</head>
<body>
    <?php include("../components/header.php"); ?>
    <?php include("../components/menu.php"); ?>
    
    <main id="mainTurma">
        <div id="containerListaTurma">
            <!-- Formulário de busca -->
            <form onsubmit="return false;" class="search-form">
                <input type="text" id="search" name="search" placeholder="Pesquisar turma (nome ou ano)" />
            </form>
            <!-- Conteúdo da busca será atualizado aqui -->
        </div>
    </main>
</body>
</html>
