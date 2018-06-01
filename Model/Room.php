<?php

include_once dirname(__FILE__) . '/AbstractEntity.php';

class Room extends AbstractEntity {
    protected $_allowedFields = array('id', 'name','reservations');
    
    public function setName($name)
    {
        if (!is_string($name) || strlen($name) < 2 || strlen($name) > 64) {
            throw new InvalidArgumentException('The name of the entry is invalid.');
        }
        $this->_values['name'] = $name;
    }
    
    public function setReservations(CollectionProxy $reservations){
        $this->_values['reservations'] = $reservations;
    }

}