# Proyecto EduMaster 🚀

## Descripción

Este proyecto es una plataforma de gestión de fichas para estudiantes y profesores. Los profesores pueden crear fichas de trabajo con preguntas y respuestas, y los estudiantes pueden responderlas.

## Instalación

### Requisitos previos

- Docker

- Docker Compose

- Make

### Pasos

1. Clonar el repositorio:

```bash

git clone https://github.com/alexherranzdev/edumaster.git

cd edumaster

```

2. Construir y ejecutar los contenedores:

```bash

make start

```

3. Acceder a la aplicación:

- Frontend: [http://localhost:5173](http://localhost:5173)

- API: [http://localhost:8000](http://localhost:8000)

## Usuarios por defecto

Durante la inicialización del proyecto, se crean dos usuarios por defecto:

- **Profesor**

- Usuario: `teacher@edumaster.dev`

- Contraseña: `password`

- **Alumno**

- Usuario: `student@edumaster.dev`

- Contraseña: `password`

## Comandos útiles

- **Iniciar el proyecto**: `make start`

- **Detener los contenedores**: `make stop`

- **Ver logs de la API**: `docker logs -f edumaster-api`

- **Ver logs del frontend**: `docker logs -f edumaster-frontend`

## Estructura del proyecto

```

edumaster/

├── edumaster-api/ # Backend en Laravel

├── edumaster-frontend/ # Frontend en Vue.js

├── docker-compose.yml # Configuración de Docker

├── Makefile # Scripts de automatización

└── README.md # Documentación

```
