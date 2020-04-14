SQLBoss
========


## Setup Docker Environment

### Rename docker-compose.override.yaml.example

```
mv docker-compose.override.yaml.example docker-compose.override.yaml
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

### Note: If developing locally change the quay image to local build

In docker-compose.yaml remove:
```
image: quay.io/illuminateeducation/sqlboss:master
```

and add:
```
build: .
```