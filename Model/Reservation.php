<?php

include_once dirname(__FILE__) . '/AbstractEntity.php';

class Reservation extends AbstractEntity {
    protected $_allowedFields = array('id', 'reservation_starts','reservation_ends','room_id','status','is_approved','user_id','user','room');

    public function setReservationStarts($reservation_starts)
    {
        if ($this->validateDate($reservation_starts)) {
            throw new InvalidArgumentException('The reservation_starts of the entry is invalid.');
        }
        $this->_values['reservation_starts'] = date("Y-m-d H:i:s", strtotime($reservation_starts));
    }

    public function setReservationEnds($reservation_ends)
    {
        if ($this->validateDate($reservation_ends)) {
            throw new InvalidArgumentException('The reservation_ends of the entry is invalid.');
        }
        $this->_values['reservation_ends'] = date("Y-m-d H:i:s", strtotime($reservation_ends));
    }

    public function setIsApproved($isApproved)
    {
        $this->_values['is_approved'] = $isApproved;
    }
    public function setStatus($status)
    {
        $this->_values['status'] = $status;
    }

    public function setUser(EntityProxy $user){
        $this->_values['user'] = $user;
    }

    public function setRoom(EntityProxy $room){
        $this->_values['room'] = $room;
    }


    function validateDate($date, $format = 'Y-m-d H:i:s')
{
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($format) === $date;
}

}