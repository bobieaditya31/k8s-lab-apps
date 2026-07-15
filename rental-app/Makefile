.PHONY: help install serve test migrate seed docker-up docker-down docker-logs

help:
	@echo "Vehicle Rental App - Makefile Commands"
	@echo "========================================"
	@echo "make install       - Install dependencies"
	@echo "make serve         - Start development server"
	@echo "make migrate       - Run database migrations"
	@echo "make seed          - Seed database with sample data"
	@echo "make test          - Run tests"
	@echo "make docker-up     - Start Docker containers"
	@echo "make docker-down   - Stop Docker containers"
	@echo "make docker-logs   - View Docker logs"
	@echo "make db-reset      - Reset database"

install:
	composer install

serve:
	php spark serve --host 0.0.0.0 --port 8080

migrate:
	php spark migrate

seed:
	php spark db:seed VehicleSeeder
	php spark db:seed CustomerSeeder

test:
	./vendor/bin/phpunit

docker-up:
	docker-compose up --build -d

docker-down:
	docker-compose down

docker-logs:
	docker-compose logs -f

db-reset:
	php spark migrate:refresh --seed

clean:
	rm -rf vendor/
	composer install --no-dev
