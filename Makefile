start:
	docker-compose up --build -d
	docker exec -it edumaster-frontend npm install
	docker exec -it edumaster-frontend npm run build

stop:
	docker-compose down

migrate:
	docker exec -it edumaster-api php artisan migrate --force
	docker exec -it edumaster-api php artisan db:seed --force

fresh:
	docker exec -it edumaster-api php artisan migrate:fresh --force
	docker exec -it edumaster-api php artisan db:seed --force

frontend:
	docker exec -it edumaster-frontend npm install
	docker exec -it edumaster-frontend npm run dev