<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>
Laravel Multi-Tenant SaaS – User with Multiple Companies
This is a minimal multi-tenant SaaS backend built with Laravel. Each authenticated user can create, manage, and switch between multiple companies under their account. All future actions and data will be scoped to the currently active company.

✅ Features

User authentication (register, login, logout) via Sanctum

Create, list, update, and delete companies under a user's account

Switch between active companies

Middleware to enforce active company for protected routes

Clean Eloquent relationships and MySQL schema

Proper validation and error handling

📁 Tech Stack

Laravel 10+

Sanctum for API authentication

MySQL

PHP 8.1+

Postman for testing

📋 Prerequisites

PHP 8.1 or higher

Composer

MySQL

Node.js and NPM (only if using frontend scaffolding)

🚀 Setup Instructions

Clone the Repository

git clone https://github.com/your-username/laravel-multi-tenant-saas.git cd laravel-multi-tenant-saas

Install Dependencies

composer install npm install && npm run dev # Only if using Laravel Breeze or frontend scaffolding

Create .env File

cp .env.example .env

Update the .env file with your database name, username, and password.

Generate Application Key

php artisan key:generate

Run Migrations

php artisan migrate

Serve the Application

php artisan serve

API Base URL: http://127.0.0.1:8000/api

🔐 Authentication Endpoints

Method

Endpoint

Description

POST

/api/register

Register new user

POST

/api/login

Login user

POST

/api/logout

Logout authenticated user (requires token)

🏢 Company Endpoints

Method

Endpoint

Description

GET

/api/companies

List all companies of user

POST

/api/companies

Create a new company

PUT

/api/companies/{id}

Update company details

DELETE

/api/companies/{id}

Delete (soft delete) a company

POST

/api/companies/{company_id}/switch

Switch active company

📌 All endpoints except login/register/logout require authentication.

📬 Example API Requests (Postman or cURL)

Create Company

POST /api/companies { "name": "MyCompany", "address": "123 Market St", "industry": "IT" }

Switch Active Company

POST /api/companies/2/switch

🧠 Multi-Tenant Logic & Data Scoping

Every user can have multiple companies.

The currently active company is tracked using the active_company_id field in the users table.

Middleware (EnsureCompanySelected) enforces that users have an active company selected before accessing tenant-specific resources.

Switching company sets the context for the rest of the session.

Data isolation ensures users can only manage their own companies.

📄 Database Schema Overview

users

id

name

email

password

active_company_id (nullable)

timestamps

companies

id

user_id (foreign key)

name

address

industry

timestamps

deleted_at (for soft deletes)

Optional: user_active_companies Table (Not used in this project)

id (PK)

user_id (FK to users)

company_id (FK to companies)

📬 Sample Company Payload

{ "name": "Acme Corp", "address": "123 Main Street", "industry": "Software" }

👨‍💼 Author

Mahesh from The Tech WebGitHub: @thetechweb-mahesh
