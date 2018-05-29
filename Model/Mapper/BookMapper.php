<?php
include_once dirname(__FILE__) . '/AbstractMapper.php';
include_once dirname(__FILE__) . '/../Book.php';


class BookMapper extends AbstractMapper {
    protected $_entityTable = 'books';
    protected $_entityClass = 'Book';
    public function __construct(DatabaseAdapterInterface $adapter)
    {
        parent::__construct($adapter);
    }

    public function delete($id,$col = 'id')
    {
        if ($id instanceof Book) {
            $id = $id->id;
        }
        $this->_adapter->delete($this->_entityTable, "id = $id");
    }

    public function insert($entity, Book $book=null)
    {
        return $this->_adapter->insert($this->_entityTable, $book->toArray());
    }

    protected function _createEntity(array $fields)
    {
        return new Book(array(
            'id'       => $fields['id'],
            'title'    => $fields['title'],
            'author'  => $fields['author'],
            'publisher'  => $fields['publisher'],
            'edition'  => $fields['edition'],
            'isbn'  => $fields['isbn'],
            'copies'  => $fields['copies']
        ));
    }    
}

