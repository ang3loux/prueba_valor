<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Prueba Valor con Yii 2</h1>
    <br>
</p>

REQUERIMIENTOS
------------

 * XAMPP con Apache y MySQL.
 * Composer


INSTALACIÓN
------------

### Instalación via Composer

1. Ir al directorio raíz del proyecto y ejecutar el comando:

~~~
composer install
~~~

2. Luego de finalizar la instalación de todas las dependencias, se debe crear una nueva base de datos con el nombre de: 

~~~
prueba_valor_db
~~~

Esta base de datos debe tener como usuario "root" y no debe tener contraseña.

3. Se deben correr las migraciones con el comando:

~~~
php yii migrate
~~~

Al terminar las migraciones, la base de datos debe tener todas las tablas con sus relaciones y algunos datos de prueba.

4. En el navegador abrir la dirección:

~~~
http://localhost/prueba_valor/web/
~~~
