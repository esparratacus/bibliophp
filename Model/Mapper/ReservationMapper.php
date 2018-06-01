<?php
include_once dirname(__FILE__) . '/AbstractMapper.php';
include_once dirname(__FILE__) . '/RoomMapper.php';
include_once dirname(__FILE__) . '/UserMapper.php';
include_once dirname(__FILE__) . '/../Reservation.php';


class ReservationMapper extends AbstractMapper {
    protected $_reservationMapper ;
    protected $_roomMapper;
    protected $_userMapper;
    protected $_entityTable = 'reservations';
    protected $_entityClass = 'Reservation';
    public function __construct(DatabaseAdapterInterface $adapter)
    {
        parent::__construct($adapter);
        $this->_roomMapper = new RoomMapper($adapter,$this);
        $this->_userMapper = new UserMapper($adapter);
    }

    public function getRoomMapper(){
        return $this->_roomMapper;
    }
    public function getUserMapper(){
        return $this->_userMapper;
    }
    public function delete($id,$col = 'id')
    {
        if ($id instanceof Reservation) {
            $id = $id->id;
        }
        $this->_adapter->delete($this->_entityTable, "id = $id");
    }

    public function insert($entity, Reservation $reservation=null)
    {
        $data=$reservation->toArray();
        unset($data['room']);
        unset($data['user']);
        return $this->_adapter->insert($this->_entityTable, $reservation->toArray());
    }
    public function update($entity)
    {
        if (!$entity instanceof $this->_entityClass) {
            throw new InvalidArgumentException('The entity to be updated must be an instance of'  . $this->_entityClass . '.');
        }
        $id = $entity->id;
        $data = $entity->toArray();
        unset($data['id']);
        unset($data['room']);
        unset($data['user']);
        return $this->_adapter->update($this->_entityTable, $data, "id = $id");
    }

    protected function _createEntity(array $fields)
    {
        return new Reservation(array(
            'id'       => $fields['id'],
            'reservation_starts'    => $fields['reservation_starts'],
            'reservation_ends'    => $fields['reservation_ends'],
            'user_id' => $fields['user_id'],
            'room_id' => $fields['room_id'],
            'user' => new EntityProxy($this->_userMapper,$fields['user_id']),
            'room' => new EntityProxy($this->_roomMapper,$fields['room_id'])
        ));
    }    
}

