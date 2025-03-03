# Etapa de build para producción
FROM node:20-alpine as build

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .

ARG BUILD_ENV=production
RUN if [ "$BUILD_ENV" = "production" ]; then npm run build; fi

# Etapa de producción con Nginx
FROM nginx:alpine as production
COPY --from=build /app/dist /usr/share/nginx/html
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]

# Etapa de desarrollo con Node.js
FROM node:20-alpine as development
WORKDIR /app
COPY --from=build /app .
CMD ["npm", "run", "dev"]