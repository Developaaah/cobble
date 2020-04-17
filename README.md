# cobble
![License](https://img.shields.io/badge/Licence-MIT-27ae60.svg?style=for-the-badge)
![BuiltWith](https://img.shields.io/badge/built%20with-PHP-34495e.svg?style=for-the-badge)
![Version](https://img.shields.io/badge/version-1.0.2-e67e22.svg?style=for-the-badge)

[![Chat](https://img.shields.io/badge/Chat%20with%20me-Discord-3498db.svg?style=for-the-badge)](https://discord.gg/u8EQVxf)

![Twitter Follow](https://img.shields.io/twitter/follow/developaaah?color=3498db&label=Follow%20Me%20on%20Twitter&style=for-the-badge)


Cobble is a framework skeleton using Slim Framework 3, Laravel Eloquent ORM, Twig Template Engine and Whoops for error reporting.
<br>
> In the examples in this README I'll be using `yarn` but you can also use `npm`.

## Requirements
- PHP >=7.3.*
- Apache/nginx (mod_rewrite needed)
- composer (for development)
- npm/yarn (for gulp)


## Create project
Run this command to create your project based on this skeleton.

```bash
git clone https://github.com/Developaaah/cobble.git [my-awesome-project]
```

If you want to use git in your project, just follow these steps:

```bash
cd [my-awesome-project]
rm -rf .git/
git init
```

After you did this, you can use it as you want.

## Installation
> You have to be in the directory of the cloned directory ( `cd [my-awesome-project]` )

First, you need to install all required node modules by typing:

```bash
yarn 
```

After you have done this, you can install all composer requirements

```bash
cd src/
composer install
```

### .env file
Don't forget to add a `.env` file based on the `.env.example`.

```bash
cp .env.example .env
```

Your development `.env` file should look like this or something similar.

```
APP_NAME=My Awesome App
APP_ENV=development
APP_DEBUG=true
APP_URL=http://localhost

DB_MIGRATION_ENABLED=true
DB_DRIVER=mysql
DB_HOST=database
DB_PORT=3306
DB_DATABASE=mydatabase
DB_USERNAME=root
DB_PASSWORD=toor
DB_CHARSET=utf-8

VIEW_CACHE=false
VIEW_CACHE_PATH=storage/views/
```

## Development
I would recommend using a docker container for development, but this is not needed and you can also use XAMP, MAMP, LAMP or something different. In the end you can use whatever you want.

> Make sure you have your webserver configured, that it points on `[my-awesome-project]/dist/` and the DocumentRoot is `[my-awesome-project]/dist/public/`.

> You also need to have `mod_rewrite` enabled.

Then you can start building your first development build

```bash
cd ..
yarn run build
```

In case you don't have the `.env` file in the `dist` directory you can add this by typing the following.

```bash
yarn run moveenv
```

### Live sync while development
If you want to use live sync to automaticlly update your page while development, you have to make sure, you have the make sure, that your webserver is up and running and then type in the following command in the root directory of the project.

```bash
yarn run watch
```

### After going to production

When you just went into production and want to go back to development, you should clean the dist directory first.

```bash
rm -rf dist/

or 

yarn run clean
``` 

## Database & Migrations
> This skeleton does **not** use the Eloquent Migrations.

Implemented in this project is the PHP migration from [Péter Képes](https://github.com/kepes).

If you want to create a new migration you just have to issue this commands.

```bash
cd database/
php migrate.php -c [table-name] ./migrations/
```

After that, there will be a generated file inside of the `migrations/` folder.
In this file you can then add a dump of a database table.

### Migrate automatically

You can migrate the database tables automatically just by changing the variable in the config and then call the path `/migrate` in the running application.

```bash
DB_MIGRATION_ENABLED=true
```

If you want to migrate a specific file and not the hole folder, you can simply call the URL `/migrate/[filename-without-extention]`.

> **Important** Do not forget to change the setting in the config back. Especially if you are on production.

### Migrate manually

If you want to migrate the tables manually, you need CLI access.
Then you just have to do:

```bash
cd database/
php migrate.php -m [hostname] -u [username] -p [password] ./migrations/
```

In case you just want to migrate only one table, simply add the file to the command.
```bash
php migrate.php -m [hostname] -u [username] -p [password] ./migrations/[migration-filename].sql
```

## Going for production
If you want to go for production make sure, your webserver, where you want to deploy the application is configured correctly.

As the first step for your deployment process, build a production version of the site

```bash
yarn run build:prod
```

> In case you deploy your website for the first time, make sure you add your `.env` file to the dist directory ( `yarn run moveenv` ).

Before you can go live, you need to make some changes to the `.env` file.

First, you need to change the environment to production and disable the debug messages.

```
APP_ENV=production
APP_DEBUG=false
```

In case, you use the APP_URL somewhere in your application, don't forget to change it in the config.

```
APP_URL=https://my-awesome-project.com/
```

If you want to cache your templates, you also have to enable it.
```
VIEW_CACHE=true
```

> **Attention:** Dont forget to update your Database credentials in the config, if you use a database in your project.

## Help and Documentation
If you need any help on how to work with any of the Components, check out these docs.
- Slim Framework 3 ([Docs](http://www.slimframework.com/docs/v3/))
- Laravel Eloquent ORM ([Docs](https://laravel.com/docs/7.x/eloquent))
- Twig Template Engine ([Docs](https://twig.symfony.com/doc/3.x/))
- Gulp ([Docs](https://gulpjs.com/docs/en/getting-started/quick-start))
- NPM ([Docs](https://docs.npmjs.com/), [Download](https://www.npmjs.com/get-npm))
- Yarn ([Docs](https://yarnpkg.com/cli/install), [Download](https://yarnpkg.com/getting-started/install))
- Composer ([Docs](https://getcomposer.org/doc/), [Download](https://getcomposer.org/download/))

## License
MIT License

Copyright (c) 2020 developaaah

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