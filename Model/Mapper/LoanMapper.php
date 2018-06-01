<?php

include_once dirname(__FILE__) . '/../Loan.php';
include_once dirname(__FILE__) . '/UserMapper.php';
include_once dirname(__FILE__) . '/BookMapper.php';


class LoanMapper extends AbstractMapper {
    protected $_userMapper;
    protected $_book_mapper;
    protected $_entityTable = 'loans';
    protected $_entityClass = 'Loan';

    public function __construct(DatabaseAdapterInterface $adapter)
    {
        parent::__construct($adapter);
        $this->_userMapper = new UserMapper($adapter);
        $this->_bookMapper = new BookMapper($adapter);
    }

    public function getBookMapper(){
        return $this->_bookMapper;
    }

    public function getUserMapper(){
        return $this->_userMapper;
    }


    public function insert($entity,Loan $loan=null)
    {
        return $this->_adapter->insert($this->_entityTable, $loan->toArray());
    }

    public function delete($id,$col = 'id')
    {
        if ($id instanceof Loan) {
            $id = $id->id;
        }
        $this->_adapter->delete($this->_entityTable, "id = $id");
    }
    public function update($entity)
    {
        if (!$entity instanceof $this->_entityClass) {
            throw new InvalidArgumentException('The entity to be updated must be an instance of'  . $this->_entityClass . '.');
        }
        $id = $entity->id;
        $data = $entity->toArray();
        unset($data['id']);
        unset($data['user']);
        unset($data['book']);
        return $this->_adapter->update($this->_entityTable, $data, "id = $id");
    }

    protected function _createEntity(array $fields)
    {
        return new Loan(array(
            'id'       => $fields['id'],
            'book_id'    => $fields['book_id'],
            'user_id'  => $fields['user_id'],
            'status' => $fields['status'],
            'is_approved' => $fields['is_approved'],
            'return_date' => $fields['return_date'],
            'pickup_date' => $fields['pickup_date'],
            'user'  => new EntityProxy($this->_userMapper,$fields['user_id']),
            'book'  => new EntityProxy($this->_bookMapper,$fields['book_id'])
        ));
    }    
}

