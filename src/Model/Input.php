<?php


namespace Jarosoft\Factory\Model;


interface Input {
    /**
     * @throws CannotPutException;
     * @return Item
     */
    public function put(Item $item);
}