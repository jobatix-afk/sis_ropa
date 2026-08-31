-- =====================================================================
-- Sistema POS - Tienda de Ropa y Accesorios
-- UMG - Seguridad y Auditoria de Sistemas - Tarea 1
-- Script de base de datos: estructura + datos de prueba
-- Motor: MySQL 8 / MariaDB 10.x
-- Este script es equivalente a las migraciones de Laravel en
-- database/migrations/. Úsalo para importar directo en phpMyAdmin
-- del hosting, o como respaldo del script de migraciones.
-- =====================================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE DATABASE IF NOT EXISTS pos_ropa CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE pos_ropa;

-- ---------------------------------------------------------------------
-- Tabla: users (usuarios)
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(150) NOT NULL,
    `correo` VARCHAR(150) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `rol` ENUM('administrador','cajero') NOT NULL DEFAULT 'cajero',
    `remember_token` VARCHAR(100) NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `users_correo_unique` (`correo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Tabla: categorias
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `categorias`;
CREATE TABLE `categorias` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(100) NOT NULL,
    `descripcion` VARCHAR(255) NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `categorias_nombre_unique` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Tabla: productos
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `productos`;
CREATE TABLE `productos` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `codigo` VARCHAR(50) NOT NULL,
    `nombre` VARCHAR(150) NOT NULL,
    `descripcion` TEXT NULL,
    `precio` DECIMAL(10,2) NOT NULL,
    `stock` INT UNSIGNED NOT NULL DEFAULT 0,
    `categoria_id` BIGINT UNSIGNED NOT NULL,
    `talla` VARCHAR(10) NULL,
    `color` VARCHAR(40) NULL,
    `genero` ENUM('hombre','mujer','unisex','nino','nina') NULL,
    `imagen_url` VARCHAR(500) NULL,
    `activo` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `productos_codigo_unique` (`codigo`),
    KEY `productos_nombre_index` (`nombre`),
    CONSTRAINT `productos_categoria_id_foreign` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Tabla: clientes
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `clientes`;
CREATE TABLE `clientes` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(150) NOT NULL,
    `nit` VARCHAR(20) NOT NULL DEFAULT 'CF',
    `correo` VARCHAR(150) NULL,
    `telefono` VARCHAR(20) NULL,
    `direccion` VARCHAR(255) NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Tabla: ventas
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `ventas`;
CREATE TABLE `ventas` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `numero_factura` VARCHAR(30) NOT NULL,
    `usuario_id` BIGINT UNSIGNED NOT NULL,
    `cliente_id` BIGINT UNSIGNED NULL,
    `fecha` DATETIME NOT NULL,
    `subtotal` DECIMAL(10,2) NOT NULL DEFAULT 0,
    `iva` DECIMAL(10,2) NOT NULL DEFAULT 0,
    `descuento` DECIMAL(10,2) NOT NULL DEFAULT 0,
    `total` DECIMAL(10,2) NOT NULL DEFAULT 0,
    `metodo_pago` ENUM('efectivo','tarjeta','qr','transferencia') NOT NULL DEFAULT 'efectivo',
    `estado` ENUM('completada','anulada','pendiente') NOT NULL DEFAULT 'completada',
    `qr_url` VARCHAR(500) NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `ventas_numero_factura_unique` (`numero_factura`),
    KEY `ventas_fecha_index` (`fecha`),
    CONSTRAINT `ventas_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT,
    CONSTRAINT `ventas_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Tabla: detalle_ventas
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `detalle_ventas`;
CREATE TABLE `detalle_ventas` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `venta_id` BIGINT UNSIGNED NOT NULL,
    `producto_id` BIGINT UNSIGNED NOT NULL,
    `cantidad` INT UNSIGNED NOT NULL,
    `precio_unitario` DECIMAL(10,2) NOT NULL,
    `subtotal` DECIMAL(10,2) NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `detalle_ventas_venta_id_foreign` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`) ON DELETE CASCADE,
    CONSTRAINT `detalle_ventas_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Tabla: pagos
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `pagos`;
CREATE TABLE `pagos` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `venta_id` BIGINT UNSIGNED NOT NULL,
    `monto` DECIMAL(10,2) NOT NULL,
    `metodo` ENUM('efectivo','tarjeta','qr','paypal','stripe') NOT NULL DEFAULT 'efectivo',
    `referencia_api` VARCHAR(150) NULL,
    `fecha` DATETIME NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `pagos_venta_id_foreign` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Tabla: envios_notificacion (soporta la integración con Twilio)
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `envios_notificacion`;
CREATE TABLE `envios_notificacion` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `venta_id` BIGINT UNSIGNED NOT NULL,
    `canal` ENUM('sms','whatsapp') NOT NULL DEFAULT 'sms',
    `destino` VARCHAR(30) NOT NULL,
    `estado` ENUM('pendiente','enviado','fallido') NOT NULL DEFAULT 'pendiente',
    `twilio_sid` VARCHAR(60) NULL,
    `mensaje_error` VARCHAR(255) NULL,
    `fecha` DATETIME NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `envios_notificacion_venta_id_foreign` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;

-- =====================================================================
-- DATOS DE PRUEBA
-- =====================================================================

-- Usuarios (password real: Admin123! / Cajero123!, hash de ejemplo bcrypt)
INSERT INTO `users` (`nombre`, `correo`, `password`, `rol`, `created_at`, `updated_at`) VALUES
('Administrador General', 'admin@posropa.test', '$2y$12$examplehashexamplehashexamplehashexampleha', 'administrador', NOW(), NOW()),
('Cajero Uno', 'cajero@posropa.test', '$2y$12$examplehashexamplehashexamplehashexampleha', 'cajero', NOW(), NOW());

-- Categorías
INSERT INTO `categorias` (`nombre`, `descripcion`, `created_at`, `updated_at`) VALUES
('Camisas', 'Camisas y blusas para hombre y mujer', NOW(), NOW()),
('Pantalones', 'Jeans, pantalones de vestir y casuales', NOW(), NOW()),
('Vestidos', 'Vestidos casuales y formales', NOW(), NOW()),
('Chaquetas', 'Chumpas, chaquetas y abrigos', NOW(), NOW()),
('Calzado', 'Zapatos, tenis y sandalias', NOW(), NOW()),
('Accesorios', 'Cinturones, gorras, bolsos y bisutería', NOW(), NOW());

-- Productos
INSERT INTO `productos` (`codigo`, `nombre`, `descripcion`, `precio`, `stock`, `categoria_id`, `talla`, `color`, `genero`, `activo`, `created_at`, `updated_at`) VALUES
('CAM-001', 'Camisa Oxford Manga Larga', 'Camisa Oxford Manga Larga - Camisas', 149.99, 20, 1, 'M', 'Celeste', 'hombre', 1, NOW(), NOW()),
('CAM-002', 'Blusa Casual Estampada', 'Blusa Casual Estampada - Camisas', 129.50, 15, 1, 'S', 'Blanco', 'mujer', 1, NOW(), NOW()),
('PAN-001', 'Jean Slim Fit', 'Jean Slim Fit - Pantalones', 219.00, 12, 2, '32', 'Azul', 'hombre', 1, NOW(), NOW()),
('PAN-002', 'Pantalón de Vestir', 'Pantalón de Vestir - Pantalones', 249.00, 4, 2, '34', 'Negro', 'hombre', 1, NOW(), NOW()),
('VES-001', 'Vestido Casual Floral', 'Vestido Casual Floral - Vestidos', 279.99, 8, 3, 'M', 'Rosado', 'mujer', 1, NOW(), NOW()),
('CHA-001', 'Chumpa Impermeable', 'Chumpa Impermeable - Chaquetas', 349.00, 3, 4, 'L', 'Negro', 'unisex', 1, NOW(), NOW()),
('CAL-001', 'Tenis Urbano', 'Tenis Urbano - Calzado', 399.00, 10, 5, '9', 'Blanco', 'unisex', 1, NOW(), NOW()),
('ACC-001', 'Cinturón de Cuero', 'Cinturón de Cuero - Accesorios', 89.00, 25, 6, 'Único', 'Café', 'unisex', 1, NOW(), NOW()),
('ACC-002', 'Gorra Bordada', 'Gorra Bordada - Accesorios', 65.00, 2, 6, 'Único', 'Gris', 'unisex', 1, NOW(), NOW());

-- Clientes
INSERT INTO `clientes` (`nombre`, `nit`, `correo`, `telefono`, `direccion`, `created_at`, `updated_at`) VALUES
('Consumidor Final', 'CF', NULL, NULL, NULL, NOW(), NOW()),
('María López', '1234567-8', 'maria.lopez@example.com', '50212345678', 'Zona 10, Ciudad de Guatemala', NOW(), NOW());

-- Venta de ejemplo (cajero id=2 vende a María López id=2)
INSERT INTO `ventas` (`numero_factura`, `usuario_id`, `cliente_id`, `fecha`, `subtotal`, `iva`, `descuento`, `total`, `metodo_pago`, `estado`, `qr_url`, `created_at`, `updated_at`) VALUES
('FAC-0001', 2, 2, NOW(), 279.99, 33.60, 0, 313.59, 'tarjeta', 'completada', 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=FAC-0001', NOW(), NOW());

-- Detalle de la venta de ejemplo (1 vestido)
INSERT INTO `detalle_ventas` (`venta_id`, `producto_id`, `cantidad`, `precio_unitario`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 5, 1, 279.99, 279.99, NOW(), NOW());

-- Pago de la venta de ejemplo
INSERT INTO `pagos` (`venta_id`, `monto`, `metodo`, `referencia_api`, `fecha`, `created_at`, `updated_at`) VALUES
(1, 313.59, 'tarjeta', 'stripe_ch_ejemplo123', NOW(), NOW(), NOW());

-- Envío de factura de ejemplo (Twilio)
INSERT INTO `envios_notificacion` (`venta_id`, `canal`, `destino`, `estado`, `twilio_sid`, `fecha`, `created_at`, `updated_at`) VALUES
(1, 'sms', '50212345678', 'enviado', 'SMxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx', NOW(), NOW(), NOW());
