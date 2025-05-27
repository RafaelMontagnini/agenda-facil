# Agenda Fácil

Projeto desenvolvido em PHP com PDO para conexão ao MySQL e Bootstrap 5 no front-end.

## Pré-requisitos

- PHP (versão compatível com PDO)  
- Servidor local XAMPP (Apache + MySQL)  
- Navegador  
- Postman (opcional, para testar a API)  

## Instalação

1. Clone o repositório:

git clone https://github.com/RafaelMontagnini/agenda-facil.git


2. Coloque o projeto na pasta htdocs do XAMPP:
 C:/xampp/htdocs/AgendaFacil

3. Importe o banco de dados:

 - Inicie o servidor Apache e MySQL no XAMPP.
 - Acesse http://localhost/phpmyadmin
 - Crie um banco chamado agenda_facil
 - Importe o arquivo agenda_facil.sql que está na raiz do projeto

4. Acesse o sistema via navegador:

 - http://localhost/AgendaFacil

🔗 API
    Endpoint: http://localhost/AgendaFacil/api/agendamentos.php

    Método: GET

    Headers (Obrigatório):
    Authorization: rafael123

🛠 Tecnologias Utilizadas
    PHP + PDO
    Bootstrap 5
    MySQL
    XAMPP
    Postman (para testes)
    Desenvolvido por Rafael Montagnini