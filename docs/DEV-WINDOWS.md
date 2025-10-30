# Windows Development Guide

This project includes Windows-friendly scripts to run Laravel, Vite, and the queue worker easily.

## Quick start

- Start everything (3 processes in separate windows):

  ```powershell
  ./dev.ps1
  ```

- Check status:

  ```powershell
  ./dev-status.ps1
  ```

- Stop everything:

  ```powershell
  ./dev-stop.ps1
  ```

If PowerShell blocks scripts, run with:

```powershell
powershell -ExecutionPolicy Bypass -File dev.ps1
```

## Composer one-liners (single terminal)

- Start (without Laravel Pail):

  ```powershell
  composer run dev:win
  ```

- Status:

  ```powershell
  composer run status:win
  ```

- Stop:

  ```powershell
  composer run stop:win
  ```

## Ports and configuration

- Laravel: <http://127.0.0.1:8000>
- Vite: <http://localhost:5173>

Custom port:

```powershell
./dev.ps1 -Port 8001
```

Ensure your `.env` uses SQLite locally:

```ini
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```
