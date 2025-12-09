# 🚀 Guía de Migración - principal.php Refactorizado

## ✅ Checklist de Migración

### Fase 1: Preparación (5 minutos)

- [ ] Hacer backup del archivo original
- [ ] Revisar la documentación (REFACTORING-README.md y ARCHITECTURE.md)
- [ ] Verificar que todos los componentes se crearon correctamente

### Fase 2: Verificación de Archivos (2 minutos)

Verificar que existen los siguientes archivos:

#### Componentes Principales

- [ ] `components/header.php`
- [ ] `components/sidebar-user-panel.php`
- [ ] `components/menu-admin.php`
- [ ] `components/footer.php`
- [ ] `components/modals.php`

#### Secciones de Menú

- [ ] `components/menu-sections/clientes.php`
- [ ] `components/menu-sections/ventas.php`
- [ ] `components/menu-sections/remision.php`
- [ ] `components/menu-sections/nota-credito.php`
- [ ] `components/menu-sections/cobranza.php`
- [ ] `components/menu-sections/productos.php`
- [ ] `components/menu-sections/inventario.php`
- [ ] `components/menu-sections/configuraciones.php`
- [ ] `components/menu-sections/caja.php`
- [ ] `components/menu-sections/reportes.php`

#### Helpers

- [ ] `helpers/menu-helper.php`

#### Archivo Principal

- [ ] `principal-refactored.php`

### Fase 3: Backup (3 minutos)

```bash
# Opción 1: Renombrar el archivo original
cd c:\Users\PC\Herd\facturacionsincro\core\modules\index\view
cp principal.php principal-backup-$(date +%Y%m%d).php

# Opción 2: Crear carpeta de backup
mkdir backup
cp principal.php backup/principal-$(date +%Y%m%d-%H%M%S).php
```

### Fase 4: Implementación

#### Opción A: Reemplazo Directo (Recomendado para Producción)

1. **Hacer backup** (CRÍTICO)

   ```bash
   cp principal.php principal-backup.php
   ```

2. **Reemplazar archivo**

   ```bash
   cp principal-refactored.php principal.php
   ```

3. **Probar la aplicación**

   - Iniciar sesión
   - Navegar por los menús
   - Verificar que todas las secciones funcionan

4. **Si hay problemas, revertir**
   ```bash
   cp principal-backup.php principal.php
   ```

#### Opción B: Prueba Paralela (Recomendado para Testing)

1. **Crear ruta de prueba**
   Modificar el router o crear un archivo de prueba:

   ```php
   // test-refactored.php
   <?php
   $_SESSION["admin_id"] = 1; // ID de prueba
   include 'principal-refactored.php';
   ?>
   ```

2. **Acceder a la ruta de prueba**

   ```
   http://tu-dominio/test-refactored.php
   ```

3. **Validar funcionalidad**

   - Todos los menús se muestran correctamente
   - Los enlaces funcionan
   - No hay errores de PHP

4. **Una vez validado, hacer el reemplazo**

### Fase 5: Validación (10 minutos)

#### Tests Funcionales

- [ ] **Login**

  - Iniciar sesión como administrador
  - Iniciar sesión como usuario normal

- [ ] **Header**

  - Logo se muestra correctamente
  - Menú de usuario funciona
  - Botón de salir funciona

- [ ] **Sidebar**

  - Panel de usuario se muestra
  - Logo de empresa se muestra
  - Barra de búsqueda funciona

- [ ] **Menú Administrador** (si aplica)

  - Sección EMPRESA
  - Sección USUARIOS
  - Sección REPORTES
  - Sección CONFIGURACIÓN

- [ ] **Menú Sucursales**

  - Se muestran todas las sucursales del usuario
  - Cada sucursal tiene su menú completo
  - Los enlaces tienen el id_sucursal correcto

- [ ] **Secciones de Menú**

  - [ ] Clientes
  - [ ] Ventas
  - [ ] Remisión
  - [ ] Nota de Crédito
  - [ ] Cobranza (si opciones == 1)
  - [ ] Productos
  - [ ] Inventario
  - [ ] Configuraciones
  - [ ] Caja
  - [ ] Reportes

- [ ] **Footer**

  - Copyright se muestra
  - Versión se muestra

- [ ] **Modales**
  - Modal de perfil abre correctamente
  - Modal de datos del administrador funciona

#### Tests de Errores

- [ ] No hay errores de PHP en logs
- [ ] No hay warnings en logs
- [ ] No hay errores 404 para archivos include
- [ ] No hay errores de JavaScript en consola

### Fase 6: Optimización (Opcional)

#### Caché de Opcodes (Recomendado)

Si usas OPcache, reiniciar para limpiar caché:

```bash
# En servidor con PHP-FPM
sudo service php-fpm restart

# O reiniciar Apache
sudo service apache2 restart
```

#### Permisos de Archivos

Verificar permisos correctos:

```bash
# Archivos PHP deben ser 644
chmod 644 principal.php
chmod 644 components/*.php
chmod 644 components/menu-sections/*.php
chmod 644 helpers/*.php

# Directorios deben ser 755
chmod 755 components/
chmod 755 components/menu-sections/
chmod 755 helpers/
```

### Fase 7: Monitoreo Post-Migración (24 horas)

- [ ] Revisar logs de errores cada 2 horas
- [ ] Monitorear reportes de usuarios
- [ ] Verificar performance (tiempo de carga)
- [ ] Confirmar que no hay regresiones

## 🔧 Troubleshooting

### Problema: "Failed to include file"

**Causa**: Rutas incorrectas en los includes

**Solución**:

```php
// Verificar que las rutas usan __DIR__
include __DIR__ . '/components/header.php';
```

### Problema: "Undefined variable $sucursal"

**Causa**: Variable no está disponible en el scope del componente

**Solución**:

```php
// Pasar variables necesarias antes del include
$sucursal = $sucur->verSocursal();
include __DIR__ . '/components/menu-sections/clientes.php';
```

### Problema: "Call to undefined function renderSucursalMenu()"

**Causa**: Helper no está incluido

**Solución**:

```php
// Asegurarse de incluir el helper
require_once __DIR__ . '/helpers/menu-helper.php';
```

### Problema: Menú no se muestra

**Causa**: Condiciones de permisos

**Solución**:

```php
// Verificar permisos del usuario
var_dump($u->is_admin);
var_dump($u->opciones);
```

## 📊 Métricas de Éxito

Después de la migración, deberías ver:

| Métrica                    | Antes       | Después     | Objetivo              |
| -------------------------- | ----------- | ----------- | --------------------- |
| Tamaño archivo principal   | 1295 líneas | ~150 líneas | ✅ 88% reducción      |
| Código duplicado           | Alto        | Ninguno     | ✅ 0% duplicación     |
| Tiempo de carga            | X ms        | X ms        | ✅ Sin degradación    |
| Errores PHP                | 0           | 0           | ✅ Sin nuevos errores |
| Facilidad de mantenimiento | Baja        | Alta        | ✅ Mejorada           |

## 🎯 Siguientes Pasos

Después de una migración exitosa:

1. **Documentar cambios** en el changelog del proyecto
2. **Capacitar al equipo** sobre la nueva estructura
3. **Actualizar guías de desarrollo** con las nuevas convenciones
4. **Considerar refactorizar** otros archivos grandes del proyecto

## 📞 Soporte

Si encuentras problemas durante la migración:

1. Revisa los logs de PHP
2. Consulta la sección de Troubleshooting
3. Revierte al backup si es necesario
4. Documenta el problema para análisis

## ✨ Beneficios Post-Migración

Una vez completada la migración, disfrutarás de:

- ✅ Código más limpio y organizado
- ✅ Mantenimiento más rápido y sencillo
- ✅ Menos bugs por código duplicado
- ✅ Mejor colaboración en equipo
- ✅ Escalabilidad mejorada
- ✅ Testing más fácil

---

**Tiempo estimado total de migración**: 20-30 minutos
**Riesgo**: Bajo (con backup adecuado)
**Impacto**: Alto (mejora significativa en mantenibilidad)

**Fecha de creación**: 2025-12-09
**Versión**: 1.0
