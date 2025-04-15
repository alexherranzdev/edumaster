.PHONY: start stop

DOCKER_COMPOSE = docker compose

start:
	@echo "🚀 Construyendo los contenedores..."
	$(DOCKER_COMPOSE) build --no-cache --progress=plain
	@echo "📦 Levantando los contenedores..."
	$(DOCKER_COMPOSE) up -d
	@echo "✅ Proyecto levantado correctamente."

stop:
	@echo "🛑 Deteniendo y eliminando los contenedores..."
	$(DOCKER_COMPOSE) down
	@echo "✅ Contenedores detenidos y eliminados."

restart:
	@echo "🚀 Reiniciando los contenedores..."
	$(DOCKER_COMPOSE) stop
	$(DOCKER_COMPOSE) start
