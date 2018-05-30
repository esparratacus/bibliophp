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

    public function insert($entity,User $user=null)
    {
        return $this->_adapter->insert($this->_entityTable, $user->toArray());
    }

    public function delete($id,$col = 'id')
    {
        if ($id instanceof Loan) {
            $id = $id->id;
        }
        $this->_adapter->delete($this->_entityTable, "id = $id");
    }

    protected function _createEntity(array $fields)
    {
        return new Loan(array(
            'id'       => $fields['id'],
            'book_id'    => $fields['book_id'],
            'user_id'  => $fields['user_id'],
            'status' => $fields['status'],
            'is_approved' => $fields['is_approved'],
            'user'  => new EntityProxy($this->_userMapper,$fields['user_id']),
            'book'  => new EntityProxy($this->_bookMapper,$fields['book_id'])
        ));
    }    
}

