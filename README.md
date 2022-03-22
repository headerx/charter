# The Source Code of HeaderX Charter!

![Tests](https://github.com/headerx/charter/actions/workflows/test.yml/badge.svg)
![Styling](https://github.com/headerx/charter/actions/workflows/code-formatting.yml/badge.svg)
![Linting](https://github.com/headerx/charter/actions/workflows/phplint.yml/badge.svg)

## Installation

### Install Dependencies

```bash
composer install
```

```bash
npm install && npm run dev
```

### Configure Environment

First copy `.env.example` to `.env`

```bash
cp .env.example .env
```

Then edit database configurations to match your local setup

### Run Migrations

```bash
php artisan migrate
```

### Next you must cache the icons

```bash
php artisan icon:cache
```

### Then install the icons

```bash
php artisan buku-icons:install
```

### After that is finished you can generate an app key

```bash
php artisan key:generate
```

### Run Tests

```bash
php artisan test
```

### And finally serve your application!

```bash
php artisan serve
```
