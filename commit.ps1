#!/usr/bin/env pwsh
# Script para hacer commit de los cambios del Sistema de Agua Potable

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "Commit Automático - Sistema Agua Potable" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Verificar si git está disponible
$gitExists = $null -ne (Get-Command git -ErrorAction SilentlyContinue)

if (-not $gitExists) {
    Write-Host "❌ Error: Git no está instalado o no está en PATH" -ForegroundColor Red
    Write-Host "Instala Git desde: https://git-scm.com/download/win" -ForegroundColor Yellow
    exit 1
}

Write-Host "✅ Git encontrado" -ForegroundColor Green
Write-Host ""

# Ir al directorio del proyecto
$projectPath = Get-Location
Write-Host "📁 Directorio: $projectPath" -ForegroundColor Cyan
Write-Host ""

# Verificar si es un repositorio git
if (-not (Test-Path ".git")) {
    Write-Host "❌ Error: Este no es un repositorio git válido" -ForegroundColor Red
    Write-Host "Ejecuta: git init" -ForegroundColor Yellow
    exit 1
}

# Mostrar estado
Write-Host "📊 Estado del repositorio:" -ForegroundColor Cyan
git status
Write-Host ""

# Preguntar confirmación
Write-Host "¿Deseas continuar con el commit? (s/n)" -ForegroundColor Yellow
$confirm = Read-Host

if ($confirm -ne "s" -and $confirm -ne "S" -and $confirm -ne "y" -and $confirm -ne "Y") {
    Write-Host "❌ Operación cancelada" -ForegroundColor Red
    exit 0
}

Write-Host ""
Write-Host "🔧 Configurando git..." -ForegroundColor Cyan

# Configurar git (local)
git config user.email "gordon@docker.io"
git config user.name "Gordon Docker Assistant"

Write-Host "✅ Configuración completada" -ForegroundColor Green
Write-Host ""

# Agregar archivos
Write-Host "📝 Agregando archivos..." -ForegroundColor Cyan
git add .

Write-Host "✅ Archivos agregados" -ForegroundColor Green
Write-Host ""

# Crear el commit
Write-Host "💾 Creando commit..." -ForegroundColor Cyan

$commitMessage = @"
Completar sistema agua potable: vistas medidores, Docker optimizado, documentación y seeders

- Crear vistas CRUD para gestión de medidores (index, create, edit)
- Crear scripts de inicialización Docker con migraciones automáticas
- Optimizar Dockerfile para producción con PHP 8.3 y Apache
- Mejorar documentación con guía rápida y technical summary
- Agregar relación Cobro-Lectura en modelo
- Configurar .env con variables de entorno
- Crear .dockerignore para optimizar build
- Completar seeders de roles y permisos
- Crear nueva migración para columnas faltantes en medidores

Cambios incluidos:
✅ 3 vistas Blade nuevas (medidores CRUD)
✅ Dockerfile optimizado
✅ entrypoint.sh para automatización
✅ 2 archivos de documentación
✅ 1 nueva migración
✅ Modelos actualizados

Assisted-By: Gordon Docker Assistant"@

git commit -m $commitMessage

if ($LASTEXITCODE -eq 0) {
    Write-Host "✅ Commit creado exitosamente" -ForegroundColor Green
    Write-Host ""
    Write-Host "📈 Últimos commits:" -ForegroundColor Cyan
    git log --oneline -5
    Write-Host ""
    Write-Host "🚀 Próximo paso: git push origin main" -ForegroundColor Yellow
} else {
    Write-Host "❌ Error al crear el commit" -ForegroundColor Red
    exit 1
}

Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "¿Deseas hacer push a GitHub ahora? (s/n)" -ForegroundColor Yellow
Write-Host "========================================" -ForegroundColor Cyan

$pushConfirm = Read-Host

if ($pushConfirm -eq "s" -or $pushConfirm -eq "S" -or $pushConfirm -eq "y" -or $pushConfirm -eq "Y") {
    Write-Host ""
    Write-Host "📤 Haciendo push..." -ForegroundColor Cyan
    git push origin main
    
    if ($LASTEXITCODE -eq 0) {
        Write-Host "✅ Push completado exitosamente" -ForegroundColor Green
        Write-Host ""
        Write-Host "🎉 ¡Cambios subidos a GitHub!" -ForegroundColor Cyan
        Write-Host "Repositorio: https://github.com/eliopineda92/sistema-agua-potable" -ForegroundColor Yellow
    } else {
        Write-Host "⚠️  Error al hacer push" -ForegroundColor Yellow
        Write-Host "Intenta manualmente: git push origin main" -ForegroundColor Yellow
    }
} else {
    Write-Host "⏸️  Push omitido. Puedes hacer push después manualmente:" -ForegroundColor Yellow
    Write-Host "git push origin main" -ForegroundColor Cyan
}

Write-Host ""
Write-Host "========================================" -ForegroundColor Green
Write-Host "✅ ¡Proceso completado!" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Green
