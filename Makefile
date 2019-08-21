# Start development web server
dev:
	APP_ENV=dev php -S localhost:8000 -t public/

# Run every tests
test:
	vendor/bin/phpunit