<?php

include_once dirname(__FILE__) . './Mapper/AbstractMapper.php';
abstract class AbstractProxy
{
    protected $_mapper;
    protected $_params;
   
    /**
     * Constructor
     */
    public function __construct(AbstractMapper $mapper, $params)
    {
        if (!is_string($params) || empty($params)) {
            throw new InvalidArgumentException('The mapper parameters are invalid.');
        }
        $this->_mapper = $mapper;
        $this->_params = $params; 
    }      
}