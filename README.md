SQLBoss2
========

```
cp Config/database.php.default Config/database.php
cp Config/core.php.default Config/core.php
# Create your database and Update database.php
Vendor/cakephp/cakephp/lib/Cake/Console/cake schema create
Vendor/cakephp/cakephp/lib/Cake/Console/cake schema create sessions
bower install
```

Go into UsersController and add the ability to add a new user:

```
public function beforeFilter()
{
    parent::beforeFilter();
    $this->Auth->allow('add');
}
```

Go to ```/users/add``` and add your default admin users. Remove the beforeFilter() after you are done.

Run local server
```
sudo Vendor/cakephp/cakephp/lib/Cake/Console/cake server -p 8888
```