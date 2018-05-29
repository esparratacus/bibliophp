<?php
include_once dirname(__FILE__) . '/AbstractMapper.php';
//include_once dirname(__FILE__) . '/ReservationMapper.php';
include_once dirname(__FILE__) . '/../Reservation.php';


class ReservationMapper extends AbstractMapper {
    protected $_reservationMapper ;
    protected $_entityTable = 'reservations';
    protected $_entityClass = 'Reservation';
    public function __construct(DatabaseAdapterInterface $adapter)
    {
        parent::__construct($adapter);
        

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
        return $this->_adapter->insert($this->_entityTable, $reservation->toArray());
    }

    protected function _createEntity(array $fields)
    {
        return new Room(array(
            'id'       => $fields['id'],
            'reservation_starts'    => $fields['reservations_starts'],
            'reservation_ends'    => $fields['reservations_ends']
        ));
    }    
}

