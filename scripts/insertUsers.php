<?php
include('conexao.php');

// Função para inserir patentes
function insertPatentes($mysqli) {
    $patentes = ['Atirador', 'Monitor', 'Secretário', 'Superior'];
    foreach ($patentes as $nome) {
        $stmt = $mysqli->prepare("INSERT INTO patentes (nome) VALUES (?)");
        $stmt->bind_param("s", $nome);
        $stmt->execute();
        $stmt->close();
    }
}

// Função para inserir os usuários
function insertUsuarios($mysqli) {
    // Definindo os usuários com seus nomes, e-mails e patentes
    $usuarios = [
        // Atiradores
        ['Carlos Silva', 'carlos.silva@example.com', 1],
        ['Marcos Pereira', 'marcos.pereira@example.com', 1],
        ['André Oliveira', 'andre.oliveira@example.com', 1],
        ['João Santos', 'joao.santos@example.com', 1],
        ['Paulo Costa', 'paulo.costa@example.com', 1],
        ['Fernando Souza', 'fernando.souza@example.com', 1],
        ['Bruno Alves', 'bruno.alves@example.com', 1],
        ['Rodrigo Lima', 'rodrigo.lima@example.com', 1],
        ['Lucas Rocha', 'lucas.rocha@example.com', 1],
        ['Gustavo Ramos', 'gustavo.ramos@example.com', 1],
        ['Thiago Martins', 'thiago.martins@example.com', 1],
        ['Vinícius Mendes', 'vinicius.mendes@example.com', 1],
        ['Felipe Cardoso', 'felipe.cardoso@example.com', 1],
        ['Camilo Almeida', 'camilo.almeida@example.com', 1],
        ['Pedro Araújo', 'pedro.araujo@example.com', 1],
        ['Lucas Ferreira', 'lucas.ferreira@example.com', 1],
        ['Ricardo Xavier', 'ricardo.xavier@example.com', 1],
        ['Gabriel Moraes', 'gabriel.moraes@example.com', 1],
        ['Sandro Pires', 'sandro.pires@example.com', 1],
        ['Vinícius Barros', 'vinicius.barros@example.com', 1],
        ['Alex Cunha', 'alex.cunha@example.com', 1],
        ['Gabriel Vieira', 'gabriel.vieira@example.com', 1],
        ['Fernando Batista', 'fernando.batista@example.com', 1],
        ['Rafael Braga', 'rafael.braga@example.com', 1],

        // Monitores
        ['Leonardo Nunes', 'leonardo.nunes@example.com', 2],
        ['Michel Dias', 'michel.dias@example.com', 2],
        ['Bruno Gonçalves', 'bruno.goncalves@example.com', 2],
        ['Daniel Ribeiro', 'daniel.ribeiro@example.com', 2],
        ['Fábio Martins', 'fabio.martins@example.com', 2],
        ['Patrick Lopes', 'patrick.lopes@example.com', 2],
        ['André Farias', 'andre.farias@example.com', 2],
        ['Sérgio Campos', 'sergio.campos@example.com', 2],
        ['Caio Silva', 'caio.silva@example.com', 2],
        ['Carlos Dias', 'carlos.dias@example.com', 2],

        // Secretários
        ['Júlio Macedo', 'julio.macedo@example.com', 3],
        ['Renato Silva', 'renato.silva@example.com', 3],
        ['Eduardo Brito', 'eduardo.brito@example.com', 3],
        ['Tiago Freitas', 'tiago.freitas@example.com', 3],
        ['Bruno Souza', 'bruno.souza@example.com', 3],
        ['Mateus Queiroz', 'mateus.queiroz@example.com', 3],
        ['Vitor Araújo', 'vitor.araujo@example.com', 3],
        ['Raul Martins', 'raul.martins@example.com', 3],
        ['Lucas Castro', 'lucas.castro@example.com', 3],
        ['Ícaro Alves', 'icaro.alves@example.com', 3],

        // Superiores
        ['Marcelo Prado', 'marcelo.prado@example.com', 4],
        ['Mário Andrade', 'mario.andrade@example.com', 4],
        ['Wilson Mendes', 'wilson.mendes@example.com', 4],
        ['Afonso Barros', 'afonso.barros@example.com', 4],
        ['César Costa', 'cesar.costa@example.com', 4],
    ];

    // Gerando o hash da senha "123456"
    $senha = password_hash('123456', PASSWORD_DEFAULT);

    foreach ($usuarios as $user) {
        $stmt = $mysqli->prepare("INSERT INTO usuarios (nome, email, senha, id_patente) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $user[0], $user[1], $senha, $user[2]);
        $stmt->execute();
        $stmt->close();
    }
}

// Executando as funções para inserir patentes e usuários
insertPatentes($mysqli);
insertUsuarios($mysqli);

echo "Patentes e usuários inseridos com sucesso!";
?>
