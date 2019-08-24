<?php


namespace Jarosoft\Factory\Model;


interface Processor extends Printable {

    public function canDo(): bool;
    public function doIt();

}