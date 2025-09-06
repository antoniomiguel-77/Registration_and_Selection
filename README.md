# 📌 Sistema de Gestão de Candidaturas

Este projeto é uma API desenvolvida em **Laravel 11/12 (PHP 8.3+)** para gestão de **Candidatos** e **Programas**.  
Os candidatos podem registar-se, autenticar-se, candidatar-se a programas ativos e listar suas candidaturas.  

---

## 🚀 Requisitos Técnicos

- **Backend:** Laravel 11/12 (PHP 8.3+)
- **Base de dados:** MySQL
- **Autenticação:** Laravel Sanctum
- **Documentação da API:** Postman Collection incluída

---

## 📋 Regras de Negócio

- Um **Candidato** pode candidatar-se a **vários Programas**.
- O Candidato **só pode candidatar-se se estiver logado**.
- O **Programa** só aceita candidaturas se:
  - `data_inicio ≤ hoje ≤ data_fim`
  - `estado = ativo`
- Programas podem ser **pré-cadastrados no banco de dados**.

---

## ⚙️ Instalação

```bash
# 1. Clonar o repositório
git clone https://github.com/antoniomiguel-77/Registration_and_Selection
cd Registration_and_Selection

# 2. Instalar dependências
composer install

# 3. Copiar e configurar o .env
cp .env.example .env
php artisan key:generate

# 4. Criar base de dados e migrar
php artisan migrate --seed 

# 5. Iniciar o servidor local
php artisan serve

## ⚙️ Acessos Demo
# 1. email
 john@doe.com
# 2. password
 password
