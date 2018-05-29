<?php

include_once dirname(__FILE__) . '/AbstractEntity.php';

class User extends AbstractEntity {
    protected $_allowedFields = array('id', 'username', 'email','password', 'is_admin');

    public function setUserName($name)
    {
        if (!is_string($name) || strlen($name) < 2 || strlen($name) > 64) {
            throw new InvalidArgumentException('Invalid user name.');
        }
        $this->_values['username'] = $name;
    }
}