<?php

include_once dirname(__FILE__) . '/AbstractEntity.php';

class Equipment extends AbstractEntity {
    protected $_allowedFields = array('id', 'name', 'maker','serial_number','quantity');

    public function setName($name)
    {
        if (!is_string($name) || strlen($name) < 2 || strlen($name) > 64) {
            throw new InvalidArgumentException('The name of the entry is invalid.');
        }
        $this->_values['name'] = $name;
    }

    public function setmaker($maker)
    {
        if (!is_string($maker) || strlen($maker) < 2 || strlen($maker) > 64) {
            throw new InvalidArgumentException('The maker of the entry is invalid.');
        }
        $this->_values['maker'] = $maker;
    }

    public function setSerialNumber($serialNumber)
    {
        if (!is_string($serialNumber) || strlen($serialNumber) < 2 || strlen($serialNumber) > 64) {
            throw new InvalidArgumentException('The serialNumber of the entry is invalid.');
        }
        $this->_values['serial_number'] = $serialNumber;
    }

    public function setQuantity($quantity)
    {
        if (!is_numeric($quantity) || $quantity < 0 ) {
            throw new InvalidArgumentException('The quantity of the entry is invalid.');
        }
        $this->_values['quantity'] = $quantity;
    }
}