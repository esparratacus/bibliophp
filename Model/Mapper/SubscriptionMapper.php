<?php

include_once dirname(__FILE__) . '/../Subscription.php';
include_once dirname(__FILE__) . '/EventMapper.php';
include_once dirname(__FILE__) . '/UserMapper.php';


class SubscriptionMapper extends AbstractMapper {
    protected $_entityTable = 'subscriptions';
    protected $_entityClass = 'Subscription';
    protected $_eventMapper;
    protected $_userMapper;
		
    public function __construct(DatabaseAdapterInterface $adapter)
    {
        parent::__construct($adapter);
        $this->_eventMapper = new EventMapper($adapter);
        $this->_userMapper = new UserMapper($adapter);
    }

    public function getEventMapper(){
        return $this->_eventMapper;
    }
    public function getUserMapper(){
        return $this->_userMapper;
    }

    public function insert($entity, Subscription $subscription=null)
    {
        return $this->_adapter->insert($this->_entityTable, $subscription->toArray());
    }

    public function delete($id,$col = 'id')
    {
        if ($id instanceof Subscription) {
            $id = $id->id;
        }
        $this->_adapter->delete($this->_entityTable, "id = $id");
    }


    protected function _createEntity(array $fields)
    {
        return new Subscription(array(
            'id'       => $fields['id'],
            'user_id'    => $fields['user_id'],
            'event_id'    => $fields['event_id'],
            'subscription_email'    => $fields['subscription_email'],
            'user' => new EntityProxy($this->_userMapper,$fields['user_id']),
            'event' => new EntityProxy($this->_eventMapper,$fields['event_id'])
        ));
    }    
}

