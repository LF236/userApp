# User App

**Instrucción de uso para ejecutar la aplicación:**

Como la aplicación está hecha en PHP (sin ningún framework como Laravel), no es necesario instalar dependencias.

## Ejecución Tradicional
Es necesario tener instalado **PHP** y **Mysql** en el equipo/servidor en donde vaya a ser ejecutado.
Las configuraciones para MYSQL simplemente es tener el servicio en ejecución con una base de datos previamente creada (el esquema de la **DB** es creado por  la aplicación de php cuando es iniciado).
### Pasos
1. Copiar el archivo .env.template a .env
2. Llenar las variables de entorno
```
DB_HOST=Host de la base de datos (IP del servidor) EJ: 127.0.0.1
DB_USERNAME=Nombre del usuario que tenga acceso a la base de datos
DB_PASSWORD=Contrañena de la base de datos
DB_NAME=Nombre de la base de datos (La que se tenga configurada EJ. test)
```
3. Ejecutar Servidor Web con PHP,
- Acceder al directorio public/
- Ejecutar el servicio de php
```
cd public/
php -S localhost:8080
```

## Ejecución con Docker
Es una ejecución más automatizada, el único requisito es tener **Docker** instalado en el equipo.
Documentación de Docker: [Clic para ver documentacion](https://www.docker.com/).
Es este proceso **NO** es necesario tener instalado **MYSQL** ni **PHP** instalados en el equipo/servidor.

### Pasos
1. Copiar el archivo .env.template a .env
2. Llenar las variables de entorno
```
DB_HOST=db Host de la base de datos (IP del servidor) Como se usa Docker, el valor debe ser **db**
DB_USERNAME=Nombre del usuario que tenga acceso a la base de datos
DB_PASSWORD=Contrañena de la base de datos
DB_NAME=Nombre de la base de datos (La que se tenga configurada EJ. test)
```
3. Ejecutar el siguiente comando
```
docker-compose up -d
```

### STACK
- php
- js
	- jquery

> **Luis Fernando Rodriguez:** - **LF236** 