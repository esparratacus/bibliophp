<?php
include_once dirname(__FILE__) . '/AbstractProxy.php';
include_once dirname(__FILE__) . '/LoadableInterface.php';

class CollectionProxy extends AbstractProxy implements LoadableInterface,Countable, IteratorAggregate
{
    protected $_collection;
   
    /**
     * Load explicitly a collection of entities via the ‘find()’ method of the injected mapper
     */
    public function load()
    {
        if ($this->_collection === null) {
            $this->_collection = $this->_mapper->find($this->_params);
            if (!$this->_collection instanceof EntityCollection) {
                throw new RunTimeException('Unable to load the specified collection.');
            }
        }
        return $this->_collection;
    }
   
    /**
     * Count the entities in the collection after lazy-loading them
     */
    public function count()
    {
        return count($this->load());
    } 
   
    /**
     * Load a collection of entities via the ‘find()’ method of the injected mapper
     * when called within a ‘foreach’ construct
     */
    public function getIterator()
    {
        return $this->load();
    }   
}