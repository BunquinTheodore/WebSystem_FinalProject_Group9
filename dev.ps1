param(
    [string]$Port = "8000"
)

$ErrorActionPreference = "Stop"

# Go to project root (where this script sits)
$root = Split-Path $MyInvocation.MyCommand.Path -Parent
Set-Location $root

Write-Host "Starting Laravel server, Vite, and queue worker..." -ForegroundColor Cyan

# 1) Laravel dev server
$server = Start-Process -FilePath "php" -ArgumentList @("artisan","serve","--host=127.0.0.1","--port=$Port") -WindowStyle Normal -PassThru

# 2) Vite dev server (use npm.cmd to avoid PowerShell execution policy issues)
$vite = Start-Process -FilePath "npm.cmd" -ArgumentList @("run","dev") -WindowStyle Normal -PassThru

# 3) Queue worker
$queue = Start-Process -FilePath "php" -ArgumentList @("artisan","queue:listen","--tries=1") -WindowStyle Normal -PassThru

# Persist PIDs for easy shutdown
$pidInfo = [ordered]@{
    server    = $server.Id
    vite      = $vite.Id
    queue     = $queue.Id
    port      = $Port
    timestamp = (Get-Date).ToString('o')
}
$pidInfo | ConvertTo-Json | Set-Content -Path ".dev-pids.json" -Encoding UTF8

Write-Host ""; Write-Host "Started processes:" -ForegroundColor Green
Write-Host "  • Laravel server PID $($server.Id)  →  http://127.0.0.1:$Port"
Write-Host "  • Vite dev server PID $($vite.Id)   →  http://localhost:5173"
Write-Host "  • Queue worker PID $($queue.Id)"

Write-Host ""; Write-Host "To stop everything later, run: ./dev-stop.ps1" -ForegroundColor Yellow
Write-Host ""; Write-Host "Press Enter to open the app in your browser..." -ForegroundColor Yellow
[void][System.Console]::ReadLine()
Start-Process "http://127.0.0.1:$Port"

Write-Host "Done. Leave the opened windows running while you develop." -ForegroundColor Cyan
