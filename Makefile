start:
	docker-compose up --build -d

stop:
	docker-compose down

restart:
	docker-compose down && docker-compose up --build -d

logs:
	docker-compose logs -f

migrate:
	docker exec -it edumaster-api php artisan migrate --force && php artisan db:seed --force