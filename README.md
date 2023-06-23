# Mercatodo

<p>
    Este es un proyecto del Bootcamp de Evertec - PlaceToPay. A continuación se describen los pasos para poder descargar y utilizar el proyecto en tu máquina local.
</p>

<br>

#### Consideraciones iniciales:

- Como recomendación del desarrollador te sugerimos utilizar Laragon como entorno base para el proyecto, sin embargo no es obligatorio (XAMPP o WAMPP son válidos también)
- Tener un gestor de base de datos relacional puede ser de gran ayuda
- Tener instalada la versión 8.2.5 (como mínimo) de PHP en tu sistema, así como Composer en su versión 2.4.1 (como mínimo)
- Debes tener instalado también npm en tu sistema para poder compilar el frontend del proyecto 

<br>

## Pasos para descargar el proyecto
<br>

1. Crea una carpeta en tu sistema para clonar el proyecto desde el repositorio. Para Laragon recomiendo clonar el proyecto directamente en laragon/www. En el caso de XAMPP se recomienda hacerlo dentro de Xampp/htdocs. Esto no es obligatorio y puedes hacerlo dentro de cualquier parte de tu sistema.

2. Accede a la url del repositorio https://github.com/juanvireyes/ecommerce y en el botón verde "Code" puedes seleccionar la opción que requieras para clonar el repo utilizando el comando git clone o la CLI de git (No olvides tener instalado Git en tu sistema operativo)

3. Una vez hayas clonado el repositorio en tu máquina local debes acceder al directorio (o carpeta) "ecommerce" a través del terminal (con el comando cd ecommerce estando ubicado dentro de la carpeta donde clonaste el repositorio)

4. Una vez dentro de la carpeta ecommerce (y con Composer instalado en tu sistema) debes correr el comando composer install (también funciona composer i) para instalar todas las dependencias necesarias de laravel y composer para el proyecto

5. También debes correr el comando npm instal (también funciona npm i) para poder compilar los assets de vite en el proyecto y poder cargar el frontend correctamente

6. Si utilizas VisualStudioCode y lo tienes configurado, puedes utilizar el comando code . en la terminal dentro de la carpeta ecommerce para abrir el proyecto completo en el editor de código. O puedes abrir el proyecto con tu editor de código favorito
   
7. También debes correr el comando npm run dev en tu terminal dentro de la carpeta ecommerce para compilar los assets del frontend con vite

8. Es muy importante, antes de abrir el proyecto en local, ejecutar las migraciones utilizando el comando php artisan migrate. Adicionalmente se pueden realizar los seeders con el comando php artisan db:seed para llenar algunos datos de prueba en tu base de datos.

9. Si estás utilizando una carpeta independiente (que no se encuentre dentro de la ruta laragon/www o Xampp/htdocs) debes correr en una nueva terminal el comando php artisan serve para correr el servidor del proyecto. Si tienes tu proyecto dentro de las rutas de laragon o XAMPP mencionadas anteriormente, puedes acceder a http://127.0.0.1:8000/public sin necesidad de correr el comando php artisan serve para acceder al proyecto y poder visualizar su funcionamiento 