<?php

include_once dirname(__FILE__) . '/MapperInterface.php';
include_once dirname(__FILE__) . '../../Database/MysqlAdapter.php';

abstract class AbstractMapper implements MapperInterface{
    protected $_adapter;
    protected $_entityTable;
    protected $_entityClass;

    
    public function __construct(DatabaseAdapterInterface $adapter, array $entityOptions = array())
    {
        $this->_adapter = $adapter;
        // set the entity table is the option has been specified
        if (isset($entityOptions[‘entityTable’])) {
            $this->setEntityTable($entityOtions[‘entityTable’]);
        }
        // set the entity class is the option has been specified
        if (isset($entityOptions[‘entityClass’])) {
            $this->setEntityClass($entityOtions[‘entityClass’]);
        }
        // check the entity options
        $this->_checkEntityOptions();
    }

    protected function _checkEntityOptions()
    {
        if (!isset($this->_entityTable)) {
            throw new RuntimeException('The entity table has not been set yet.');
        }
        if (!isset($this->_entityClass)) {
            throw new RuntimeException('The entity class has been not set yet.');
        }
    }

    public function getAdapter()
    {
        return $this->_adapter;
    }

    public function setEntityTable($entityTable)
    {
        if (!is_string($table) || empty($entityTable)) {
            throw new InvalidArgumentException('The entity table is invalid.');
        }
        $this->_entityTable = $entityTable;
        return $this;
    }

    public function getEntityTable()
    {
        return $this->_entityTable;
    }

    public function setEntityClass($entityClass)
    {
        if (!is_subclass_of($entityClass, 'BlogModelAbstractEntity')) {
            throw new InvalidArgumentException('The entity class is invalid.');
        }
        $this->_entityClass = $entityClass;
        return $this;
    }

    public function getEntityClass()
    {
        return $this->_entityClass;
    }

    public function findById($id)
    {
        $this->_adapter->select($this->_entityTable, "id =". $id);
        if ($data = $this->_adapter->fetch()) {
            return $this->_createEntity($data);
        }
        return null;
    }

    public function find($conditions = '')
    {
        $collection = new CollectionEntityCollection;
        $this->_adapter->select($this->_entityTable, $conditions);
        while ($data = $this->_adapter->fetch()) {
            $collection[] = $this->_createEntity($data);
        }
        return $collection;
    }

    public function insert($entity)
    {
        if (!$entity instanceof $this->_entityClass) {
            throw new InvalidArgumentException('The entity to be inserted must be an instance of ' . $this->_entityClass . ‘.’);
        }
        return $this->_adapter->insert($this->_entityTable, $entity->toArray());
    }

    public function update($entity)
    {
        if (!$entity instanceof $this->_entityClass) {
            throw new InvalidArgumentException('The entity to be updated must be an instance of'  . $this->_entityClass . ‘.’);
        }
        $id = $entity->id;
        $data = $entity->toArray();
        unset($data[‘id’]);
        return $this->_adapter->update($this->_entityTable, $data, "id = $id");
    }

    public function delete($id, $col = ‘id’)
    {
        if ($id instanceof $this->_entityClass) {
            $id = $id->id;
        }
        return $this->_adapter->delete($this->_entityTable, "$col = $id");
    }

    abstract protected function _createEntity(array $data);
}