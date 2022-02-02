<p align="center"><a href="https://github.com/meridianforums/meridian" target="_blank"><img src="https://raw.githubusercontent.com/meridianforums/assets/main/SVG/logo_text.svg" width="400"></a></p>

## Meridian Website

This is the core website for the Meridian project. This repository is the main source of truth for the website and holds the user registration system and Meridian forum project licenses.

## Installation Steps

1. Clone the repository
```
git clone https://github.com/meridianforums/website.git
```
2. Install the dependencies
```
composer install
npm install
npm run dev
cp .env.example .env
```
3. Artisan commands
```
php artisan key:generate
php artisan migrate
```

### Tests
This project is fully tested and the tests are run with the following command:
```
php artisan test
```

If you see a missing test or a test that fails, please open an issue.

### API Route
The API route can be accessed at the following path using a GET request:
```
http://website.test/api/license/{key}
```
It will return the license information for the key provided if it exists and the current status of the license.
