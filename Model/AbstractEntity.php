<?php



abstract class AbstractEntity {
    protected $_values = array();
    protected $_allowedFields = array(); 

    public function __construct(array $fields)
    {
        foreach ($fields as $name => $value) {
            $this->$name = $value;
        }
    }

    public function __set($name, $value)
    {
        if (!in_array($name, $this->_allowedFields)) {
            throw new InvalidArgumentException("Setting the field '$name' is not allowed for this entity. Allowed fields are: ". var_dump($_allowedFields) . "END") ; 
        }
        $mutator = "set" . ucfirst($name);
        if (method_exists($this, $mutator) && is_callable(array($this, $mutator))) {
            $this->$mutator($value);          
        }
        else {
            $this->_values[$name] = $value;
        }       
    }

    public function __get($name)
    {
        if (!in_array($name, $this->_allowedFields)) {
            throw new InvalidArgumentException("Getting the field '$name' is not allowed for this entity.");
        }
        $accessor = "get" . ucfirst($name);
        if (method_exists($this, $accessor) && is_callable(array($this, $accessor))) {
            return $this->$accessor;   
        }
        if (isset($this->_values[$name])) {
            return $this->_values[$name];  
        }
        throw new InvalidArgumentException("The field '$name' has not been set for this entity yet.");   
    }

    public function __isset($name)
    {
        if (!in_array($name, $this->_allowedFields)) {
            throw new InvalidArgumentException("The field '$name' is not allowed for this entity.");
        }
        return isset($this->_values[$name]);
    }

    public function __unset($name)
    {
        if (!in_array($name, $this->_allowedFields)) {
            throw new InvalidArgumentException("Unsetting the field '$name' is not allowed for this entity.");
        }
        if (isset($this->_values[$name])) {
            unset($this->_values[$name]);
            return true;
        }
        throw new InvalidArgumentException("The field '$name' has not been set for this entity yet.");
    }

    public function toArray()
    {
        return $this->_values;
    }    
}