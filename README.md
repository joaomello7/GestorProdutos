# Mini Sistema de Gestão de Produtos

Este projeto foi desenvolvido como parte da disciplina de Programação para Internet, com o objetivo de criar um sistema de CRUD (Create, Read, Update, Delete) para gerenciamento de produtos e fornecedores. O sistema inclui funcionalidades como cadastro de usuários, criptografia de senhas, autenticação, e uma interface para criação e gerenciamento de uma cesta de compras.

## Funcionalidades

- **Criação do Banco de Dados**: O sistema se conecta ao banco de dados `gerenciadordb` para gerar as tabelas automaticamente. Recomenda-se o uso do phpMyAdmin para a configuração inicial do banco de dados.
  
- **Cadastro de Usuários**: Permite a criação de novos usuários. Após o cadastro, o usuário pode acessar a tela de login para entrar no sistema e acessar o painel principal.

- **Cadastro de Fornecedores**: Permite o registro de fornecedores com todas as informações necessárias para o cadastro de produtos.

- **Cadastro de Produtos**: Inclui o registro de produtos com detalhes como nome, descrição, valor, quantidade, e fornecedor associado.

- **Criação de Cesta de Compras**: Os produtos podem ser adicionados a uma cesta de compras através de uma interface com checkbox, permitindo ao cliente selecionar os itens que deseja comprar.

- **Atualização Dinâmica da Cesta**: A cesta de compras é atualizada dinamicamente usando AJAX, evitando o recarregamento da página e proporcionando uma experiência mais fluida ao usuário.

## Tecnologias Utilizadas

- **PHP**: Utilizado para o backend, lidando com a lógica de negócio e a conexão com o banco de dados.

- **MySQL**: Banco de dados utilizado para armazenar informações de usuários, produtos, fornecedores e cestas.

- **HTML**: Usado para estruturar a interface visual do sistema.

- **Tailwind CSS**: Framework CSS utilizado para estilizar a interface do usuário.

- **JavaScript (AJAX)**: Utilizado para interações dinâmicas no frontend, permitindo atualizações da página sem recarregamento completo.

## Diagrama Entidade Relacionamento (DER)

![der](https://github.com/user-attachments/assets/90cbec06-d53d-48ea-954b-2e0ebfd0efc1)

## Figma: https://www.figma.com/design/xeEBa9zqcT1Kn19U2IxSoP/Untitled?node-id=0-1&m=dev&t=i3v7Vg4JRZaFO703-1

# Integrantes
Vinicius Correia de Andrade 
Ra: 251953-1
João Pedro de Mello Delgado 
Ra: 246387-1
Kaua Aparecido
