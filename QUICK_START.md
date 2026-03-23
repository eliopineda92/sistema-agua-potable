# Quick Start Guide - Sistema de Agua Potable

## 🚀 Inicio Rápido

El sistema está completamente funcional y corriendo en Docker.

### URLs de Acceso

- **Aplicación Principal**: http://localhost:8000
- **PHPMyAdmin**: http://localhost:8080

### Credenciales Predeterminadas

#### Admin (Personal Administrativo)
- **Email**: eliopinedacog@gmail.com
- **Contraseña**: password123
- **Acceso**: Dashboard, gestión completa del sistema

#### Cliente (Ejemplo)
- **Email**: cliente@example.com
- **Contraseña**: password123
- **Acceso**: Portal cliente (ver cobros pendientes y pagos)

---

## 📋 Funcionalidades Disponibles

### 1. Dashboard
- Resumen de cobros pagados y pendientes
- Total de clientes activos
- Clientes en mora
- Gráficos de cobros del mes

### 2. Gestión de Clientes
- Crear/editar/eliminar clientes
- Asociar medidores a clientes
- Ver estado del cliente (activo/suspendido)

### 3. Gestión de Medidores
- Registrar medidores de agua
- Asignar ubicación y cuota mensual
- Cambiar estado (activo/inactivo/suspendido)

### 4. Lecturas Mensuales
- Registrar lectura anterior y actual
- Cálculo automático de consumo
- Generación automática de cobro
- Sistema de tarifa progresiva

### 5. Cobros y Pagos
- Ver todos los cobros (pendientes/vencidos/pagados)
- Registrar pagos manuales
- Calcular mora automáticamente
- Descargar comprobantes en PDF

### 6. Reportes
- **Recaudación**: Ingresos por período
- **Mora**: Clientes con pagos vencidos
- **Ingresos**: Gráfico anual de ingresos

### 7. Portal Cliente
- Consultar cobros pendientes
- Ver historial de pagos
- Descargar comprobantes

### 8. Gestión de Usuarios (Admin Only)
- Crear personal administrativo
- Asignar roles (Admin, Cajero, Supervisor)

### 9. Gestión de Roles (Admin Only)
- Crear/editar roles personalizados
- Asignar permisos granulares

---

## 🔑 Roles y Permisos

### Admin
- Acceso total al sistema
- Gestionar usuarios y roles
- Ver todos los reportes

### Cajero
- Ver y crear cobros
- Registrar pagos
- Ver clientes y medidores

### Supervisor
- Ver clientes y cobros
- Crear clientes
- Ver reportes

### Cliente
- Ver solo sus cobros
- Consultar deudas
- Acceso al portal

---

## 🐳 Comandos Docker

### Ver logs de la aplicación
```bash
docker logs agua_app -f
```

### Acceder a terminal Laravel
```bash
docker exec -it agua_app bash
```

### Ejecutar comando artisan
```bash
docker exec agua_app php artisan <comando>
```

### Reiniciar contenedores
```bash
docker compose restart
```

### Detener sistema
```bash
docker compose down
```

### Reiniciar completamente
```bash
docker compose down
docker compose up -d
```

---

## 📱 Flujo de Uso Típico

### 1. Registrar Nuevo Cliente
1. Ir a **Clientes** → **Crear Cliente**
2. Llenar datos: Nombre, Dirección, Número de Medidor, Cuota Mensual
3. Guardar

### 2. Crear/Editar Medidor
1. Ir a **Medidores** → **Crear Medidor**
2. Seleccionar cliente
3. Ingresar número de medidor, ubicación, cuota mensual
4. Guardar

### 3. Registrar Lectura Mensual
1. Ir a **Lecturas** → **Crear Lectura**
2. Seleccionar medidor
3. Ingresar lectura anterior y actual
4. Ingresar fecha de lectura
5. El sistema calcula:
   - Metros consumidos
   - Monto a cobrar
   - **Crea automáticamente el cobro**

### 4. Procesar Pago
1. Ir a **Cobros**
2. Filtrar por estado "pendiente"
3. Click en cobro → **Pagar**
4. Ingresar monto y método de pago
5. Confirmar

### 5. Consultar como Cliente
1. Cerrar sesión admin
2. Ir a **Cliente Login**
3. Ingresar credenciales cliente
4. Ver cobros pendientes y pagos realizados

---

## 🔍 Características Especiales

### Cálculo de Tarifa Progresiva
```
Primeros 5 m³: $10.00 fijos
Cada m³ adicional: $0.75
```

### Generación Automática de Cobros
Al registrar una lectura, el sistema automáticamente:
- Calcula el consumo
- Aplica la tarifa
- **Crea el cobro en estado "pendiente"**
- Establece fecha de vencimiento (15 días)

### Descarga de Comprobantes
- Los clientes pueden descargar PDF de sus pagos
- PDF contiene: monto, fecha, referencia

### Control de Mora
- Cobros vencidos automáticamente cambian a estado "vencido"
- Se puede aplicar mora manual
- Reporte de clientes en mora

---

## ⚙️ Configuración

### Variables de Entorno (.env)
```
APP_NAME="Sistema Agua Potable"
APP_ENV=local
DB_HOST=mysql
DB_DATABASE=agua_potable
DB_USERNAME=root
DB_PASSWORD=secret
```

### Base de Datos
- **Host**: localhost:3306
- **Base de Datos**: agua_potable
- **Usuario**: root
- **Contraseña**: secret

---

## 🆘 Solución de Problemas

### No puedo acceder a localhost:8000
- Verifica que los contenedores estén corriendo: `docker ps`
- Reinicia: `docker compose restart agua_app`

### Error en la base de datos
- Verifica conexión: `docker logs agua_mysql`
- Comprueba que la BD exista en PHPMyAdmin

### Sesión expirada
- Las sesiones se guardan en BD
- Si borras BD, se pierden sesiones: `docker compose down -v`

### Error "SQLSTATE[HY000]"
- Espera a que MySQL inicie completamente
- Reinicia todo: `docker compose down && docker compose up -d`

---

## 📞 Soporte

- Para más información sobre Laravel: https://laravel.com/docs
- Para dudas sobre Docker: https://docs.docker.com
- Para reportar bugs, revisa los logs: `docker logs agua_app`

---

## ✨ ¡Sistema Listo para Usar!

Tu aplicación está completamente funcional.

**Accede ahora**: http://localhost:8000 🚀
