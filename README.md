# Mercatodo

[![Project version](https://img.shields.io/badge/Version-V1.0-blue)]()
[![Laravel version](https://img.shields.io/badge/Laravel-V4.4.3-red?logo=laravel)](https://laravel.com/)
[![Npm Version](https://img.shields.io/badge/npm-8.18-gren?logo=npm)](https://docs.npmjs.com/)
[![Vite](https://img.shields.io/badge/Vite-compiler-black?logo=vite)](https://vitejs.dev/)

### Goal
<br>
Mercatodo is an ecommerce to learn and practice Laravel for the Evertec-PlaceToPay Bootcamp.
<br>

-----

## Installing Mercatodo

#### Preparing your system
- Get PHP at least in it's 8.2.5 version
- Get Laravel al least in it's 4.4.3 version
- Get composer at least in it's 2.4.2 version
- If it's possible use Laragon to set a correct development environment
<br>
***

<p>First clone the repository in your local machine using git clone command</p>

    git clone https://github.com/juanvireyes/ecommerce.git

<p>Install the composer depedencies in order the project can run</p>

    composer install

<p>Do the same with node dependencies for front compilation</p>

    npm install

<p>After you've cloned and installed the project, you can set the environment variables that will be needed. Take a look at .env.example file so you can have an idea about those variables. If you don't have some env values, you should ask for them</p>

<p>Next you should run the migrations and seeders to populate your database with some data to work with, just run (Be sure that you provided the database information as is shown in .env.example file to avoid errors during migrations and db populate)</p>

    php artisan migrate --seed

<p>If you created your project in an independent directory, run the following command to start the local server of your app</p>

    php artisan serve

## <p>If you've created the project using laragon, XAMPP or WAMPP see related documentation of each option to open the project</p>

----
# Project captions

![Home page](public/gifs/vitrina.gif)
![Login](public/gifs/login.gif)
![Shopping cart](public/gifs/shoppingCart.gif)
![Order generation](public/gifs/OrderGeneration.gif)
![Payment](public/gifs/Payment.gif)


----

# Related documentation
- [Laravel](https://laravel.com/)
- [XAMPP config][XAMPP config]
- [WAMP config][WAMP config]
- [Laragon config][Laragon config]






[XAMPP config]: https://www.freecodecamp.org/news/configure-a-laravel-project-with-custom-domain-name/#:~:text=First%2C%20launch%20your%20Xampp%20Interface,your%20Apache%20and%20MySQL%20Server.&text=Next%2C%20click%20on%20Explorer%20to,can%20setup%20your%20Laravel%20application.

[WAMP config]: https://medium.com/@has.raymondwong/install-and-run-laravel-on-windows-wamp-server-fc9ce604cd50

[Laragon config]: https://www.wikihow.com/Install-Laravel-Using-Laragon