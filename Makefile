#Symfony Shortcut
sf=php bin/console
sfd=php bin/console --env=dev
sfp=php bin/console --env=prod

#Docker compose shortcut (Know issue with cedvan/compose : chain volume mounting not fast enought (ex: atoum command))
#fig=docker run --rm -it -v $(PWD):/src -v /var/run/docker.sock:/var/run/docker.sock -e "PATH_PROJECT=$(PWD)" cedvan/compose:latest
fig=docker-compose

pull:
	@echo ------------------------Pulling docker images-------------------------
	$(fig) pull

start:
	@echo -------------------Starting application containers--------------------
	$(fig) up -d

state:
	@echo -----------------------Current project state--------------------------
	$(fig) ps

stop:
	@echo -------------------Stopping application containers--------------------
	$(fig) stop

clean:
	@echo -------------------Removing application containers--------------------
	$(fig) rm --force

atoum:
	@echo ---------------------Running atoum test suite-------------------------
	$(fig) run --rm --no-deps php /var/www/bejoe/bin/atoum --bootstrap-file /var/www/bejoe/.bootstrap.atoum.php --configurations /var/www/bejoe/.atoum.php

#bower-install:
#	$(fig) run --rm builder bower --allow-root install
#
#gulp:
#	$(fig) run --rm builder gulp --dev
#
#coke:
#	$(fig) run --rm web bin/coke
#
#eslint:
#	$(fig) run --rm builder eslint *
