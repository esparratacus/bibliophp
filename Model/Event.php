<?php

include_once dirname(__FILE__) . '/AbstractEntity.php';

class Event extends AbstractEntity {
    protected $_allowedFields = array('id', 'name', 'starts_at','ends_at','location');

    
    public function setName($name)
    {
        if (!is_string($name) || strlen($name) < 2 || strlen($name) > 64) {
            throw new InvalidArgumentException('The title of the entry is invalid.');
        }
        $this->_values['name'] = $name;
    }
}