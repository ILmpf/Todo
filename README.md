# Todo App

Aplicação de gestão de tarefas construída com Laravel 12 e Tailwind CSS 4.

## Índice

- [Visão Geral](#visão-geral)
- [Funcionalidades](#funcionalidades)
- [Tecnologias](#tecnologias)

---

## Visão Geral

O Todo App é uma aplicação web completa que permite aos utilizadores criar e gerir as suas tarefas pessoais. Cada utilizador tem acesso exclusivo às suas próprias tarefas.

---

## Funcionalidades

- **Autenticação**: registo, login e logout de utilizadores
- **Autorização**: cada utilizador acede apenas às suas próprias tarefas (políticas Laravel)
- **CRUD completo**: criar, visualizar, editar e eliminar tarefas
- **Soft delete**: tarefas eliminadas são mantidas na base de dados
- **Estados de tarefa**: Pendente, Em progresso e Concluída
- **Prioridades**: Baixa, Média e Alta
- **Data de conclusão**: campo opcional com validação de data
- **Filtros**: pesquisa por texto, filtragem por estado e prioridade, ordenação por data/prioridade/título

---

## Tecnologias

| Backend | PHP 8.4 + Laravel 12
| Frontend | Tailwind CSS 4 + Vite
| Base de dados (produção) | MySQL
| Base de dados (testes) | MYSQL
| Testes | Pest
