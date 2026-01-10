<?php
/**
 * Configuración de correo electrónico
 * 
 * INSTRUCCIONES:
 * 1. Renombra este archivo a 'email_config.php' si no lo está
 * 2. Completa los datos según tu proveedor de correo
 * 
 * PARA GMAIL:
 * - Debes crear una "Contraseña de aplicación" en tu cuenta de Google
 * - Ve a: https://myaccount.google.com/apppasswords
 * - Genera una contraseña específica para esta aplicación
 * 
 * PARA OTROS PROVEEDORES:
 * - Outlook/Hotmail: smtp.office365.com, puerto 587
 * - Yahoo: smtp.mail.yahoo.com, puerto 587
 * - Otros: Consulta la documentación de tu proveedor
 */

return [
    // Configuración del servidor SMTP
    'smtp_host' => 'smtp.gmail.com',  // Servidor SMTP
    'smtp_port' => 587,                // Puerto (587 para TLS, 465 para SSL)
    'smtp_secure' => 'tls',            // 'tls' o 'ssl'

    // Credenciales de autenticación
    'smtp_username' => 'tu_email@gmail.com',  // Tu correo electrónico
    'smtp_password' => 'tu_contraseña_app',   // Tu contraseña de aplicación

    // Información del remitente
    'from_email' => 'tu_email@gmail.com',     // Email del remitente
    'from_name' => 'Tu Empresa',              // Nombre del remitente

    // Configuración adicional
    'charset' => 'UTF-8',
    'debug' => false,  // Cambiar a true para ver mensajes de depuración
];
