# cobble
![License](https://img.shields.io/badge/Licence-MIT-27ae60.svg?style=for-the-badge)
![BuiltWith](https://img.shields.io/badge/built%20with-PHP-34495e.svg?style=for-the-badge)
![Version](https://img.shields.io/badge/version-2.0.0-e67e22.svg?style=for-the-badge) <br>
[![Chat](https://img.shields.io/badge/Chat%20with%20me-Discord-3498db.svg?style=for-the-badge)](https://discord.gg/u8EQVxf)



Cobble is a framework skeleton using Slim Framework 3, Laravel Eloquent ORM, Twig Template Engine, Symfony VarDumper, PHPMailer and Whoops for error reporting.
<br>
> In the examples in this README I'll be using `yarn` but you can also use `npm`.

## Requirements
- PHP >=7.4
- Apache/nginx (mod_rewrite needed)
- composer
- npm/yarn
- bash

## Getting Started
Run this command to create your project based on this skeleton.

```bash
$ git clone https://github.com/Developaaah/cobble.git [my-awesome-project]
$ cd [my-awesome-project]
```

After that, you need to install all required node modules by typing:

```bash
$ npm i
# or
$ yarn 
```

Then, you'll need to install the composer requirements:

```bash
$ cd src/
$ composer install
```

### .env

Then, within the src/ directory, you'll have to create a `.env` file.

```bash
$ cp .env.example .env
```
> You can access all variables everywhere in PHP with `$_ENV[]`

### scripts
From here, you're good to go. <br>
You have multiple scripts available.

| script | description |
|---|----|
| `yarn run build` | creates a development dist |
| `yarn run watch` | creates a development dist including FileWatcher and BrowserSync |
| `yarn run prod` | creates a production dist without the `.env` file |
| `yarn run prod:env` | creates a production dist including the `.env` file |


## Development
I would recommend using a docker container for development, but this is not needed and you can also use XAMP, MAMP, LAMP or something different. In the end you can use whatever you want.

> Make sure you have your webserver configured, that it points on `[my-awesome-project]/dist/` and the DocumentRoot is `[my-awesome-project]/dist/public/`.

> You also need to have `mod_rewrite` enabled.

### docker development sever
You can either use your own preferred container, or you just use this container from [webdevops](https://hub.docker.com/u/webdevops).

```bash
# create a MariaDB container
$ docker run --name mariadb -e MARIADB_ROOT_PASSWORD="[your-password]" -p 3306:3306 mariadb:latest

# create your dev container (you can also use ":latest" or any other PHP version >7.4)
$ docker run --name [my-awesome-project] -v [path/to/your/dist/folder/]:/app -e WEB_DOCUMENT_ROOT="/app/public" -p 80:80 -p 443:443 --link mariadb:[db-hostname] -d webdevops/php-apache-dev:7.4
```
> If you are on a unix based system and your docker containers won't work, make sure to **disable** or **stop** the local apache and mysql server or use different ports. 


## Database & Migrations
> This skeleton does **not** use the Eloquent Migrations.

Implemented in this project is the PHP migration from [Péter Képes](https://github.com/kepes).

If you want to create a new migration you just have to issue this commands.

```bash
$ cd database/
$ php migrate.php -c [table-name] ./migrations/
```

After that, there will be a generated file inside of the `database/migrations/` folder.
In this file you can then add a dump of a table.

### migrate automatically

You can migrate the database tables automatically just by changing the variable in the config and then call the path `/migrate` in the running application.

```dotenv
DB_MIGRATION_ENABLED=true
```

If you want to migrate a specific file and not the hole folder, you can simply call the URL `/migrate/[filename-without-extention]`.

> **Important** Do not forget to change the setting in the config back. Especially if you are on production.

### migrate manually

If you want to migrate the tables manually, you need CLI access.
Then you just have to do:

```bash
$ cd database/
$ php migrate.php -m [hostname] -u [username] -p [password] ./migrations/
```

In case you just want to migrate only one table, simply add the file to the command.
```bash
$ php migrate.php -m [hostname] -u [username] -p [password] ./migrations/[migration-filename].sql
```

## Going for production
> If you want to go for production make sure your webserver is configured correctly.

> **Attention:** Don't forget to update your credentials in the config.

The first step is to make some changes to the `.env` file.

```dotenv
# change the environment to production
APP_ENV=production

# turn all debug functions off
APP_DEBUG=false

# add the new domain (used for cookies)
APP_URL=my-domain.tld

# if you want to enable template caching
VIEW_CACHE=true
```

Then just build the project.

```bash
$ yarn run prod
# or
$ yarn run prod:env
```

## Help and Documentation
If you need any help on how to work with any of the Components, check out these docs.
- Slim Framework 3 ([Docs](http://www.slimframework.com/docs/v3/))
- Laravel Eloquent ORM ([Docs](https://laravel.com/docs/7.x/eloquent))
- Twig Template Engine ([Docs](https://twig.symfony.com/doc/3.x/))
- NPM ([Docs](https://docs.npmjs.com/), [Download](https://www.npmjs.com/get-npm))
- Yarn ([Docs](https://yarnpkg.com/cli/install), [Download](https://yarnpkg.com/getting-started/install))
- Composer ([Docs](https://getcomposer.org/doc/), [Download](https://getcomposer.org/download/))
- laravel-mix ([Docs](https://laravel-mix.com/))
- PHPMailer ([Docs](https://github.com/PHPMailer/PHPMailer))
- Carbon ([Docs](https://carbon.nesbot.com/))
- VarDumper ([Docs](https://symfony.com/doc/current/components/var_dumper.html))

## License
MIT License

Copyright (c) 2021 developaaah

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

## Way to important to be on the top
![](https://forthebadge.com/images/featured/featured-fuck-it-ship-it.svg)
![](https://forthebadge.com/images/featured/featured-gluten-free.svg)
![](https://forthebadge.com/images/featured/featured-built-with-love.svg)