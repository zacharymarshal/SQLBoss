SQLBoss
========


## Setup Docker Environment

### Rename docker-compose.override.yaml.example

```
cp docker-compose.override.yaml.example docker-compose.override.yaml
cp Config/database.php.default Config/database.php
cp Config/core.php.docker Config/core.php
bower install
```

### Run docker-compose

```
make compose
```

### Run migrations

```
make migration
```

### Make admin user

Username will be `admin` and it will prompt you to input a new password.
```
make user
```
