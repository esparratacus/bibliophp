<?php
include_once dirname(__FILE__) . '/AbstractMapper.php';
include_once dirname(__FILE__) . '/ReservationMapper.php';
include_once dirname(__FILE__) . '/../CollectionProxy.php';
include_once dirname(__FILE__) . '/../Room.php';


class RoomMapper extends AbstractMapper {
    protected $_reservationMapper ;
    protected $_entityTable = 'rooms';
    protected $_entityClass = 'Room';
    public function __construct(DatabaseAdapterInterface $adapter,ReservationMapper $reservationMapper)
    {
        parent::__construct($adapter);
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

    protected function _createEntity(array $fields)
    {
        return new Room(array(
            'id'       => $fields['id'],
            'name'    => $fields['name'],
            'reservations' => new CollectionProxy($this->_reservationMapper,"room_id = ". $fields['id'])
        ));
    }    
}

