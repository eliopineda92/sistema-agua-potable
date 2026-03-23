#!/bin/bash
# Script para hacer commit de los cambios del Sistema de Agua Potable

echo "========================================"
echo "Commit Automático - Sistema Agua Potable"
echo "========================================"
echo ""

# Verificar si git está disponible
if ! command -v git &> /dev/null; then
    echo "❌ Error: Git no está instalado"
    echo "Instala Git desde: https://git-scm.com/download"
    exit 1
fi

echo "✅ Git encontrado"
echo ""

# Ir al directorio del proyecto
PROJECT_PATH=$(pwd)
echo "📁 Directorio: $PROJECT_PATH"
echo ""

# Verificar si es un repositorio git
if [ ! -d ".git" ]; then
    echo "❌ Error: Este no es un repositorio git válido"
    echo "Ejecuta: git init"
    exit 1
fi

# Mostrar estado
echo "📊 Estado del repositorio:"
git status
echo ""

# Preguntar confirmación
read -p "¿Deseas continuar con el commit? (s/n): " confirm

if [ "$confirm" != "s" ] && [ "$confirm" != "S" ] && [ "$confirm" != "y" ] && [ "$confirm" != "Y" ]; then
    echo "❌ Operación cancelada"
    exit 0
fi

echo ""
echo "🔧 Configurando git..."

# Configurar git (local)
git config user.email "gordon@docker.io"
git config user.name "Gordon Docker Assistant"

echo "✅ Configuración completada"
echo ""

# Agregar archivos
echo "📝 Agregando archivos..."
git add .

echo "✅ Archivos agregados"
echo ""

# Crear el commit
echo "💾 Creando commit..."

git commit -m "Completar sistema agua potable: vistas medidores, Docker optimizado, documentación y seeders

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

Assisted-By: Gordon Docker Assistant"

if [ $? -eq 0 ]; then
    echo "✅ Commit creado exitosamente"
    echo ""
    echo "📈 Últimos commits:"
    git log --oneline -5
    echo ""
    echo "🚀 Próximo paso: git push origin main"
else
    echo "❌ Error al crear el commit"
    exit 1
fi

echo ""
echo "========================================"
read -p "¿Deseas hacer push a GitHub ahora? (s/n): " pushConfirm
echo "========================================"

if [ "$pushConfirm" = "s" ] || [ "$pushConfirm" = "S" ] || [ "$pushConfirm" = "y" ] || [ "$pushConfirm" = "Y" ]; then
    echo ""
    echo "📤 Haciendo push..."
    git push origin main
    
    if [ $? -eq 0 ]; then
        echo "✅ Push completado exitosamente"
        echo ""
        echo "🎉 ¡Cambios subidos a GitHub!"
        echo "Repositorio: https://github.com/eliopineda92/sistema-agua-potable"
    else
        echo "⚠️  Error al hacer push"
        echo "Intenta manualmente: git push origin main"
    fi
else
    echo "⏸️  Push omitido. Puedes hacer push después manualmente:"
    echo "git push origin main"
fi

echo ""
echo "========================================"
echo "✅ ¡Proceso completado!"
echo "========================================"
