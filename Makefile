.PHONY: docs serve

docs:
	cd docs && $(MAKE)

serve:
	cd src && php artisan serve
