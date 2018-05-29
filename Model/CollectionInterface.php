<?php
interface CollectionInterface extends Countable, IteratorAggregate, ArrayAccess
{
    public function toArray();

    public function clear();

    public function reset();

    public function add($key, ModelAbstractEntity $entity);
   
    public function get($key);

    public function remove($key);

    public function exists($key);
}