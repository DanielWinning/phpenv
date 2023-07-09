# PHPEnv

A zero-dependency global Composer package for creating pre-configured Docker containers for local
PHP development.

---

Easily create Docker containers configured for development with Laravel, Symfony or plain vanilla PHP, with the following services:

- Nginx
- MySQL
- PHP 8.1 + opcache + xdebug
- Redis

### Installation

---

**Pre-requisites:**

You will need to following installed before you can make use of **PHPEnv**:
- Composer
- Docker Desktop

Then download and install PHPEnv globally:

```
composer global require dannyxcii/phpenv
```

To confirm that the package is installed successfully, run the `phpenv` command which 
will list the help text.

### Usage

---

