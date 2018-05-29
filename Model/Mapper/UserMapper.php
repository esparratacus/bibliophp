<?php

include_once dirname(__FILE__) . '/../User.php';


class UserMapper extends AbstractMapper {
    protected $_entityTable = 'User';
    protected $_entityClass = 'User';

    public function __construct(DatabaseAdapterInterface $adapter)
    {
        parent::__construct($adapter);
    }

    public function insert($entity,User $user=null)
    {
        return $this->_adapter->insert($this->_entityTable, $user->toArray());
    }

    public function delete($id,$col = 'id')
    {
        if ($id instanceof User) {
            $id = $id->id;
        }
        $this->_adapter->delete($this->_entityTable, "id = $id");
    }

    protected function _createEntity(array $fields)
    {
        return new User(array(
            'Id'       => $fields['Id'],
            'FullName'    => $fields['FullName'],
            'Email'  => $fields['Email'],
            'Password'  => $fields['Password']
        ));
    }    
}

