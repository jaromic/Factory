<?php

namespace Jarosoft\Factory\Model;

use Jarosoft\Factory\Exception\CannotGetException;
use Jarosoft\Factory\Exception\CannotPutException;

class Conveyor implements Processor {

    private $belt;
    private $capacity;
    private $ready;

    /**
     * @var Output
     */
    private $source;

    /**
     * @var Input
     */
    private $destination;

    /**
     * @var int
     */
    private $speed;

    /**
     * Conveyor constructor.
     * @param Output $source
     * @param Input $destination
     * @param int $speed
     */
    public function __construct(Output $source, Input $destination, int $speed) {
        $this->source = $source;
        $this->destination = $destination;
        $this->speed = $speed;
        $this->belt=[];
        $this->capacity = 10;
        for($i=0;$i<$this->capacity;++$i){
            $this->belt[$i]=null;
        }
        $this->ready = false;
    }

    /**
     * @return Output
     */
    public function getSource(): Output {
        return $this->source;
    }

    /**
     * @param Output $source
     */
    public function setSource(Output $source) {
        $this->source = $source;
    }

    /**
     * @return Input
     */
    public function getDestination(): Input {
        return $this->destination;
    }

    /**
     * @param Input $destination
     */
    public function setDestination(Input $destination) {
        $this->destination = $destination;
    }

    /**
     * @return int
     */
    public function getSpeed(): int {
        return $this->speed;
    }

    /**
     * @param int $speed
     */
    public function setSpeed(int $speed) {
        $this->speed = $speed;
    }

    public function __toString() {
        $count = count($this->belt);
        $output =  __CLASS__ . "[{$count}]";
        for($i=0;$i<$this->capacity;++$i) {
            if($this->belt[$i]) {
                $output .= "o";
            } else {
                $output .= "_";
            }
        }
        return $output;
    }

    public function canProcess(): bool {
        return $this->belt[$this->capacity-1] != null;
    }

    public function process() {
        try {
            if($this->belt[$this->capacity - 1]) {
                $this->destination->put($this->belt[$this->capacity - 1]);
            }
            for ($i = $this->capacity - 1; $i > 0; --$i) {
                $this->belt[$i] = $this->belt[$i-1];
            }
            try {
                $this->belt[0] = $this->source->get();
            } catch (CannotGetException $e2) {
                $this->belt[0] = null;
            }
        } catch (CannotPutException $e) {}
    }
}