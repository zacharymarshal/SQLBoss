<?php

App::uses('AppShell', 'Console/Command');

class ConnectionShell extends AppShell
{
    public $uses = array('Connection', 'User');

    public function create()
    {
        list(
            $label,
            $sqlboss_username,
            $db_driver,
            $db_host,
            $db_username
        ) = $this->args;

        if (!empty($this->params['password'])) {
            $password = $this->params['password'];
        } else {
            system('stty -echo');
            echo "Password for DB server {$db_username}@{$db_host}: ";
            $password = trim(fgets(STDIN));
            echo "\n";
            system('stty echo');
        }

        $user = $this->User->find(
            'first',
            array(
                'conditions' => array('User.username' => $sqlboss_username),
            )
        );

        if (empty($user['User']['id'])) {
            $this->err(__("SQLBoss user with username '{$sqlboss_username}' could not be found"));
            return $this->_stop(1);
        }

        $connection_data = array(
            'label'    => $label,
            'user_id'  => $user['User']['id'],
            'username' => $db_username,
            'password' => $password,
            'host'     => $db_host,
            'driver'   => $db_driver,
        );

        $this->Connection->create();
        if ($this->Connection->save($connection_data)) {
            $this->out(__("Connection {$label} created successfully for {$sqlboss_username}"));
            return $this->_stop();
        } else {
            foreach ($this->Connection->validationErrors as $field => $field_errors) {
                foreach ($field_errors as $error) {
                    $this->err(__($error));
                }
            }
            return $this->_stop(1);
        }
    }

    public function getOptionParser()
    {
        $parser = parent::getOptionParser();

        $password = array(
            'help' => __('The password to use for connecting to the DB server'),
        );

        $parser->addSubcommand(
            'create',
            array(
                'help' => __('Create a connection'),
                'parser' => array(
                    'options' => compact('password', 'database'),
                    'arguments' => array(
                        'label' => array(
                            'help' => __('The label to use for the connection'),
                            'required' => true,
                        ),
                        'sqlboss_username' => array(
                            'help' => __('The username of the SQLBoss user to associate the connection with'),
                            'required' => true,
                        ),
                        'db_driver' => array(
                            'help' => __('The access role to use for the new user'),
                            'required' => true,
                            'choices' => array('pgsql', 'sqlite', 'mysql'),
                        ),
                        'db_host' => array(
                            'help' => __('The host to use when connecting to the DB server'),
                            'required' => true,
                        ),
                        'db_username' => array(
                            'help' => __('The username to use when connecting to the DB server'),
                            'required' => true,
                        ),
                    )
                )
            )
        );

        return $parser;
    }
}
