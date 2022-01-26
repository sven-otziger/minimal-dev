# Minimal PHP LEMP Stack

## Stack
- Nginx: [localhost:8099](http://localhost:8099)
- PHP: localhost:9003
- MariaDB: localhost:13306

Note: Change the PHP Version in the .env file

## Initial Setup

Create the .env file
On Linux
```sh
cp .env.example .env
```

On Windows
```cmd
copy .env.example .env
```

##Start the Development Environment
```
docker-composer up -d
```
