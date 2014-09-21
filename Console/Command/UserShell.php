<?php

App::uses('AppShell', 'Console/Command');

class UserShell extends AppShell
{
    public $uses = array('User');

    public function create()
    {
        $username    = $this->args[0];
        $access_role = $this->args[1];

        if (!empty($this->params['password'])) {
            $password = $this->params['password'];
        } else {
            system('stty -echo');
            echo "New Password for {$username}: ";
            $password = trim(fgets(STDIN));
            echo "\n";
            system('stty echo');
        }

        $user_data = array(
            'username'    => $username,
            'password'    => $password,
            'access_role' => $access_role,
        );

        $this->User->create();
        if ($this->User->save($user_data)) {
            $this->out(__("User {$username} created"));
            return $this->_stop();
        } else {
            foreach ($this->User->validationErrors as $field => $field_errors) {
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
            'help' => __('The password to use for the new user'),
        );

        $parser->addSubcommand(
            'create',
            array(
                'help' => __('Create a user'),
                'parser' => array(
                    'options' => compact('password'),
                    'arguments' => array(
                        'username' => array(
                            'help' => __('Name of the user to create'),
                            'required' => true,
                        ),
                        'access_role' => array(
                            'help' => __('The access role to use for the new user'),
                            'required' => true,
                            'choices' => array('admin', 'limited'),
                        ),
                    )
                )
            )
        );

        return $parser;
    }
}
