<?php


namespace Jarosoft\Factory\Model;


interface Processor extends Printable {

    public function canProcess(): bool;
    public function process();

}