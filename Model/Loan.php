<?php

include_once dirname(__FILE__) . '/AbstractEntity.php';

class Loan extends AbstractEntity {
    protected $_allowedFields = array('id', 'user_id', 'book_id','pickup_date','return_date','is_approved','status', 'book','user');

    public function setStatus($status)
    {
        $this->_values['status']=$status;
    }
    public function setReturnDate($return_date)
    {
        if ($this->validateDate($return_date)) {
            throw new InvalidArgumentException('The return date of the loan is invalid.');
        }
        $this->_values['return_date'] = date("Y-m-d", strtotime($return_date));
    }

    public function setPickupDate($return_date)
    {
        if ($this->validateDate($return_date)) {
            throw new InvalidArgumentException('The pickup date of the loan is invalid.');
        }
        $this->_values['pickup_date'] = date("Y-m-d", strtotime($return_date));
    }

    public function setUser(EntityProxy $user){
        $this->_values['user'] = $user;
    }

    public function setBook(EntityProxy $book){
        $this->_values['book'] = $book;
    }
    function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $date;
    }
    
}