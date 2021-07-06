#------------------------------------------------------------------------------
# Database Makefile
#------------------------------------------------------------------------------

database-admin-exec = docker-compose -f ${DOCKER_COMPOSE_FILE} exec -T --user root db ${1}
database-doctrine-exec = docker-compose -f ${DOCKER_COMPOSE_FILE} exec -T --user ${USER_ID} php ${1}

#------------------------------------------------------------------------------

db-init: db-system-init db-create-database db-migrate db-populate ##@database create and populate database

db-system-init:
	$(call database-admin-exec, \
		env PGPASSWORD=${DATABASE_ADMIN_PASSWORD} \
		psql --echo-all --username=${DATABASE_ADMIN} \
		--variable="database_name=${DATABASE_NAME}" \
		--variable="user=${DATABASE_USER}" \
		--variable="user_password='${DATABASE_USER_PASSWORD}'" \
		--file="/var/data/sql/system.sql")

db-create-database:
	$(call database-doctrine-exec, php bin/console doctrine:database:create)

db-populate: ##@database populate with fixtures data
	rsync -pav --delete application/fixtures/dev-referential/ application/fixtures/dev/
	$(call database-doctrine-exec, php bin/console hautelook:fixtures:load --no-bundles --env=dev --no-interaction --verbose)

db-populate-production: ##@database populate with fixtures data
	rsync -pav --delete application/fixtures/prod-referential/ application/fixtures/dev/
	$(call database-doctrine-exec, php bin/console hautelook:fixtures:load --no-bundles --env=dev --no-interaction --verbose)

db-migrate: ##@database run the database migrations
	$(call database-doctrine-exec, php bin/console doctrine:migrations:migrate --no-interaction)

db-create-migration: ##@database create a new migration file
	$(call database-doctrine-exec, php bin/console doctrine:migrations:diff)

db-update-schema:
	$(call database-doctrine-exec, php bin/console doctrine:schema:update --force)

db-wait-for:
	sh bin/wait-for-db.sh

#------------------------------------------------------------------------------

clean-db: ##@database clean database TODO ?

#------------------------------------------------------------------------------

.PHONY: db-init db-create-user db-create-database db-migrate db-populate db-wait-for
