# Agenda Fácil

Sistema de agendamentos simples, desenvolvido em PHP com PDO para conexão ao MySQL e interface com Bootstrap 5.

## Pré-requisitos

- PHP + PDO  
- Servidor local XAMPP (Apache + MySQL)  
- Navegador  
- Postman (opcional, para testar a API)  

## Instalação

1. Clone o repositório:

    - git clone https://github.com/RafaelMontagnini/agenda-facil.git


2. Coloque o projeto na pasta htdocs do XAMPP:

    - C:/xampp/htdocs/AgendaFacil

3. Configure o banco de dados:

 - Inicie Apache e MySQL no XAMPP
 - Acesse: http://localhost/phpmyadmin
 - Crie um banco com o nome agenda_facil
 - Importe o arquivo agenda_facil.sql que está na raiz do projeto

4. Acesse o sistema no navegador:

 - http://localhost/AgendaFacil

## Login no Sistema
    - Você pode criar um novo usuário médico no momento antes de logar ou usar um dos acessos já cadastrados:
        - rafael@gmail.com | Senha: 1234  
        - matheus@gmail.com | Senha: 12345

## API de Agendamentos
    - Endpoint: 
        - http://localhost/AgendaFacil/api/agendamentos.php

    - Método: 
        - GET

    - Headers (Obrigatório):
        - Authorization: rafael123

## Tecnologias Utilizadas
    - PHP + PDO
    - Bootstrap 5
    - MySQL
    - XAMPP
    - Postman (para testes)
    - Desenvolvido por Rafael Montagnini