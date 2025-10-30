param(
    [int]$Port = 8000,
    [int]$VitePort = 5173
)

$ErrorActionPreference = "Stop"

$root = Split-Path $MyInvocation.MyCommand.Path -Parent
Set-Location $root

function Get-StatusLabel($running) {
    if ($running) { return "RUNNING" } else { return "STOPPED" }
}

$pidFile = ".dev-pids.json"
$pidData = $null
if (Test-Path $pidFile) {
    try { $pidData = Get-Content $pidFile | ConvertFrom-Json } catch {}
}

if ($pidData -and $pidData.port) { $Port = [int]$pidData.port }

# Helper to test PID and Port
function Test-Pid($pid) {
    try {
        if (-not $pid) { return $false }
        $p = Get-Process -Id $pid -ErrorAction SilentlyContinue
        return $null -ne $p
    } catch { return $false }
}

function Test-Port($p) {
    try {
        $conn = Get-NetTCPConnection -LocalPort $p -State Listen -ErrorAction SilentlyContinue
        return $null -ne $conn
    } catch { return $false }
}

$serverRunning = $false
$viteRunning = $false
$queueRunning = $false

# Prefer PID-based checks, fall back to port
if ($pidData -and $pidData.server) { $serverRunning = Test-Pid([int]$pidData.server) }
if (-not $serverRunning) { $serverRunning = Test-Port $Port }

if ($pidData -and $pidData.vite) { $viteRunning = Test-Pid([int]$pidData.vite) }
if (-not $viteRunning) { $viteRunning = Test-Port $VitePort }

if ($pidData -and $pidData.queue) { $queueRunning = Test-Pid([int]$pidData.queue) }

Write-Host ""; Write-Host "Dev status" -ForegroundColor Cyan
Write-Host "  Laravel server : $(Get-StatusLabel $serverRunning)  →  http://127.0.0.1:$Port"
Write-Host "  Vite dev server: $(Get-StatusLabel $viteRunning)   →  http://localhost:$VitePort"
Write-Host "  Queue worker   : $(Get-StatusLabel $queueRunning)"

if ($pidData) {
    Write-Host ""; Write-Host "From $pidFile:" -ForegroundColor DarkGray
    Write-Host "  server PID: $($pidData.server)"
    Write-Host "  vite PID  : $($pidData.vite)"
    Write-Host "  queue PID : $($pidData.queue)"
    Write-Host "  port      : $($pidData.port)"
}
