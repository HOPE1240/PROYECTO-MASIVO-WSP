# 📢 Sistema de Envío Masivo de Mensajes por WhatsApp

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

---

## 🔖 Descripción General

Este proyecto es un **sistema de gestión y envío masivo de mensajes por WhatsApp**, desarrollado como una herramienta de comunicación interna o externa para organizaciones que necesitan notificar a muchos clientes o usuarios al mismo tiempo.

Combina **Laravel** (backend en PHP) con **Venom Bot** (cliente de WhatsApp en Node.js) para proporcionar una solución robusta, automatizada y flexible.

![diagrama](https://github.com/user-attachments/assets/49480ed8-4f76-46f7-8d25-b176832a4e5c)


## ✅ Objetivo del Proyecto

Automatizar y facilitar el proceso de comunicación con clientes o usuarios a través de WhatsApp, garantizando:

* Mensajes personalizados mediante variables dinámicas.
* Control y autorización de envío desde distintas áreas.
* Registro detallado de cada envío en la base de datos.
* Independencia entre el backend y el cliente de WhatsApp (acoplados vía API).

## 🌐 Tecnologías Utilizadas

| Tecnología      | Propósito                                                  |
| --------------- | ---------------------------------------------------------- |
| **Laravel**     | Framework PHP para la API REST.                            |
| **MySQL**       | Base de datos para almacenar la información.               |
| **Venom Bot**   | Cliente de WhatsApp para automatizar el envío de mensajes. |
| **Node.js**     | Motor de ejecución para Venom Bot.                         |
| **HTTP Client** | Comunicación entre Laravel y Venom.                        |
| **Postman**     | Pruebas y validación de la API.                            |

## 📊 Estructura de la Base de Datos

### 🧾 Tabla `mensajes_masivos`

* `id`
* `titulo`
* `contenido`
* `area_id`
* `variables`
* `ruta_imagen`
* `estado`
* `created_at`, `updated_at`

### 👥 Tabla `clientes`

* `id`
* `nombre`
* `telefono`
* `created_at`, `updated_at`

### 🏢 Tabla `areas`

* `id`
* `nombre`
* `created_at`, `updated_at`

### 🧾 Tabla `logs_envios_masivos`

* `id`
* `mensaje_masivo_id`
* `cliente_id`
* `mensaje_final`
* `estado`
* `created_at`, `updated_at`

## 🛠️ Instalación y Configuración

### Backend (Laravel)

```bash
git clone https://github.com/HOPE1240/PROYECTO-MASIVO-WSP.git
cd whatsapp-masivo/laravel-backend
composer install
cp .env.example .env
php artisan key:generate
```

Editar `.env`:

```env
DB_DATABASE=whatsapp
DB_USERNAME=root
DB_PASSWORD=
VENOM_URL=http://localhost:3000/send-message
```

```bash
php artisan migrate
php artisan serve
```

### Cliente WhatsApp (Venom Bot)

```bash
cd whatsapp-masivo/venom-bot
npm install
node index.js
```

Escanea el QR con tu teléfono. Venom iniciará la sesión de WhatsApp.

## 📥 API del Backend Laravel

### Crear mensaje masivo

`POST /mensajes/crear`

```json
{
  "titulo": "Recordatorio",
  "contenido": "Hola {{nombre}}, tu cita es el {{fecha}}.",
  "area_id": 1,
  "variables": { "nombre": "Carlos", "fecha": "10 de mayo" },
  "ruta_imagen": "https://example.com/img.jpg"
}
```

### Modificar mensaje

`PUT /mensajes/{id}/modificar`

```json
{
  "titulo": "Nuevo recordatorio",
  "contenido": "Hola {{nombre}}, reprogramamos para el {{fecha}}.",
  "variables": { "nombre": "Ana", "fecha": "12 de mayo" },
  "ruta_imagen": null
}
```

### Enviar mensaje masivo

`POST /mensajes/{id}/enviar`

```json
{
  "message": "Mensajes generados y enviados"
}
```

## 📤 API de Venom Bot (Node.js)

Ruta: `http://localhost:3000/send-message`

```json
{
  "numero": "573001112233",
  "mensaje": "Hola Carlos, tu cita es el 10 de mayo."
}
```

Respuesta esperada:

```json
{
  "status": "success",
  "message": "Mensaje enviado"
}
```

## 🔁 Flujo de Envío de Mensajes

1. Usuario crea el mensaje desde Laravel.
2. Se valida contenido y variables.
3. El sistema reemplaza las variables por datos de cada cliente.
4. Envía individualmente a través de Venom Bot.
5. Guarda logs con resultados de cada envío.

## ⚠️ Posibles Errores y Cómo Evitarlos

* ❌ No tener Venom activo → ✅ Ejecutar `node index.js` y escanear el QR.
* ❌ No declarar variables en contenido → ✅ Usar `{{variable}}`.
* ❌ Teléfonos sin código país → ✅ Usar formato internacional (ej. `573001112233`).
* ❌ No coincidir `area_id` válido → ✅ Validar contra la tabla `areas`.

## 🧩 Complemento entre Laravel y Venom

Laravel maneja la lógica, validaciones, clientes y mensajes. Venom ejecuta el envío real mediante una sesión activa de WhatsApp Web, totalmente desacoplada. Laravel actúa como "cerebro", y Venom como "brazo ejecutor".

## 📚 Futuras Mejoras

* Panel gráfico para usuarios no técnicos.
* Soporte para plantillas predefinidas.
* Indicador visual de entrega / lectura.
* Gestión de contactos directamente desde interfaz.

---

*Desarrollado con ❤️ usando Laravel y Venom Bot para potenciar la comunicación automatizada vía WhatsApp.*
