<?php
include('conexao.php');


function insertPatentes($mysqli) {
    $patentes = ['Atirador', 'Monitor', 'Secretário', 'Superior'];
    foreach ($patentes as $nome) {
        $stmt = $mysqli->prepare("INSERT INTO patentes (nome) VALUES (?)");
        $stmt->bind_param("s", $nome);
        $stmt->execute();
        $stmt->close();
    }
}


function insertUsuarios($mysqli) {

    $usuarios = [
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
        ['José Santos', 'jose.santos@example.com', 1],
        ['Paulo Oliveira', 'paulo.oliveira@example.com', 1],
        ['Lucas Costa', 'lucas.costa@example.com', 1],
        ['Fernando Souza', 'fernando.souza@example.com', 1],
        ['Ricardo Almeida', 'ricardo.almeida@example.com', 1],
        ['Eduardo Pereira', 'eduardo.pereira@example.com', 1],
        ['Roberto Lima', 'roberto.lima@example.com', 1],
        ['Marcelo Carvalho', 'marcelo.carvalho@example.com', 1],
        ['Antonio Mendes', 'antonio.mendes@example.com', 1],
        ['Gustavo Rocha', 'gustavo.rocha@example.com', 1],
        ['Renato Martins', 'renato.martins@example.com', 1],
        ['Felipe Pereira', 'felipe.pereira@example.com', 1],
        ['Diego Gomes', 'diego.gomes@example.com', 1],
        ['Vitor Nunes', 'vitor.nunes@example.com', 1],
        ['Thiago Rodrigues', 'thiago.rodrigues@example.com', 1],
        ['Bruno Silva', 'bruno.silva@example.com', 1],
        ['André Costa', 'andre.costa@example.com', 1],
        ['Marcos Alves', 'marcos.alves@example.com', 1],
        ['Vinícius Souza', 'vinicius.souza@example.com', 1],
        ['Fábio Lima', 'fabio.lima@example.com', 1],
        ['Rafael Oliveira', 'rafael.oliveira@example.com', 1],
        ['Samuel Rocha', 'samuel.rocha@example.com', 1],
        ['Felipe Gomes', 'felipe.gomes@example.com', 1],
        ['Renan Ferreira', 'renan.ferreira@example.com', 1],
        ['Daniel Costa', 'daniel.costa@example.com', 1],
        ['Alexandre Almeida', 'alexandre.almeida@example.com', 1],
        ['Gustavo Santos', 'gustavo.santos@example.com', 1],
        ['Eduardo Lima', 'eduardo.lima@example.com', 1],
        ['Vinícius Carvalho', 'vinicius.carvalho@example.com', 1],
        ['Carlos Mendes', 'carlos.mendes@example.com', 1],
        ['Paulo Rocha', 'paulo.rocha@example.com', 1],
        ['Marcelo Nunes', 'marcelo.nunes@example.com', 1],
        ['Lucas Gomes', 'lucas.gomes@example.com', 1],
        ['Ricardo Costa', 'ricardo.costa@example.com', 1],
        ['André Oliveira', 'andre.oliveira@example.com', 1],
        ['Gustavo Martins', 'gustavo.martins@example.com', 1],
        ['Felipe Almeida', 'felipe.almeida@example.com', 1],
        ['João Lima', 'joao.lima@example.com', 1],
        ['Thiago Oliveira', 'thiago.oliveira@example.com', 1],
        ['Bruno Pereira', 'bruno.pereira@example.com', 1],
        ['Diego Almeida', 'diego.almeida@example.com', 1],
        ['Rafael Nunes', 'rafael.nunes@example.com', 1],
        ['Marcelo Silva', 'marcelo.silva@example.com', 1],
        ['Roberto Santos', 'roberto.santos@example.com', 1],
        ['Felipe Rodrigues', 'felipe.rodrigues@example.com', 1],
        ['Lucas Pereira', 'lucas.pereira@example.com', 1],
        ['Carlos Oliveira', 'carlos.oliveira@example.com', 1],
        ['José Almeida', 'jose.almeida@example.com', 1],
        ['Vitor Martins', 'vitor.martins@example.com', 1],
        ['Renato Souza', 'renato.souza@example.com', 1],
        ['Ricardo Ferreira', 'ricardo.ferreira@example.com', 1],
        ['Thiago Silva', 'thiago.silva@example.com', 1],
        ['Bruno Gomes', 'bruno.gomes@example.com', 1],
        ['Felipe Santos', 'felipe.santos@example.com', 1],
        ['Lucas Lima', 'lucas.lima@example.com', 1],
        ['Rafael Carvalho', 'rafael.carvalho@example.com', 1],
        ['Marcos Souza', 'marcos.souza@example.com', 1],
        ['Alexandre Costa', 'alexandre.costa@example.com', 1],
        ['Vitor Oliveira', 'vitor.oliveira@example.com', 1],
        ['André Santos', 'andre.santos@example.com', 1],
        ['Felipe Rocha', 'felipe.rocha@example.com', 1],
        ['Carlos Costa', 'carlos.costa@example.com', 1],
        ['Bruno Silva', 'bruno.silva@example.com', 1],
        ['Diego Costa', 'diego.costa@example.com', 1],
        ['Ricardo Rocha', 'ricardo.rocha@example.com', 1],
        ['Felipe Nunes', 'felipe.nunes@example.com', 1],
        ['Marcelo Oliveira', 'marcelo.oliveira@example.com', 1],
        ['Lucas Santos', 'lucas.santos@example.com', 1],
        ['Thiago Ferreira', 'thiago.ferreira@example.com', 1],
        ['Rafael Gomes', 'rafael.gomes@example.com', 1],
        ['Renato Lima', 'renato.lima@example.com', 1],
        ['Carlos Ferreira', 'carlos.ferreira@example.com', 1],
        ['Alexandre Silva', 'alexandre.silva@example.com', 1],
        ['Gustavo Almeida', 'gustavo.almeida@example.com', 1],
        ['Marcos Almeida', 'marcos.almeida@example.com', 1],
        ['Vitor Rocha', 'vitor.rocha@example.com', 1],
        ['Thiago Mendes', 'thiago.mendes@example.com', 1],
        ['Felipe Lima', 'felipe.lima@example.com', 1],
        ['Renato Oliveira', 'renato.oliveira@example.com', 1],
        ['Rafael Pereira', 'rafael.pereira@example.com', 1],
        ['Ricardo Nunes', 'ricardo.nunes@example.com', 1],
        ['Felipe Almeida', 'felipe.almeida@example.com', 1],
        ['Marcos Pereira', 'marcos.pereira@example.com', 1],
        ['Lucas Mendes', 'lucas.mendes@example.com', 1],
        ['José Ferreira', 'jose.ferreira@example.com', 1],
        ['Carlos Santos', 'carlos.santos@example.com', 1],
        ['Ricardo Oliveira', 'ricardo.oliveira@example.com', 1],
        ['Renato Santos', 'renato.santos@example.com', 1],
        ['Lucas Oliveira', 'lucas.oliveira@example.com', 1],
        ['Bruno Almeida', 'bruno.almeida@example.com', 1],
        ['Diego Rodrigues', 'diego.rodrigues@example.com', 1],
        ['Thiago Nunes', 'thiago.nunes@example.com', 1],
        ['Carlos Rodrigues', 'carlos.rodrigues@example.com', 1],
        ['José Rocha', 'jose.rocha@example.com', 1],
        ['Marcelo Costa', 'marcelo.costa@example.com', 1],
        ['André Pereira', 'andre.pereira@example.com', 1],
        ['Ricardo Costa', 'ricardo.costa@example.com', 1],
        ['Felipe Oliveira', 'felipe.oliveira@example.com', 1],
        ['Carlos Nunes', 'carlos.nunes@example.com', 1],
        ['Vitor Souza', 'vitor.souza@example.com', 1],
        ['Bruno Costa', 'bruno.costa@example.com', 1],
        ['Lucas Rocha', 'lucas.rocha@example.com', 1],
        ['Renato Costa', 'renato.costa@example.com', 1],
        ['Diego Souza', 'diego.souza@example.com', 1],
        ['Felipe Ferreira', 'felipe.ferreira@example.com', 1],

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

  
    $senha = password_hash('123456', PASSWORD_DEFAULT);

    foreach ($usuarios as $user) {
        $stmt = $mysqli->prepare("INSERT INTO usuarios (nome, email, senha, id_patente) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $user[0], $user[1], $senha, $user[2]);
        $stmt->execute();
        $stmt->close();
    }
}


insertPatentes($mysqli);
insertUsuarios($mysqli);

echo "Patentes e usuários inseridos com sucesso!";
?>
