cs:
	./vendor/bin/ecs check src features

nccs:
	./vendor/bin/ecs check src features --clear-cache

fix:
	./vendor/bin/ecs check src features --fix

stan:
	composer dump
	./vendor/bin/phpstan analyse --configuration=phpstan.neon --level=max --verbose src features

test:
	vendor/bin/phpunit --configuration phpunit.xml src
