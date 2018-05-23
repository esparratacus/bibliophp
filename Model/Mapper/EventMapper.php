<?php

namespace BibliotecaModelMapper;
use BibliotecaDatabase, BibliotecaModel;

class EventMapper extends AbstractMapper {
    protected $_entityTable = ‘events’;

    public function __construct(DatabaseAdapterInterface $adapter)
    {
        parent::__construct($adapter);
    }

    public function insert(Event $event)
    {
        return $this->_adapter->insert($this->_entityTable, $entry->toArray());
    }

    public function delete($id)
    {
        if ($id instanceof Event) {
            $id = $id->id;
        }
        $this->_adapter->delete($this->_entityTable, "id = $id");
    }

    protected function _createEntity(array $fields)
    {
        return new Event(array(
            ‘id’       => $fields[‘id’],
            ‘name’    => $fields[‘title’],
            ‘event_start’  => $fields[‘event_start’]
        ));
    }    
}

