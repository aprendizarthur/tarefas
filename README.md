Exercício Técnico para Vaga de Estagiário em Desenvolvimento Web   

### Descrição do Exercício: Sistema de Gerenciamento de Tarefas  

Você deve criar uma aplicação web simples para gerenciar tarefas, com as seguintes funcionalidades:  

1. **Criar uma tarefa**: Um formulário onde o usuário pode inserir o título (obrigatório) e a descrição (opcional) de uma tarefa.  
2. **Listar tarefas**: Uma página que exiba todas as tarefas cadastradas em uma tabela, mostrando título, descrição e status (pendente ou concluída).  
3. **Marcar tarefa como concluída**: Um botão ou ação para alterar o status de uma tarefa para "concluída".  
4. **Excluir tarefa**: Um botão ou ação para remover uma tarefa do sistema.  

### Requisitos Técnicos:  
- **Back-end**:  
  - Utilize **PHP** para implementar a lógica da aplicação.  
  - Use um banco de dados relacional (recomendamos **MySQL** ou **SQLite**) para armazenar as tarefas. A tabela de tarefas deve conter, no mínimo, os campos: `id` (chave primária), `titulo`, `descricao`, `status` (pendente ou concluído) e `data_criacao`.  
  - Estruture o banco de dados e inclua o script SQL para criação da tabela no seu projeto.  
  - Implemente as operações CRUD (Create, Read, Update, Delete) para as tarefas.  
- **Front-end**:  
  - Crie uma interface simples e funcional utilizando **HTML** e **CSS**. O uso de frameworks como Bootstrap é permitido, mas não obrigatório.  
  - Adicione validação básica no formulário (ex.: título não pode estar vazio).  
  - A interface deve ser responsiva e visualmente clara.  
- **Boas práticas**:  
  - Estruture o código de forma organizada, separando lógica (PHP), apresentação (HTML/CSS) e banco de dados (SQL).  
  - Evite vulnerabilidades como SQL Injection (use prepared statements, se possível).  
  - Inclua comentários no código para facilitar a compreensão.  

### Instruções de Entrega:  
1. Envie o código-fonte completo (arquivos PHP, HTML, CSS e SQL) em um arquivo ZIP.  
2. Inclua um arquivo `README.md` com:  
   - Instruções para configurar e executar o projeto (ex.: como criar o banco de dados, dependências necessárias, etc.).  
   - Uma breve explicação das escolhas técnicas que você fez.  
3. Envie o arquivo ZIP para o e-mail da empresa com o assunto "Exercício Estágio - [Seu Nome]".  
4. Opcionalmente, você pode hospedar o projeto em um repositório Git (GitHub, GitLab, etc.) e compartilhar o link no e-mail.  

### Critérios de Avaliação:  
- Funcionalidade: Todas as funcionalidades solicitadas foram implementadas corretamente?  
- Qualidade do código: O código está bem estruturado, legível e segue boas práticas?  
- Banco de dados: A estrutura do banco é adequada e as operações são seguras?  
- Interface: A interface é funcional, clara e responsiva?  
- Documentação: O README está claro e contém as informações necessárias?  

Caso tenha dúvidas sobre o exercício, sinta-se à vontade para entrar em contato.  

Aguardamos seu envio até o prazo estipulado. Boa sorte!  
