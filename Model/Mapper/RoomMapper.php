<?php
include_once dirname(__FILE__) . '/AbstractMapper.php';
include_once dirname(__FILE__) . '/ReservationMapper.php';
include_once dirname(__FILE__) . '/../CollectionProxy.php';
include_once dirname(__FILE__) . '/../Room.php';


class RoomMapper extends AbstractMapper {
    protected $_reservationMapper ;
    protected $_entityTable = 'rooms';
    protected $_entityClass = 'Room';
    public function __construct(DatabaseAdapterInterface $adapter,ReservationMapper $reservationMapper=null)
    {
        parent::__construct($adapter);
        if(is_null($reservationMapper)){
            $reservationMapper = new ReservationMapper($adapter);
        }
        $this->_reservationMapper = $reservationMapper; 

    }

    public function getReservationMapper(){
        return $this->_reservationMapper;
    }
    public function delete($id,$col = 'id')
    {
        if ($id instanceof Room) {
            $id = $id->id;
        }
        $this->_adapter->delete($this->_entityTable, "id = $id");
    }

    public function insert($entity, Room $room=null)
    {
        return $this->_adapter->insert($this->_entityTable, $room->toArray());
    }

    public function update($entity)
    {
        if (!$entity instanceof $this->_entityClass) {
            throw new InvalidArgumentException('The entity to be updated must be an instance of'  . $this->_entityClass . '.');
        }
        $id = $entity->id;
        $data = $entity->toArray();
        return $this->_adapter->update($this->_entityTable, $data, "id = $id");
    }

    protected function _createEntity(array $fields)
    {
        return new Room(array(
            'id'       => $fields['id'],
            'name'    => $fields['name'],
            'capacity'    => $fields['capacity'],
            'reservations' => new CollectionProxy($this->_reservationMapper,"room_id = ". $fields['id'])
        ));
    }    
}

