<?php

include_once dirname(__FILE__) . '/AbstractEntity.php';

class Report extends AbstractEntity {
    protected $_allowedFields = array('id', 'state', 'comments','equipment_id','user_id');



    
}