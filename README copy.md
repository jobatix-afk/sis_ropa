# POS Ropa — Sistema de Punto de Venta (Tienda de Ropa y Accesorios)

Base del proyecto para la **Tarea 1** de Seguridad y Auditoría de Sistemas (UMG).
Este paquete trae **solo la base sólida**: proyecto Laravel, migraciones,
modelos, seeders con datos de prueba y los "ganchos" de código para las
3 APIs externas que vas a usar (QR, Twilio, Google Fonts). El CRUD, el
POS y los reportes se agregan en las siguientes tareas (Tarea 2/3), como
pide el cronograma de la guía.

## 1. Qué trae este paquete

```
pos-ropa/
├── app/
│   ├── Models/          Usuario (User), Categoria, Producto, Cliente,
│   │                     Venta, DetalleVenta, Pago, EnvioNotificacion
│   └── Services/         QrCodeService.php   (API QR)
│                          TwilioService.php  (API Twilio)
├── config/
│   └── services.php      Credenciales de Twilio + URL base del QR
├── database/
│   ├── migrations/        8 tablas, ya listas para `php artisan migrate`
│   ├── seeders/           Usuarios, categorías, productos y clientes de prueba
│   └── sql/pos_ropa.sql   Script SQL (estructura + datos) — YA PROBADO
│                          contra MariaDB real, listo para phpMyAdmin
├── resources/views/layouts/app.blade.php   Layout base con Google Fonts + Bootstrap
├── routes/api.php         Ruta /api/health + guía comentada de próximos endpoints
├── composer.json
└── .env.example
```


## 2. Diseño de base de datos (8 tablas)

| Tabla | Relación | Para qué |
|---|---|---|
| `users` (usuarios) | 1—N con `ventas` | Login, roles `administrador` / `cajero` |
| `categorias` | 1—N con `productos` | Camisas, Pantalones, Vestidos, Chaquetas, Calzado, Accesorios |
| `productos` | N—1 `categorias`, 1—N `detalle_ventas` | Incluye `talla`, `color`, `genero` (propio de ropa) |
| `clientes` | 1—N con `ventas` | NIT por defecto `CF` (consumidor final) |
| `ventas` | N—1 `users`/`clientes`, 1—N `detalle_ventas`/`pagos`/`envios_notificacion` | `numero_factura` único, `qr_url` generado |
| `detalle_ventas` | N—1 `ventas`, N—1 `productos` | Carrito ya guardado (cantidad, precio, subtotal) |
| `pagos` | N—1 `ventas` | `referencia_api` para Stripe/PayPal/QR |
| `envios_notificacion` | N—1 `ventas` | Traza cada envío de factura por Twilio (sid, estado, error) |

Son 8 tablas (piden mínimo 7) con integridad referencial completa
(`FOREIGN KEY` con `RESTRICT`/`CASCADE`/`SET NULL` según el caso — ya
probado con inserts que rompen la relación a propósito).

`envios_notificacion` no la pide la guía tal cual, se agregó porque es
lo que necesitas para que el envío de factura por Twilio quede
documentado y auditable en la base, no solo "disparado y olvidado".

## 3. Las 3 APIs que pediste, ya con su gancho de código

1. **Código QR de factura** — `app/Services/QrCodeService.php`, usa
   `api.qrserver.com` (gratis, sin API key). `Venta.qr_url` guarda la
   URL ya generada.
2. **Envío de factura por Twilio** — `app/Services/TwilioService.php`.
   Necesita `composer require twilio/sdk` (ya está en `composer.json`)
   y las credenciales del trial gratuito de Twilio en `.env`
   (`TWILIO_SID`, `TWILIO_AUTH_TOKEN`, `TWILIO_FROM`). Cada intento de
   envío queda registrado en `envios_notificacion`.
3. **Google Fonts** — sin backend, solo el `<link>` en
   `resources/views/layouts/app.blade.php` (tipografía "Poppins").

## 4. Cómo arrancar en tu máquina
esto ya lo hice jobas, asi que no deberia de ser necesario hacerlo otra vez

```bash
composer install
cp .env.example .env
php artisan key:generate

# Configura tu base de datos en .env (MySQL/MariaDB local o del hosting)
php artisan migrate --seed

php artisan serve
```

Usuarios de prueba que crea el seeder:
- `admin@posropa.test` / `Admin123!` (rol administrador)
- `cajero@posropa.test` / `Cajero123!` (rol cajero)

## 5. Sobre el hosting (Vercel + hosting gratuito PHP)

Importante para no perder puntos en el rubro de despliegue: **Vercel no
ejecuta aplicaciones PHP/Laravel de forma nativa** (está pensado para
frontend/Node/serverless). Para Laravel + MySQL, la guía recomienda
Render.com, Railway.app o InfinityFree/000webhost — cualquiera de esos
sí corre PHP con base de datos MySQL gratuita. Si quieres usar Vercel
igual, tendría que ser solo para un frontend separado que consuma esta
API, lo cual complica el proyecto sin necesidad. Te recomiendo elegir
el hosting definitivo antes de la Tarea 2 (cuando conectas la BD real)
para no migrar credenciales dos veces.

## 6. Siguientes pasos (según el cronograma de la guía)

- **Tarea 2**: autenticación (login/logout con Sanctum, rutas
  protegidas por rol) sobre lo que ya está aquí.
- **Tarea 3**: `ProductoController` (CRUD + buscador + alerta de stock
  bajo, ya expuesto por `Producto::activos()->buscar()` y el accessor
  `stock_bajo` en el modelo) e integrar la primera API visible.
- **Tarea 4**: módulo de ventas (POS), reportes con Chart.js, despliegue
  final.

## 7. Script SQL

`database/sql/pos_ropa.sql` crea la base `pos_ropa`, las 8 tablas y
carga los mismos datos de prueba que el seeder. Se corrió contra un
MariaDB real durante la generación de este proyecto para confirmar que
no tiene errores de sintaxis ni de llaves foráneas — puedes importarlo
tal cual en phpMyAdmin/DBeaver del hosting que elijas.
