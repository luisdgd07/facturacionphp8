# 📧 Sistema de Envío de Facturas por Correo Electrónico

## 📋 Descripción

Este sistema permite enviar facturas electrónicas generadas en PDF directamente por correo electrónico a tus clientes.

## 🚀 Archivos Creados

1. **`enviar_factura.php`** - Script principal que genera el PDF y envía el correo
2. **`email_config.php`** - Archivo de configuración para credenciales de correo
3. **`test_enviar_factura.html`** - Interfaz de prueba para enviar facturas

## ⚙️ Configuración

### Paso 1: Configurar las credenciales de correo

Edita el archivo `email_config.php` y completa los siguientes datos:

```php
return [
    'smtp_host' => 'smtp.gmail.com',  // Tu servidor SMTP
    'smtp_port' => 587,                // Puerto (587 para TLS)
    'smtp_secure' => 'tls',            // 'tls' o 'ssl'
    'smtp_username' => 'tu_email@gmail.com',  // Tu correo
    'smtp_password' => 'tu_contraseña_app',   // Tu contraseña de aplicación
    'from_email' => 'tu_email@gmail.com',     // Email del remitente
    'from_name' => 'Tu Empresa',              // Nombre del remitente
];
```

### Paso 2: Configurar Gmail (si usas Gmail)

Si usas Gmail, necesitas crear una **Contraseña de Aplicación**:

1. Ve a tu cuenta de Google: https://myaccount.google.com/
2. Selecciona "Seguridad"
3. En "Acceso a Google", selecciona "Verificación en dos pasos" (debes activarla si no la tienes)
4. Al final de la página, selecciona "Contraseñas de aplicaciones"
5. Selecciona "Correo" y "Otro (nombre personalizado)"
6. Escribe "Sistema de Facturación" y genera la contraseña
7. Copia la contraseña de 16 caracteres y pégala en `email_config.php`

### Paso 3: Configuración para otros proveedores

#### Outlook/Hotmail

```php
'smtp_host' => 'smtp.office365.com',
'smtp_port' => 587,
'smtp_secure' => 'tls',
```

#### Yahoo

```php
'smtp_host' => 'smtp.mail.yahoo.com',
'smtp_port' => 587,
'smtp_secure' => 'tls',
```

## 🎯 Uso

### Opción 1: Usar la interfaz de prueba

1. Abre en tu navegador: `http://localhost/facturacionfe/kudes/test_enviar_factura.html`
2. Ingresa el ID de la venta
3. Ingresa el correo electrónico del destinatario
4. Haz clic en "Enviar Factura"

### Opción 2: Llamar directamente al script

```
http://localhost/facturacionfe/kudes/enviar_factura.php?venta=123&email=cliente@ejemplo.com
```

### Opción 3: Integrar en tu sistema

Puedes agregar un botón en tu sistema de ventas:

```html
<button
  onclick="enviarFactura(<?php echo $venta->id_venta; ?>, '<?php echo $cliente->email; ?>')"
>
  📧 Enviar por Correo
</button>

<script>
  function enviarFactura(ventaId, email) {
    if (confirm("¿Enviar factura a " + email + "?")) {
      fetch(
        `kudes/enviar_factura.php?venta=${ventaId}&email=${encodeURIComponent(
          email
        )}`
      )
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            alert("✅ " + data.message);
          } else {
            alert("❌ " + data.message);
          }
        })
        .catch((error) => {
          alert("❌ Error: " + error.message);
        });
    }
  }
</script>
```

## 🔍 Solución de Problemas

### Error: "SMTP connect() failed"

**Causa:** No se puede conectar al servidor SMTP.

**Solución:**

1. Verifica que el host y puerto sean correctos
2. Verifica tu conexión a internet
3. Verifica que tu firewall no bloquee el puerto 587

### Error: "Invalid address"

**Causa:** El correo electrónico no es válido.

**Solución:**

1. Verifica que el correo esté bien escrito
2. Asegúrate de que el cliente tenga un correo registrado

### Error: "Authentication failed"

**Causa:** Usuario o contraseña incorrectos.

**Solución:**

1. Verifica que el usuario y contraseña sean correctos
2. Si usas Gmail, asegúrate de usar una contraseña de aplicación
3. Verifica que la verificación en dos pasos esté activada (Gmail)

### Habilitar modo debug

Para ver más detalles de los errores, edita `email_config.php`:

```php
'debug' => true,  // Cambiar a true para ver mensajes de depuración
```

## 📝 Respuesta del Script

El script devuelve una respuesta JSON:

### Éxito

```json
{
  "success": true,
  "message": "Factura enviada exitosamente a cliente@ejemplo.com"
}
```

### Error

```json
{
  "success": false,
  "message": "Error al enviar el correo: [detalles del error]"
}
```

## 🔒 Seguridad

⚠️ **IMPORTANTE:**

1. **NUNCA** subas el archivo `email_config.php` a un repositorio público
2. Agrega `email_config.php` a tu `.gitignore`:
   ```
   kudes/email_config.php
   ```
3. Mantén tus credenciales seguras
4. Usa contraseñas de aplicación en lugar de tu contraseña principal

## 📧 Contenido del Correo

El correo enviado incluye:

- **Asunto:** "Factura Electrónica #[ID]"
- **Cuerpo:** Mensaje personalizado con detalles de la factura
- **Adjunto:** PDF de la factura

## 🎨 Personalización

### Cambiar el mensaje del correo

Edita el archivo `enviar_factura.php` en la sección `$mail->Body`:

```php
$mail->Body = '
    <html>
    <body>
        <h2>Tu mensaje personalizado aquí</h2>
        <!-- Tu contenido HTML -->
    </body>
    </html>
';
```

### Cambiar el nombre del archivo PDF

Edita la línea:

```php
$mail->addStringAttachment($pdfOutput, 'factura_' . $venta->id_venta . '.pdf');
```

## 📞 Soporte

Si tienes problemas, verifica:

1. ✅ PHPMailer está instalado (`composer require phpmailer/phpmailer`)
2. ✅ El archivo `email_config.php` está configurado correctamente
3. ✅ Las credenciales de correo son correctas
4. ✅ El ID de venta existe en la base de datos
5. ✅ El correo del destinatario es válido

## 🎉 ¡Listo!

Ahora puedes enviar facturas por correo electrónico de forma automática.
