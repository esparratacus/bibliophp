<?php

include_once dirname(__FILE__) . '/AbstractEntity.php';

class User extends AbstractEntity {
    protected $_allowedFields = array('id', 'username', 'email','password', 'admin');

    public function setUsername($username)
    {
        if (!is_string($username) || strlen($username) < 2 || strlen($username) > 64) {
            throw new InvalidArgumentException('Invalid user username.');
        }
        $this->_values['username'] = $username;
    }
    public function setEmail($email)
    {
        if (!is_string($email) || strlen($email) < 2 || strlen($email) > 64) {
            throw new InvalidArgumentException('Invalid user email.');
        }
        $this->_values['email'] = $email;
    }
    
}