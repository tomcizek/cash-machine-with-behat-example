cs:
	./vendor/bin/ecs check src features lib

nccs:
	./vendor/bin/ecs check src features lib --clear-cache

fix:
	./vendor/bin/ecs check src features lib --fix

stan:
	composer dump
	./vendor/bin/phpstan analyse --configuration=phpstan.neon --level=max --verbose src features lib

test:
	vendor/bin/phpunit --configuration phpunit.xml src

behat:
	vendor/bin/behat

