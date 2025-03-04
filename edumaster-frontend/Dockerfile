# 1️⃣ Build Stage (Compilamos Vue)
FROM node:lts-alpine as build-stage
WORKDIR /app

# Copiamos solo los archivos esenciales para evitar reinstalar dependencias innecesarias
COPY package*.json ./
RUN npm install

COPY . .
RUN npm run build

# 2️⃣ Production Stage (Usamos Nginx para servir la app)
FROM nginx:stable-alpine as production-stage

# Copiamos los archivos compilados al servidor web de Nginx
COPY --from=build-stage /app/dist /usr/share/nginx/html

# Copiamos la configuración personalizada de Nginx
COPY nginx.conf /etc/nginx/conf.d/default.conf

# Exponemos el puerto 80 para servir la aplicación
EXPOSE 80

# Iniciamos Nginx
CMD ["nginx", "-g", "daemon off;"]