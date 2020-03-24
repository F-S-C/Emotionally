.PHONY: docs serve dev-install

docs:
	cd docs && $(MAKE)

serve:
	cd src && php artisan serve

clean:
	cd docs && $(MAKE) clean


### DEVELOPMENT SECTION ###

dev-install: # Install the source code dependencies
	cd src && composer install
	cd src && npm install
	cd src && npm run dev
