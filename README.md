# Sistema de Gestión de Cuentas de Cobro para Alcaldías

Este proyecto permite gestionar de manera centralizada las **cuentas de cobro**, control de pagos, estados y usuarios bajo un sistema de **roles y permisos** diseñado para entidades públicas como las alcaldías. Está orientado a mejorar la trazabilidad, seguridad y eficiencia del proceso administrativo.

---

## 1. Descripción del Proyecto

El sistema permite:

- Registrar, editar y visualizar cuentas de cobro.
- Controlar estados como: *pendiente*, *en revisión*, *aprobado*, *devuelto*, *pagado*.
- Llevar trazabilidad completa por cada cuenta.
- Subir y gestionar documentos asociados.
- Administrar usuarios mediante un sistema de roles y permisos.
- Generar paneles personalizados según el rol.
- Optimizar procesos internos de gestión y validación entre dependencias.

---

## 2. Instrucciones de Instalación y Configuración

### **Requisitos previos**
- PHP >= 8.x  
- Composer  
- MySQL / MariaDB  
- Node.js + NPM  
- Git  

---

### **Instalación**

```bash
# Clonar el repositorio
git clone https://github.com/turepo/cuentas_cobro.git
cd cuentas_cobro

# Instalar dependencias PHP
composer install

# Instalar dependencias frontend (si aplica)
npm install
npm run build
