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

### Update Google Configs

```
cp Config/google.php.default Config/google.php
```

Replace client id and secret placeholders with valid api credentials in google.php.
```
'GOOGLE_OAUTH_CLIENT_ID' => 'client_id',
'GOOGLE_OAUTH_CLIENT_SECRET' => 'client_secret',
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

Replace your email address with 'your_username'.
```
docker-compose exec php Vendor/cakephp/cakephp/lib/Cake/Console/cake user create your_username admin
```
