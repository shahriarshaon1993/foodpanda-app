## Foodpanda Application

### Overview

### Requirements

- PHP >= 8.4
- Composer
- Laravel 12
- MySQL
- Node.js and NPM (for frontend assets)

### Installation

1. Clone the Repository

```bash
    git clone <repository-url>
    cd product-caching
```
2. Install PHP Dependencies

```bash
    composer install
```
3. Install JavaScript Dependencies

```bash
    npm install
```
4. Set Up Environment
- Copy the .env.example file to .env:

```bash
    cp .env.example .env
```
- Generate an application key:
```bash
    php artisan key:generate
```
- Generate JWT secret key:
```bash
    php artisan jwt:secret
```