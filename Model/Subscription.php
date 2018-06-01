<?php

include_once dirname(__FILE__) . '/AbstractEntity.php';

class Subscription extends AbstractEntity {
    protected $_allowedFields = array('id', 'user_id','event_id', 'subscription_email', 'user', 'event');

    public function setUser(EntityProxy $user){
        $this->_values['user'] = $user;
    }

    public function setEvent(EntityProxy $event){
        $this->_values['room'] = $event;
    }


}