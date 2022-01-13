test:
	@make test-static

phpstan:
	./vendor/bin/phpstan analyse -c phpstan.neon.dist

baseline-generate:
	./vendor/bin/phpstan analyse -c phpstan.neon.dist -l max --generate-baseline
