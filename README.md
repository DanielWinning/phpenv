# PHPEnv

<div>
<!-- Version Badge -->
<img src="https://img.shields.io/badge/Version-1.3.0-blue" alt="Version 1.3.0">
<!-- PHP Coverage Badge -->
<img src="https://img.shields.io/badge/PHP Coverage-50.74%25-red" alt="PHP Coverage 50.74%">
<!-- License Badge -->
<img src="https://img.shields.io/badge/License-GPL--3.0--only-34ad9b" alt="License GPL--3.0--only">
</div>

A global Composer package for easily creating Docker containers for local PHP development. Allows you to set up containers
on a project by project basis.

---

Easily create Docker containers configured for development with Laravel, Symfony or plain vanilla PHP, with the following services:

- Nginx
- MySQL
- PHP 8.2 + opcache + xdebug
- Redis

### Installation

---

**Pre-requisites:**

You will need the following installed before you can make use of **PHPEnv**:
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

To run `phpenv` commands, ensure Docker Engine is running.

#### Build

To build a new container for a project you can run the following command:

```
phpenv build project-name full/path/to/project-root
```

```
phpenv build portfolio-site C:/Development/Websites/portfolio-site
```

This will build a new container for your project and serve files from `your-project-root/public` at `http://localhost:<port>` 
with the port being a randomly assigned port. Once built your containers ports are static and will not change upon restarting
your container.

Your database container name and IP can be found in Docker Desktop or by running the relevant Docker commands. Root 
credentials are `root:docker`.

---

### Other Commands:

- `phpenv help`
  - Displays a list of available commands.
- `phpenv show` 
  - Display a list of environments created with **phpenv**.
- `phpenv start <name>`
  - Starts a container by saved name. Pass the name you used when running the build command.
- `phpenv stop <name>`
  - Stops a running container by saved name.
- `phpenv destroy <name>`
  - Destroys a container by saved name.
- `phpenv attach <name>`
  - Attach to the bash terminal within your projects container.