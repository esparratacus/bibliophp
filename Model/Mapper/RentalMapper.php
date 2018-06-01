<?php

include_once dirname(__FILE__) . '/../Rental.php';
//include_once dirname(__FILE__) . '/UserMapper.php';
include_once dirname(__FILE__) . '/EquipmentMapper.php';


class RentalMapper extends AbstractMapper {
    protected $_equipmentMapper;
    protected $_entityTable = 'rentals';
    protected $_entityClass = 'Rental';

    public function __construct(DatabaseAdapterInterface $adapter)
    {
        parent::__construct($adapter);
        $this->_equipmentMapper = new EquipmentMapper($adapter);
    }

    public function getEquipmentMapper(){
        return $this->_equipmentMapper;
    }


    public function insert($entity, Rental $rental = null)
    {
        return $this->_adapter->insert($this->_entityTable, $rental->toArray());
    }

    public function delete($id,$col = 'id')
    {
        if ($id instanceof Rental) {
            $id = $id->id;
        }
        $this->_adapter->delete($this->_entityTable, "id = $id");
    }

    public function findByUserApproved($user_id)
    {
        return $this->find("user_id = '$user_id' AND status = 'approved'");
    }
    public function findApproved()
    {
        return $this->find("status = 'approved'");
    }

    protected function _createEntity(array $fields)
    {
        return new Rental(array(
            'id'       => $fields['id'],
            'equipment_id'    => $fields['equipment_id'],
            'user_id'  => $fields['user_id'],
            'equipment'  => new EntityProxy($this->_equipmentMapper,$fields['equipment_id']),
            'status' => $fields['status'],
            'is_approved' => $fields['is_approved'],
            'creation_date' => $fields['creation_date'],
            'report_interval' => $fields['report_interval'],
        ));
    }    
}

