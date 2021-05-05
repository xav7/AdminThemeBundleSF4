test:
	@make test-static

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
