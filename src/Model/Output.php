<?php


namespace Jarosoft\Factory\Model;



interface Output {
    /**
     * @throws CannotGetException;
     * @return Item
     */
    public function get() : Item;
}