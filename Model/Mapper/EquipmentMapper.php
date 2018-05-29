<?php
include_once dirname(__FILE__) . '/AbstractMapper.php';
include_once dirname(__FILE__) . '/../Equipment.php';


class EquipmentMapper extends AbstractMapper {
    protected $_entityTable = 'equipment';
    protected $_entityClass = 'Equipment';
    public function __construct(DatabaseAdapterInterface $adapter)
    {
        parent::__construct($adapter);
    }

    public function delete($id,$col = 'id')
    {
        if ($id instanceof Equipment) {
            $id = $id->id;
        }
        $this->_adapter->delete($this->_entityTable, "id = $id");
    }

    public function insert($entity, Equipment $equipment=null)
    {
        return $this->_adapter->insert($this->_entityTable, $equipment->toArray());
    }

    protected function _createEntity(array $fields)
    {
        return new Equipment(array(
            'id'       => $fields['id'],
            'name'    => $fields['name'],
            'maker'  => $fields['maker'],
            'serial_number'  => $fields['serial_number'],
            'quantity'  => $fields['quantity']
        ));
    }    
}

