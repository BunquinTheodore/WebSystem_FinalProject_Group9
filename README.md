<!-- README.md -->

<div align="center">
    <img width="360" height="77" alt="Image" src="https://github.com/user-attachments/assets/71c5eb77-ee79-4484-af39-fdcf10b5b028" />
  <h1>☕ Bluemoon Coffee Shop Management System</h1>
  <p><strong>A modern, role-based web app for managing and monitoring daily coffee shop operations.</strong></p>

  ![Laravel](https://img.shields.io/badge/Built%20with-Laravel-red?style=flat-square&logo=laravel)
  ![PostgreSQL](https://img.shields.io/badge/Database-PostgreSQL-blue?style=flat-square&logo=postgresql)
  ![CSS](https://img.shields.io/badge/UI-TailwindCSS-38B2AC?style=flat-square&logo=tailwind-css)
  ![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)
</div>

---

## 🌟 Overview
**Bluemoon Coffee Shop Management System** (also known as **WebSys**) is a business management platform that enables **owners**, **managers**, and **employees** to coordinate daily operations efficiently.

It provides real-time tracking of employee tasks, photo verification, and built-in reporting tools — all through a clean, role-based dashboard interface inspired by modern productivity apps.

---

## 🚀 Features

### 👑 Owner Dashboard
- View sales, reports, and performance metrics.
- Manage employees and assign manager-level roles.
- Access APEPO (Audit, People, Equipment, Product, Others) and financial reports.
- Monitor task completion and approve or reject reports.

### 🧑‍💼 Manager Dashboard
- Receive daily tasks from the owner.
- Assign tasks to employees with one click.
- Submit **APEPO** and **Financial Reports**.
- Manage inventory with categories like kitchen and bar.
- Attach proof images (e.g., wasted inventory, shift reports).

### 👨‍🍳 Employee Dashboard
- View and complete assigned tasks with camera verification.
- Access instructional **Recipe & Preparation Guides** with videos.
- Track personal task history and progress.
- Manage inventory input and view updates in real time.

---

## 🛠️ Tech Stack

| Layer | Technology |
|-------|-------------|
| **Frontend** | Blade Templates, TailwindCSS |
| **Backend** | Laravel (PHP Framework) |
| **Database** | PostgreSQL |
| **Runtime** | PHP 8+ |
| **Package Manager** | Composer & NPM |
| **Version Control** | Git & GitHub |

---

## ⚙️ Installation & Setup

### 1️⃣ Clone the Repository
```bash
git clone https://github.com/BunquinTheodore/WebSys-Coffee-Shop.git
cd WebSys-Coffee-Shop
```

### 2️⃣ Install PHP Dependencies
```bash
composer install
```

### 3️⃣ Set Up Environment File
```bash
cp .env.example .env
```

### 4️⃣ Generate Application Key
```bash
php artisan key:generate
```

### 5️⃣ Run Database Migrations
```bash
php artisan migrate
```

### 6️⃣ Seed the Database (Optional)
```bash
php artisan db:seed
```

### 7️⃣ Start the Development Server
```bash
php artisan serve
```

---

## 🪟 Local development on Windows

The default "dev" script uses Laravel Pail, which requires the `pcntl` extension (not available on Windows). Use these Windows-friendly options:

### Option A — Composer one-liner

```powershell
composer run dev:win
```

Starts the Laravel server, queue worker, and Vite in one terminal.

### Option B — PowerShell helper scripts

From the project root (`WebSystem_FinalProject_Group9`), run:

```powershell
./dev.ps1          # start Laravel, Vite, and queue worker
./dev-status.ps1   # show RUNNING/STOPPED status and URLs
./dev-stop.ps1     # stop all dev processes cleanly
```

If your PowerShell execution policy blocks scripts, run them like this:

```powershell
powershell -ExecutionPolicy Bypass -File dev.ps1
```

### Notes

- Local DB defaults to SQLite. Ensure your `.env` contains:

  ```ini
  DB_CONNECTION=sqlite
  DB_DATABASE=database/database.sqlite
  ```

- If port 8000 is busy:

  ```powershell
  php artisan serve --port 8001
  # or
  ./dev.ps1 -Port 8001
  ```
