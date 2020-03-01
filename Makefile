#------------------------------------------------------------------------------
# Main Makefile
#------------------------------------------------------------------------------

USER_ID=$(shell id -u)
GROUP_ID=$(shell id -g)
ROOT_PATH=$(shell pwd)
DOCKER_COMPOSE_FILE?=./docker-compose.yml
# DOCKER_COMPOSE_BUILDER_FILE?=./docker-compose-builder.yml

export USER_ID
export GROUP_ID

#------------------------------------------------------------------------------

include .env
export $(shell sed 's/=.*//' .env)

ifneq (,$(wildcard application/.env.local))
	include application/.env
	export $(shell sed 's/=.*//' application/.env)
endif

ifneq (,$(wildcard application/.env.local))
	include application/.env.local
	export $(shell sed 's/=.*//' application/.env.local)
endif

#------------------------------------------------------------------------------

include makefiles/*.mk

#------------------------------------------------------------------------------

init: composer-install npm-install webpack-build ## install project dependencies

#------------------------------------------------------------------------------

.DEFAULT_GOAL := help

help:
	@echo "================================================================================"
	@echo " Main Makefile"
	@echo "================================================================================"
	@echo
	@perl -e '$(HELP_FUNC)' $(MAKEFILE_LIST)
	@echo "================================================================================"

#------------------------------------------------------------------------------

.PHONY: help
