# Iso Gestión

### Sistema de Gestión de ISO 9001/2015

Software que soporta y sustenta toda la información respaldatoria necesaria para la gestión de la norma ISO9001. 

Utilizado desde 2014, para los registros de los dos alcances certificados por CeSPI UNLP, con un esquema de perfiles, roles y permisos configurable a toda la organización. 
Actualmente 30 usuarios con distintos perfiles y con alrededor de 3000 registros.
La definición del formato de los registros es personalizable, permitiendo configurar textos, fechas, URLs y listas de valores posible en un campo. Los campos fechas permiten configurar si se reciben alertas por correo electrónico.
La gestión de cambios de los registros se realiza a través del sistema. 
Permite obtener reportes en formato xls aplicando distintos filtros.
Se integra con un esquema de Single Sign On o autenticación tradicional.

## Requerimientos:

	- PHP 5.4 o superior
	- Base de datos Mysql 5.5 o superior
	- PDO y driver Mysql 
	- composer

EL software fue desarrollado utilizando la plataforma de desarrollo Symfony 2.8, toda la documentación de la herramienta se encuentra en su sitio web http://symfony.com/doc/2.8/setup.html

## Instalación: 

1) Clonar el repositorio 

    git clone git@github.com:Desarrollo-CeSPI/iso-gestion.git

2) Ajustar parametros de configuración a la base de datos y mailer en "app/config/parameters.yml"

Ejemplo: 

parameters:

    database_driver: pdo_mysql

    database_host: 127.0.0.1
    database_port: null
    database_name: iso_gestion_db
    database_user: root
    database_password: null
    mailer_transport: smtp
    mailer_host: 127.0.0.1
    mailer_user: null
    mailer_password: null
    locale: es
    secret: IsoGestionCespi2018!


3) Ejecutar el comando composer install

4) Ejecutar los comandos "php app/console cache:clear" y "php app/console cache:clear -e prod"

5) Crear la base de datos con el comando: "php app/console doctrine:database:create"

6) Importar estructura de la base de datos vacía con el comando: "app/console doctrine:database:import app/db/iso_gestion_db.sql"

7) Acomodar los permisos de las carpetas de cache y logs 
	"sudo chmod 777 -R app/cache app/logs"

8) Publicar en el servidor web la carpeta "/web" una vez finalizada la instalación se accede al sistema con el usuario creado por defecto "admin" y clave "admin"

9) La aplicación dispone de un comando por consola el cual deberá ser croneado con una periodicidad diaria para el envío de los recordatorios de vencimientos de fecha por e-mail: "php app/console iso:avisos"






