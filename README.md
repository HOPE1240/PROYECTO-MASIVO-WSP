# 📢 Sistema de Envío Masivo de Mensajes por WhatsApp

## 🔖 Descripción General

Este proyecto es un **sistema de gestión y envío masivo de mensajes por WhatsApp**, desarrollado como una herramienta de comunicación interna o externa para organizaciones que necesitan notificar a muchos clientes o usuarios al mismo tiempo. El sistema está diseñado para permitir la personalización de mensajes, controlar qué área los envía y registrar todos los envíos para seguimiento y auditoría.

## ✅ Objetivo del Proyecto

El objetivo principal es automatizar y facilitar el proceso de comunicación con clientes o usuarios a través de WhatsApp, garantizando:

* Mensajes personalizados por cliente mediante variables.
* Control de mensajes por área funcional (ej. Soporte, Finanzas, RRHH).
* Registro de logs detallados por cada envío (cliente, contenido, estado).
* Integración simple con una API de WhatsApp (Venom Bot).

## 🌐 Tecnologías Utilizadas

| Tecnología      | Propósito                                                      |
| --------------- | -------------------------------------------------------------- |
| **Laravel**     | Framework PHP para la construcción de la API REST.             |
| **MySQL**       | Base de datos para almacenar mensajes, áreas, clientes y logs. |
| **Venom Bot**   | Cliente de WhatsApp que se conecta a través de Node.js.        |
| **HTTP Client** | Para enviar peticiones desde Laravel a Venom Bot.              |
| **Postman**     | Herramienta recomendada para probar los endpoints.             |

## 📊 Estructura de la Base de Datos

### ✉️ Tabla `mensajes_masivos`

* `id`
* `titulo`
* `contenido`
* `area_id` (FK a tabla `areas`)
* `variables` (json)
* `ruta_imagen`
* `estado` (borrador / enviado)
* `created_at`, `updated_at`

### 👥 Tabla `clientes`

* `id`
* `nombre`
* `telefono`
* `created_at`, `updated_at`

### ⚖️ Tabla `areas`

* `id`
* `nombre`
* `created_at`, `updated_at`

### ✏️ Tabla `logs_envios_masivos`

* `id`
* `mensaje_masivo_id` (FK a mensajes)
* `cliente_id` (FK a clientes)
* `mensaje_final`
* `estado` (pendiente / enviado / error)
* `created_at`, `updated_at`

## 🛠️ Instalación del Backend (Laravel)

1. Clonar el repositorio:

```bash
git clone https://github.com/tu-usuario/whatsapp-masivo.git
```

2. Instalar dependencias:

```bash
cd whatsapp-masivo/laravel-backend
composer install
```

3. Configurar el archivo `.env` con tu base de datos y URL de Venom:

```env
DB_DATABASE=whatsapp
DB_USERNAME=root
DB_PASSWORD=
VENOM_URL=http://localhost:3000/send-message
```

4. Ejecutar migraciones:

```bash
php artisan migrate
```

5. Iniciar el servidor:

```bash
php artisan serve
```

## 🌐 API REST: Endpoints Disponibles

### 1. Crear mensaje masivo

`POST /mensajes/crear`

**Request JSON:**

```json
{
  "titulo": "Recordatorio de Reunión",
  "contenido": "Hola {{nombre}}, recuerda que tu reunión es el {{fecha}}.",
  "area_id": 1,
  "variables": {
    "nombre": "Carlos",
    "fecha": "10 de mayo"
  },
  "ruta_imagen": "https://example.com/imagen.jpg"
}
```

**Respuesta:** 201 Created

```json
{
  "message": "Mensaje masivo creado con éxito",
  "mensaje": { ...datos del mensaje... }
}
```

### 2. Modificar mensaje masivo

`PUT /mensajes/{id}/modificar`

**Request JSON:**

```json
{
  "titulo": "Cambio de fecha",
  "contenido": "Hola {{nombre}}, tu reunión fue reprogramada para {{fecha}}.",
  "variables": {
    "nombre": "Carlos",
    "fecha": "12 de mayo"
  },
  "ruta_imagen": null
}
```

### 3. Enviar mensaje masivo

`POST /mensajes/{id}/enviar`

Este endpoint recorre la lista de clientes, reemplaza las variables y envía el mensaje usando Venom Bot.

**Respuesta:**

```json
{
  "message": "Mensajes generados y enviados"
}
```

## 🔄 Lógica de Envío (Backend Laravel)

* Recupera el mensaje y sus variables.
* Recorre todos los clientes.
* Reemplaza las variables del mensaje con datos del cliente.
* Envía el mensaje personalizado usando una petición HTTP a Venom Bot.
* Guarda un log por cada cliente.

## 🤖 Cliente WhatsApp con Venom Bot (Node.js)

### 📁 Estructura del Directori)

### 📁

```
```

### 📦 Instalación y Configuración

1. Entrar a la carpeta:

```bash
cd whatsapp-masivo/venom-bot
```

2. Instalar dependencias:

```bash
npm install
```

3. Ejecutar el bot:

```bash
node index.js
```

En la primera ejecución, escanear el QR que aparece para iniciar sesión en WhatsApp.

### 📥 Endpoint HTTP del Bot

El bot escucha en `http://localhost:3000/send-message` y espera un JSON:

```json
{
  "numero": "573001112233",
  "mensaje": "Hola Carlos, recuerda que tu reunión es el 10 de mayo."
}
```

**Respuesta esperada:**

```json
{
  "status": "success",
  "message": "Mensaje enviado"
}
```

## ⚠️ Consideraciones

* Los mensajes solo se pueden modificar antes de ser enviados.
* Las variables deben estar declaradas dentro del contenido con el formato `{{nombre_variable}}`.
* Venom debe tener una sesión activa en el dispositivo móvil conectado.

## 📚 Futuras Mejoras

* Panel administrativo para gestión visual de mensajes, áreas y envíos.
* Visualización de logs por cliente y estado de entrega.
* Soporte para adjuntar archivos o botones.
* Notificaciones de errores de envío.

---

*Desarrollado con Laravel y Venom Bot para una comunicación efectiva y automatizada por WhatsApp.*


Desarrollado con Laravel y Venom Bot para una comunicación efectiva y automatizada por WhatsApp.


