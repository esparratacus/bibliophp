<?php

namespace BibliotecaModel;

class Event extends AbstractEntity {
    protected $_allowedFields = array(‘id’, ‘name’, ‘event_start’);

    public function setName($name)
    {
        if (!is_string($name) || strlen($name) < 2 || strlen($name) > 64) {
            throw new InvalidArgumentException('The title of the entry is invalid.');
        }
        $this->_values[‘name’] = $name;
    }
}