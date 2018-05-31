<?php
include_once dirname(__FILE__) . '/../Event.php';

class EventMapper extends AbstractMapper {
    protected $_entityTable = 'events';
    protected $_entityClass = 'Event';

    public function __construct(DatabaseAdapterInterface $adapter)
    {
        parent::__construct($adapter);
    }

    public function insert($entity, Event $event=null)
    {
        return $this->_adapter->insert($this->_entityTable, $event->toArray());
    }

    public function delete($id,$col = 'id')
    {
        if ($id instanceof Event) {
            $id = $id->id;
        }
        $this->_adapter->delete($this->_entityTable, "id = $id");
    }

    protected function _createEntity(array $fields)
    {
        return new Event(array(
            'id'       => $fields['id'],
            'name'    => $fields['name'],
            'starts_at'  => $fields['starts_at'],
            'ends_at' => $fields['ends_at'],
            'location' => $fields['location']
        ));
    }    
}

