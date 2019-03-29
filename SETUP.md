# Sample Forms App

A sample project showing how to build a simple form data entry and processing application using PHP and MarkLogic.

## Requirements

- [PHP 7.2](https://www.php.net/manual/en/install.php)
- [Composer](https://getcomposer.org/doc/00-intro.md)
- [Laravel 5.8](https://laravel.com/docs/5.8/installation)
- Latest version of [MarkLogic 9](https://developer.marklogic.com/products)

## Project Setup

This project was created using the following steps:

### Setup Project Directory

Use Laravel to scaffold a new project.

1. Open a terminal.
2. Create a new Laravel project by running the command `laravel new ml-php-sampleforms`.  This will create a new directory named *ml-php-sampleforms*.

### Setup Gradle

Setup Gradle for automating our MarkLogic configuration and deployment.  These steps are similar to those specified [here](https://github.com/marklogic-community/ml-gradle).

1. Change directory to `ml-php-sampleforms`.
2. Create a new file named `build.gradle`.
3. Open `build.gradle` in a text editor and enter the following line:

```gradle
plugins { id "com.marklogic.ml-gradle" version "3.13.0" }
```

4. Run `gradle mlNewProject`.
5. Gradle will prompt for an *Application name*, which will be used as a basis for database names and other parts of the database configuration.  Enter *ml-php-sampleforms*.
6. You will be prompted next for *host*; press ENTER to use the default (localhost).
7. Next will be admin username and password; use the defaults (admin).
8. Next will be the *REST API port*.  Enter any port number not currently in use.  In this instance, the project uses port 9020.
9. Next will be the *Test REST API port*.  Leave this blank for the meantime.
10. Next will be support for multiple environments.  Enter `y`.
11. Next will be for generating resource files.  Enter `y`.

### Verify/Test

1. Open a terminal and run `php artisan serve`.
2. Open a browser and navigate to the development server (usually `http://127.0.0.1:8000`).
3. If successful, a default Laravel web page should be displayed.
4. Run `gradle mlDeploy`.
5. Navigate to `http://localhost:8001` to open the MarkLogic admin page.
6. If deployment was successful, we should see the `ml-php-sampleforms` under *App Servers*.

### Initial Coding

1. Run `php artisan make:auth` for authentication scaffolding.  Best to do this early as it modifies code, even if there are no plans to configure authentication yet.
2. To prepare the project for source control (Git), open `.gitignore` file and add a line for `.gradle` and `build`.
3. Add [Guzzle](http://docs.guzzlephp.org/en/stable/overview.html) for PHP using composer by modifying `composer.json` as described [here](http://docs.guzzlephp.org/en/stable/overview.html#installation).