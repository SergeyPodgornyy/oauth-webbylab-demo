OAuth2 Demo PHP
===============

Installation
------------

Use [Composer](http://getcomposer.org/) to install required libraries:

```bash
    curl -s http://getcomposer.org/installer | php
    ./composer.phar install
```

### WebHost Configuration

#### Configure a Web Server

Be sure to run the command `$ chmod -R 777 data/` in the project root so that the web server can create the sqlite file.

#### Using PHP's built-in Web Server

You can use php's *built-in web server*, however, you will need to spin up **three instances** and them in `data/parameters.json` in order to prevent the server from locking up. The client will issue a request
to the server, and because PHP's built-in web server is single-threaded, this will result in deadlock.

```bash
    cp data/parameters.json.dist data/parameters.json
    sed -i '' 's?"grant"?"http://localhost:8081/lockdin/token"?g' data/parameters.json
    sed -i '' 's?"authorize"?"http://localhost:8081/lockdin/authorize"?g' data/parameters.json
    sed -i '' 's?"access"?"http://localhost:8081/lockdin/resource"?g' data/parameters.json
```

Now all you have to do is spin up **two separate web servers** in the `web` directory

```bash
    web
    php -S localhost:8000 & php -S localhost:8081
```

Browse to `http://localhost:8000` in your browser and you're all set!
