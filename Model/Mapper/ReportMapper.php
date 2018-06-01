<?php

include_once dirname(__FILE__) . '/../Report.php';


class ReportMapper extends AbstractMapper {

    protected $_entityTable = 'reports';
    protected $_entityClass = 'Report';

    public function __construct(DatabaseAdapterInterface $adapter)
    {
        parent::__construct($adapter);
    }


    public function insert($entity, Report $rental = null)
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

    public function findLastReport($user_id, $equipment_id)
    {
        $condition = "user_id = $user_id AND equipment_id = $equipment_id";
        $this->_adapter->select($this->_entityTable, $condition, "*", "id DESC", "1");
        $last_report = null;
        while ($data = $this->_adapter->fetch())
            $last_report = $this->_createEntity($data);
        return $last_report;
    }



    protected function _createEntity(array $fields)
    {
        return new Report(array(
            'id'       => $fields['id'],
            'state'    => $fields['state'],
            'comments'  => $fields['comments'],
            'equipment_id'  => $fields['equipment_id'],
            'user_id' => $fields['user_id'],
            'date' => $fields['date'],
        ));
    }    
}

