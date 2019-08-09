<?php
namespace Jarosoft\Factory\Model;


class Factory implements Processor {
    /**
     * @var Processor[]
     */
    private $elements;

    public function __construct() {
        $this->elements = [];
    }

    /**
     * @return Processor[]
     */
    public function getElements(): array {
        return $this->elements;
    }

    public function addElement(Processor $element): Factory {
        array_push($this->elements, $element);
        return $this;
    }

    public function canProcess(): bool {
        return true;
    }

    public function process() {
        foreach($this->elements as $element) {
            $element->process();
        }
    }

    public function loop(int $iterations) {
        for($i=0;$i<$iterations;++$i) {
            $this->process();
            echo "$i: ". $this;
        }
    }

    public function __toString() {
        $result = __CLASS__.": ";
        foreach($this->elements as $element) {
            $result .= $element ."\n";
        }
        return $result;
    }
}