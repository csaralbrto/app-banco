# APP-BANCO de Laravel con Tailwind CSS

Esta es una aplicación web desarrollada con Laravel y Tailwind CSS. A continuación, encontrarás instrucciones para configurar el entorno de desarrollo, ejecutar las migraciones, cargar datos de prueba, ejecutar pruebas unitarias y compilar los estilos de Tailwind CSS.

## Requisitos

Asegúrate de tener instaladas las siguientes versiones mínimas de software en tu sistema:

- PHP >= 8.2
- Node.js >= 20.3.1
- Composer (Para gestionar las dependencias de PHP)
- npm (Node Package Manager)

## Configuración

## Clona este repositorio en tu sistema local:

```bash
git clone https://github.com/csaralbrto/app-banco.git
```

## Accede al directorio de la aplicación:

```bash
cd tu-app-laravel
```

## Instala las dependencias de PHP a través de Composer:
```bash
composer install
```

## Instala las dependencias de Node.js:
```bash
npm install
```

## Copia el archivo .env.example y crea un nuevo archivo .env:
```bash
cp .env.example .env
```

## Genera una clave de aplicación:
```bash
php artisan key:generate
```

## Configura la base de datos en el archivo .env. Asegúrate de que los valores de DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME y DB_PASSWORD sean los correctos para tu entorno.


## Ejecuta las migraciones para crear las tablas de la base de datos:
```bash
php artisan migrate
```

## Ejecuta los seeders para cargar datos de prueba en la base de datos:
```bash
php artisan db:seed --class=AccountSeeder
```
```bash
php artisan db:seed --class=ProfileSeeder
```

## PRUEBAS UNITARIAS
```bash
php artisan test
```

# COMPILACIÓN TAILWIND CSS

## Compila los estilos para desarrollo:

```bash
npm run dev
```

## Compila los estilos para producción (minificar y eliminar comentarios):

```bash
npm run build
```

## EJECUCIÓN DEL PROYECTO


```bash
php artisan serve
```