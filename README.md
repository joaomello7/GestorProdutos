# Protótipo do Projeto

Você pode visualizar o protótipo do projeto no Figma através do link abaixo:https://www.figma.com/proto/xeEBa9zqcT1Kn19U2IxSoP/Untitled?node-id=1-2&node-type=canvas&t=8PbdS8Vbc25tRP8U-1&scaling=min-zoom&content-scaling=fixed&page-id=0%3A1&starting-point-node-id=1%3A2&show-proto-sidebar=1 


## Diagrama Entidade-Relacionamento (DER)

### Tabelas e Relacionamentos
Login
id_login (Chave Primária)
nome_login
senha_login
senha_criptografada

Fornecedores
id (Chave Primária)
nome
data_registro
empresa
contato

Produtos
id (Chave Primária)
nome
descricao
valor
quantidade
total (Atributo derivado)
fornecedor_id (Chave Estrangeira que referencia fornecedores.id)
data_registro
