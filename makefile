.PHONY=docker-up
docker-up:
	docker compose -f docker/docker-compose.yml up -d

.PHONY=migrate
migrate:
	mysql --host="$$DATABASE_HOST" --port="$$DATABASE_PORT" --user="$$DATABASE_USER" --database="$$DATABASE_NAME" -p < "$$MIGRATION_FILE"

.PHONY=dump-autoload
dump-autoload:
	composer dump-autoload --working-dir src/