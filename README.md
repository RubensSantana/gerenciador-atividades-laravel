
# 🗂️ Gerenciador de Atividades – Laravel

Este é um projeto web desenvolvido em Laravel como trabalho final da disciplina de Desenvolvimento Web. A aplicação permite aos usuários cadastrarem e organizarem atividades no estilo **Kanban**, com autenticação, controle de urgência, status e visualização por data.

---

## ✅ Funcionalidades

- Cadastro e login de usuários com Laravel Breeze
- CRUD completo de atividades (criar, listar, editar, excluir)
- Painel Kanban com colunas: A Fazer, Fazendo, Finalizada
- Indicação visual do nível de urgência (cores)
- Filtro de atividades finalizadas por data
- Data e hora de término são preenchidas automaticamente ao finalizar
- Proteção contra acessos indevidos e ações duplicadas
- Interface 100% em português e responsiva com Tailwind CSS

---

## ⚙️ Tecnologias Utilizadas

- PHP 8.2+
- Laravel 10
- Laravel Breeze (autenticação)
- Blade (templating engine)
- Tailwind CSS
- Vite (compilação de assets)
- MySQL (banco de dados)

---

## 🚀 Como Executar o Projeto

### 1. Clone o repositório

```bash
git clone https://github.com/RubensSantana/gerenciador-atividades-laravel.git
cd gerenciador-atividades-laravel
```

### 2. Instale as dependências

```bash
composer install
npm install
npm run build
```

### 3. Configure o .env

Crie o arquivo de ambiente:

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure o acesso ao banco MySQL

No arquivo `.env`, ajuste as variáveis conforme seu ambiente:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gerenciador_db
DB_USERNAME=root
DB_PASSWORD=sua_senha
```

Certifique-se de que o banco `gerenciador` já foi criado no MySQL.

### 5. Rode as migrations

```bash
php artisan migrate
```

### 6. Inicie o servidor local

```bash
php artisan serve
```

Acesse: [http://localhost:8000](http://localhost:8000)

---

## 🔐 Segurança

- Todas as rotas protegidas com `auth` e `verified`
- Verificação de usuário logado em todas as ações (show, edit, delete)
- Tokens CSRF ativos em todos os formulários
- Dados acessíveis somente pelo dono da conta
- Validações centralizadas em `AtividadeRequest`
- Prevenção contra cliques múltiplos em botões de envio

---

## 📝 Estrutura do Projeto

- `routes/web.php`: rotas principais com middleware `auth`
- `app/Http/Controllers/AtividadeController.php`: lógica das atividades
- `app/Http/Requests/AtividadeRequest.php`: validações personalizadas
- `resources/views`: arquivos Blade (telas)
- `database/migrations`: criação de tabelas
- `public/build`: assets compilados com Vite

---

## 👨‍🎓 Autor

Rubens Ricardo Santana  
Projeto da disciplina de Desenvolvimento de Sistemas para Web/Mobile III
Faculdade: Centro Universitário Campo Real  
Ano: 2025

---

## 📝 Licença

Uso acadêmico e educacional. Projeto entregue para fins avaliativos.
