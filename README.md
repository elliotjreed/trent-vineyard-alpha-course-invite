# Trent Vineyard Alpha Course invitation form

A small Alpha course signup form for Trent Vineyard church in Nottingham, written in Typescript and PHP using Ansible and Docker for deployment.

## PHP API Backend

PHP 7.1 or above and Composer is expected to be installed on our system.

The backend API is located under the `./api` directory.

### Installing Composer

For instructions on how to install Composer visit [getcomposer.org](https://getcomposer.org/download/).

### Installing for Development

After cloning this repository, change into the newly created directory and the subdirectory `api` and run

```
composer install
```

or if you have installed Composer locally

```
php composer.phar install
```

This will install all dependencies needed for the project.

## Running the Tests

All tests can be run by executing

```
vendor/bin/phpunit
```

`phpunit` will automatically find all tests inside the `test` directory and run them based on the configuration in the `phpunit.xml` file.

## Typescript Frontend

### Installing Yarn

For instructions on how to install Yarn visit [yarnpkg.com](https://yarnpkg.com/lang/en/).

### Installing dependencies

The frontend uses Typescript and SASS, and is bundled using Webpack.

To install the required dependencies, change into the `./frontend` subdirectory and run

```
yarn install
```

### Running for development

To run the Webpack development server run:

```
yarn start
```

### Building for production

To build the production-optimised application run:

```
yarn build
```

## Deployment

Deployment is via Ansible and Docker.

## Built With

- [PHP](https://secure.php.net/)
- [Composer](https://getcomposer.org/)
- [PHPUnit](https://phpunit.de/)
- [Typescript](https://www.typescriptlang.org/)
- [Yarn](https://yarnpkg.com/lang/en/)
- [Webpack](https://webpack.js.org/)

## License

This project is licensed under the MIT License - see the [LICENCE](LICENCE) file for details.
