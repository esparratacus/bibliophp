<?php

include_once dirname(__FILE__) . '/AbstractEntity.php';

class Rental extends AbstractEntity {
    protected $_allowedFields = array('id', 'user_id', 'equipment_id','creation_date','return_date','status','is_approved','report_interval', 'user','equipment');


    public function setReturnDate($return_date)
    {
        if ($this->validateDate($return_date)) {
            throw new InvalidArgumentException('The return date of the loan is invalid.');
        }
        $this->_values['return_date'] = date("Y-m-d", strtotime($return_date));
    }


    public function setEquipment(EntityProxy $equipment){
        $this->_values['equipment'] = $equipment;
    }
    function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $date;
    }
    
}