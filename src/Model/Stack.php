<?php

namespace Jarosoft\Factory\Model;

use Jarosoft\Factory\Exception\CannotGetException;

class Stack implements Input, Output, Printable {

    /**
     * @var Item[]
     */
    private $items;

    /**
     * Stack constructor.
     * @param Item $item
     * @param int $size
     */
    public function __construct(Item $item, int $size) {
        $this->items=[];
        while(count($this->items)<$size) {
            array_push($this->items, clone $item);
        }
    }

    /**
     * @return Item
     */
    public function get(): Item {
        $result = array_pop($this->items);
        if(!$result) {
            throw new CannotGetException();
        }
        return $result;
    }

    /**
     * @param Item $item
     */
    public function put(Item $item) {
        array_push($this->items, $item);
    }

    public function __toString() {
        $itemCount = count($this->items);
        return __CLASS__."[{$itemCount}]";
    }
}