param(
    [int]$Port = 8000,
    [int]$VitePort = 5173
)

$ErrorActionPreference = "Stop"

$root = Split-Path $MyInvocation.MyCommand.Path -Parent
Set-Location $root

$pidFile = ".dev-pids.json"
$ids = @()

if (Test-Path $pidFile) {
    try {
        $p = Get-Content $pidFile | ConvertFrom-Json
        if ($p.server) { $ids += [int]$p.server }
        if ($p.vite)   { $ids += [int]$p.vite }
        if ($p.queue)  { $ids += [int]$p.queue }
        if ($p.port)   { $Port = [int]$p.port }
    } catch {
        Write-Warning "Could not parse $pidFile. Falling back to port-based detection."
    }
}

# Fallback: find processes by listening ports (server + Vite)
try {
    $serverPids = Get-NetTCPConnection -LocalPort $Port -State Listen -ErrorAction SilentlyContinue | Select-Object -ExpandProperty OwningProcess
    if ($serverPids) { $ids += $serverPids }
} catch {}

try {
    $vitePids = Get-NetTCPConnection -LocalPort $VitePort -State Listen -ErrorAction SilentlyContinue | Select-Object -ExpandProperty OwningProcess
    if ($vitePids) { $ids += $vitePids }
} catch {}

$ids = $ids | Where-Object { $_ } | Select-Object -Unique

if (-not $ids -or $ids.Count -eq 0) {
    Write-Host "No matching processes found to stop." -ForegroundColor Yellow
} else {
    foreach ($id in $ids) {
        try {
            Stop-Process -Id $id -Force -ErrorAction SilentlyContinue
            Write-Host "Stopped PID $id" -ForegroundColor Green
        } catch {
            Write-Warning "Failed to stop PID $id: $($_.Exception.Message)"
        }
    }
}

if (Test-Path $pidFile) {
    Remove-Item $pidFile -Force -ErrorAction SilentlyContinue
}

Write-Host "Done." -ForegroundColor Cyan
