# 📌 Guia de Instalação e Configuração (Windows)

Este projeto utiliza **Laravel 11, PHP 8.2, Node.js 22, Vue 3 (Inertia.js), Tailwind CSS e Vite**. Siga os passos abaixo para configurar e rodar o projeto localmente no Windows.

## 📌 Requisitos

Antes de começar, certifique-se de que você tenha as seguintes dependências instaladas:

- 📌 [PHP 8.2](https://www.php.net/)
- 📌 [Composer](https://getcomposer.org/)
- 📌 [Node.js 22](https://nodejs.org/)
- 📌 [NPM](https://www.npmjs.com/)
- 📌 [Git](https://git-scm.com/)

Se você não tiver **PHP** e **Composer** configurados globalmente, pode ser útil usar o [XAMPP](https://www.apachefriends.org/pt_br/index.html) para configurar um ambiente PHP local de maneira mais simples no Windows.

---

## 📌 Passos para Instalação

### 🚀 1. Clonar o Repositório

```sh
git clone https://github.com/DevMboo/app-courses  
cd app-courses  
```

### 🚀 2. Configurar o Ambiente

Copie o arquivo **`.env.example`** para **`.env`**:  

```sh
cp .env.example .env  
```

Você pode utilizar o arquivo **`.env`** original presente no repositório para garantir a correta configuração do ambiente.

Em seguida, gere a chave da aplicação:

```sh
php artisan key:generate  
```

### 🚀 3. Instalar as Dependências do PHP

Instale as dependências do Laravel com o **Composer**:  

```sh
composer install  
```

### 🚀 4. Instalar as Dependências do Node.js

```sh
npm install  
```

### 🚀 5. Rodar as Migrações

Execute as migrações para configurar as tabelas do banco de dados:

```sh
php artisan migrate  
```

### 🚀 6. Executar a Seeder

Crie o usuário de teste via **seeder**:  

```sh
php artisan db:seed  
```

### 🚀 7. Configurar o Vite

O projeto utiliza **Vite** para empacotar e compilar os assets. Para rodá-lo em modo de desenvolvimento, execute:  

```sh
npm run dev  
```

### 🚀 8. Iniciar o Servidor Local

```sh
php artisan serve  
```

---

## 📌 Tecnologias Utilizadas

- **Laravel 11** – Framework PHP para backend.  
- **PHP 8.2** – Versão do PHP utilizada.  
- **Node.js 22** – Ambiente JavaScript para rodar o **Vite** e outras ferramentas.  
- **Vite** – Bundler de front-end rápido.  
- **Vue 3 (Inertia.js)** – Framework para criação de componentes dinâmicos no Laravel.  
- **Tailwind CSS** – Framework CSS para interfaces responsivas.  

---

## 📌 Comandos Úteis

| Comando | Descrição |  
|---------|-------------|  
| `php artisan serve` | Inicia o servidor Laravel |  
| `npm run dev` | Roda o **Vite** em modo de desenvolvimento |  
| `npm run build` | Compila os assets para produção |  
| `php artisan storage:link` | Linka o storage para acessos públicos |  
| `php artisan queue:work` | Inicia o **Queue Worker** para execução de tarefas em fila |  
| `php artisan schedule:work` | Inicia o **Scheduler** para execução de tarefas programadas |  

---

## 📌 Problemas Conhecidos

Caso enfrente dificuldades, verifique:

- Se todas as dependências do **PHP** e **Node.js** estão instaladas corretamente.  
- Se o arquivo **`.env`** está configurado com as credenciais corretas do banco de dados.  
- Se estiver com problemas no **Vite** no Windows, tente rodar o comando `npm run dev` no **Prompt de Comando** ou **PowerShell**, em vez do **Git Bash**, pois pode haver incompatibilidades.  

---

## 📌 Queue & Schedule Work

O projeto utiliza **queues** e **schedules** para processamento assíncrono de algumas tarefas. Para garantir o funcionamento correto de recursos como **exportação de PDF/Excel** e **pagamentos**, certifique-se de rodar os seguintes comandos em processos separados:

```sh
php artisan queue:work  
php artisan schedule:work  
```

