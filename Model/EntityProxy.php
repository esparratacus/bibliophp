<?php
include_once dirname(__FILE__) . '/AbstractProxy.php';
include_once dirname(__FILE__) . '/LoadableInterface.php';

class EntityProxy extends AbstractProxy implements LoadableInterface
{
    protected $_entity;
   
    /**
     * Load an entity via the ‘findById()’ method of the injected mapper
     */
    public function load()
    {
        if ($this->_entity === null) {
            $this->_entity = $this->_mapper->findById($this->_params);
            if (!$this->_entity instanceof AbstractEntity) {
                throw new RunTimeException('Unable to load the specified entity.');
            }
        }
        return $this->_entity;
    }  
}