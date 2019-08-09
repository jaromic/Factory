<?php


namespace Jarosoft\Factory\Model;



abstract class Item {
    public function __toString() {
        return __CLASS__;
    }
}