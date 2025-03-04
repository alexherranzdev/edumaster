# EduMaster - Documentación de instalación y uso

## **Requisitos previos**

Antes de iniciar la aplicación, asegúrate de tener instalados los siguientes requisitos en tu máquina:

- **Docker** y **Docker Compose**
- **Make** (opcional, pero recomendado para simplificar comandos)
- **Node.js** y **npm** (para desarrollo frontend)

---

## **Instalación y puesta en marcha**

Para iniciar la aplicación, ejecuta los siguientes comandos:

```bash
make start
```

Este comando:

- 1. Levanta los contenedores con docker-compose up --build -d.
- 2. Instala las dependencias del frontend (npm install).
- 3. Construye la aplicación frontend (npm run build).

Si solo necesitas iniciar el frontend en modo desarrollo:

```bash
make frontend
```

Para detener la aplicación:

```bash
make stop
```
