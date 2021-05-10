test-unit:
	php vendor/bin/phpunit --group unit --verbose
test-unit-deprecations:
	@make test-unit SYMFONY_DEPRECATIONS_HELPER="max[total]=100"
test-functional:
	php vendor/bin/phpunit --group functional --verbose
test-functional-deprecations:
	@make test-functional SYMFONY_DEPRECATIONS_HELPER="max[total]=100"

test:
	@make test-static
	@make test-unit
	@make test-functional

test-static:
	@make phpstan
#	@make psalm

phpstan:
	./vendor/bin/phpstan analyse -c phpstan.neon.dist
phpstan-baseline-generate:
	./vendor/bin/phpstan analyse -c phpstan.neon.dist -l max --generate-baseline

psalm:
	./vendor/bin/psalm
psalm-baseline-generate:
	./vendor/bin/psalm --set-baseline=psalm-baseline.xml
psalm-baseline-update:
	./vendor/bin/psalm --update-baseline
