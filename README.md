# Sistema Tóra

O **Tóra** é um sistema web desenvolvido para o gerenciamento de atiradores no Tiro de Guerra, focado na otimização de processos administrativos como controle de presença, escalas de guarda, e gerenciamento de dados dos atiradores. O sistema oferece uma interface intuitiva e funcionalidades voltadas para todos os membros da organização, como atiradores, monitores e superiores.

## Estrutura do Projeto

A seguir está a estrutura de diretórios e arquivos do sistema **Tóra**:

```plaintext
/tora
│
├── /assets
│   ├── /css
│   │   └── style.css          # Arquivo de estilos CSS
│   ├── /js
│   │   └── script.js          # Arquivo de scripts JavaScript
│   ├── /img
│   │   └── logo.png           # Logotipo do sistema
│
├── /components
│   └── header.php             # Componente de cabeçalho reutilizável
│   └── footer.php             # Componente de rodapé reutilizável
│   └── menu.php               # Menu de navegação
│
├── /controllers
│   └── authController.php     # Lógica de autenticação de usuários
│   └── escalaController.php   # Controle das escalas de guarda
│   └── chamadaController.php  # Controle de presença
│
├── /models
│   └── user.php               # Model para interações com usuários (CRUD)
│   └── escala.php             # Model para interações com escalas de guarda
│   └── chamada.php            # Model para interações com chamadas e presenças
│
├── /scripts
│   └── conexao.php            # Script de conexão com o banco de dados
│   └── protect.php            # Script de proteção de rotas para usuários autenticados
│   └── logout.php             # Script para logout do sistema
│
├── /views
│   ├── home.php               # Página inicial (home) do sistema
│   ├── login.php              # Página de login
│   ├── profile.php            # Página de perfil do usuário
│   ├── chamada.php            # Página de controle de presença
│   ├── escala_guarda.php       # Página de controle de escala de guarda
│   ├── qtq.php                # Página de quadro técnico-quantitativo (QTQ)
│   ├── error.php              # Página de erro
│
├── /config
│   └── config.php             # Arquivo de configuração do sistema
│   └── routes.php             # Definição de rotas
│
├── /uploads
│   └── atiradores             # Diretório para uploads de documentos e imagens de atiradores
│   └── relatórios             # Diretório para relatórios gerados pelo sistema
│
├── .htaccess                  # Configurações do Apache (redirecionamentos, segurança)
├── index.php                  # Arquivo de entrada principal (página inicial)
├── README.md                  # Documentação do projeto
└── composer.json              # Gerenciamento de dependências PHP (opcional)
```

## Funcionalidades

- **Autenticação de Usuários**: Controle de login e logout com proteção de rotas para garantir que apenas usuários autenticados possam acessar determinadas páginas.
- **Controle de Presença**: Gerenciamento e monitoramento de presença dos atiradores.
- **Escala de Guarda**: Exibição e controle das escalas de guarda, com visualização e alternância de atiradores.
- **Perfis de Usuários**: Cada usuário pode acessar e atualizar suas informações pessoais.
- **Quadro Técnico-Quantitativo (QTQ)**: Página dedicada ao gerenciamento e exibição de dados técnicos e quantitativos do Tiro de Guerra.
- **Uploads de Documentos**: Possibilidade de upload de documentos, imagens e relatórios relacionados aos atiradores.

## Requisitos

### Backend
- PHP 7.4 ou superior
- Servidor web Apache com mod_rewrite habilitado
- MySQL para o banco de dados

### Frontend
- HTML5 e CSS3
- JavaScript (opcional para funcionalidades interativas)
- Ionicons para ícones (já integrado)

## Configuração do Projeto

1. **Clone o repositório**:
   ```bash
   git clone https://github.com/gabriellima2/tora.git
   ```

2. **Configuração do Banco de Dados**:
   - Crie um banco de dados MySQL com o nome `tora_db`.
   - Execute o script SQL fornecido para criar as tabelas e dados necessários.

3. **Configuração de Conexão com o Banco**:
   - No arquivo `scripts/conexao.php`, defina suas credenciais do banco de dados MySQL:
     ```php
     $host = 'localhost';
     $user = 'root';
     $password = '';
     $dbname = 'tora_db';
     ```

4. **Configurando o Apache**:
   - Certifique-se de que o `.htaccess` está habilitado para garantir a navegação correta do sistema.
   
5. **Dependências (opcional)**:
   - Se o projeto usar bibliotecas via Composer, execute o comando:
     ```bash
     composer install
     ```

## Uso

1. **Acessar o sistema**:
   - Abra o navegador e acesse `http://localhost/tora`.
   - Realize o login com as credenciais de usuário cadastradas.

2. **Funcionalidades**:
   - **Página Inicial**: Visualize as opções disponíveis conforme a patente do usuário.
   - **Escala de Guarda**: Gerencie as escalas de atiradores para atividades diárias.
   - **Controle de Presença**: Registre a presença dos atiradores.
   - **Perfil**: Atualize informações pessoais no perfil.

## Expansões Futuras

- Implementar relatórios detalhados de desempenho e presença dos atiradores.
- Adicionar funcionalidades de notificações automáticas via e-mail ou SMS.
- Melhorar o layout para responsividade em dispositivos móveis.
- Integração com APIs para novos recursos como geolocalização dos atiradores.

## Licença

Este projeto está licenciado sob a [MIT License](LICENSE).