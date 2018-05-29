<?php

include_once dirname(__FILE__) . '/../User.php';


class UserMapper extends AbstractMapper {
    protected $_entityTable = 'User';
    protected $_entityClass = 'User';

    public function __construct(DatabaseAdapterInterface $adapter)
    {
        parent::__construct($adapter);
    }

<<<<<<< HEAD
    public function insert($entity, User $user=null)
=======
    public function insert($entity,User $user=null)
>>>>>>> 0d8eb845da93219a877560a5dd0139c4a1eb9a98
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

