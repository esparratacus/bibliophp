<?php

include_once dirname(__FILE__) . '/AbstractEntity.php';

class Book extends AbstractEntity {
    protected $_allowedFields = array('id', 'title', 'author','edition','publisher','isbn','copies');

    public function setTitle($title)
    {
        if (!is_string($title) || strlen($title) < 2 || strlen($title) > 64) {
            throw new InvalidArgumentException('The title of the entry is invalid.');
        }
        $this->_values['title'] = $title;
    }

    public function setAuthor($author)
    {
        if (!is_string($author) || strlen($author) < 2 || strlen($author) > 64) {
            throw new InvalidArgumentException('The title of the entry is invalid.');
        }
        $this->_values['author'] = $author;
    }

    public function setEdition($edition)
    {
        if (!is_string($edition) || strlen($edition) < 2 || strlen($edition) > 64) {
            throw new InvalidArgumentException('The edition of the entry is invalid.');
        }
        $this->_values['edition'] = $edition;
    }

    public function setPublisher($publisher)
    {
        if (!is_string($publisher) || strlen($publisher) < 2 || strlen($publisher) > 64) {
            throw new InvalidArgumentException('The publisher of the entry is invalid.');
        }
        $this->_values['publisher'] = $publisher;
    }

    public function setIsbn($isbn)
    {
        if (!is_string($isbn) || strlen($isbn) < 2 || strlen($isbn) > 64) {
            throw new InvalidArgumentException('The isbn of the entry is invalid.');
        }
        $this->_values['isbn'] = $isbn;
    }

    public function setCopies($copies)
    {
        if (!is_numeric($copies) || $copies < 0 ) {
            throw new InvalidArgumentException('The copies of the entry is invalid.');
        }
        $this->_values['copies'] = $copies;
    }
}