#------------------------------------------------------------------------------
# Webpack Makefile
#------------------------------------------------------------------------------

NPM_DOCKER_CMD = docker run --rm \
	-v ${ROOT_PATH}:/var/www/app \
	-v ${HOME}/.npm:/opt/.npm \
	-u ${USER_ID}:${GROUP_ID} \
	-w /var/www/app/application \
	node:13 \
	npm ${1}

# Spread cli arguments
ifneq (,$(filter npm-install% npm-uninstall, $(firstword $(MAKECMDGOALS))))
    NPM_CLI_ARGS := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))
    $(eval $(NPM_CLI_ARGS):;@:)
endif

#------------------------------------------------------------------------------

npm-install: ##@npm install npm dependencies
	$(call NPM_DOCKER_CMD, install $(NPM_CLI_ARGS) --silent)

npm-install-dev: ##@npm install npm dependencies
	$(call NPM_DOCKER_CMD, install $(NPM_CLI_ARGS) --save-dev)

npm-uninstall: ##@npm install npm dependencies
	$(call NPM_DOCKER_CMD, uninstall $(NPM_CLI_ARGS))

npm-update: ##@npm update npm dependencies
	$(call NPM_DOCKER_CMD, update)

# npm-create-cache-dir:
# 	mkdir -p ~/.npm

#------------------------------------------------------------------------------

webpack-build: ##@npm build assets for development environment
	$(call NPM_DOCKER_CMD, run dev)

webpack-build-production: ##@npm build assets for production environment
	$(call NPM_DOCKER_CMD, run build)

webpack-watch: ##@npm run webpack watch
	$(call NPM_DOCKER_CMD, run watch)

#------------------------------------------------------------------------------

clean-npm: ##@npm clean npm dependencies
	test ! -e node_modules || rm -rf node_modules

clean-built-assets: ##@npm clean built assets
	test ! -e public/build || rm -rf public/build

#------------------------------------------------------------------------------

.PHONY: npm-install npm-install-dev npm-uninstall npm-update webpack-build webpack-build-production webpack-watch clean-npm clean-built-assets
