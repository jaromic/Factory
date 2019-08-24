<?php

namespace Jarosoft\Factory\Model;


use Jarosoft\Factory\Exception\CannotGetException;
use Jarosoft\Factory\Exception\CannotPutException;

class Machine implements Input, Output, Processor {

    private $internalInputSpace;
    private $internalOutputSpace;
    private $internalCapacity = 10;
    private $recipe;

    /**
     * Machine constructor.
     * @param $recipe Recipe
     */
    public function __construct(Recipe $recipe) {
        $this->recipe = $recipe;

        $this->internalInputSpace=[];
        $this->internalOutputSpace=[];
    }

    public function put(Item $item) {
        if(count($this->internalInputSpace) < $this->internalCapacity) {
            array_push($this->internalInputSpace, $item);
        } else {
            throw new CannotPutException("Internal capacity exceeded");
        }
    }

    public function get(): Item {
        if(count($this->internalOutputSpace)>0) {
            return array_pop($this->internalOutputSpace);
        } else {
            throw new CannotGetException("No item available");
        }
    }

    public function canDo(): bool {
        $canProcess = true;

        /* do we have all inputs? */
        foreach($this->recipe->getInputs() as $input) {
            if(count(self::getFilteredItemsInInternalInputSpace($input)) < $this->recipe->getInputAmount($input)) {
                $canProcess = false;
                break;
            }
        }

        /* do we have enough space for outputs: */
        $requiredOutputSpace = 0;
        foreach($this->recipe->getOutputs() as $output) {
            $requiredOutputSpace += $this->recipe->getOutputAmount($output);
            if(count($this->internalOutputSpace) + $requiredOutputSpace > $this->internalCapacity) {
                $canProcess = false;
                break;
            }
        }

        return $canProcess;
    }

    public function doIt() {
        if(!$this->canDo()) {
            return;
        }

        foreach($this->recipe->getInputs() as $inputItemClass) {
            for($i=0; $i<$this->recipe->getInputAmount($inputItemClass); ++$i) {
                $this->popFilteredFromInternalInputSpace($inputItemClass);
            }
        }
        foreach($this->recipe->getOutputs() as $outputItemClass) {
            for($i=0; $i<$this->recipe->getOutputAmount($outputItemClass); ++$i) {
                array_push($this->internalOutputSpace, new $outputItemClass);
            }
        }
    }

    private function popFilteredFromInternalInputSpace($inputItemClass) {
        $result = null;
        foreach($this->internalInputSpace as $k => $inputItem) {
            if(get_class($inputItem)==$inputItemClass) {
                $result = $this->internalInputSpace[$k];
                unset($this->internalInputSpace[$k]);
            }
        }
        return $result;
    }

    private function getFilteredItemsInInternalInputSpace($inputItemClass) {
        $result=[];
        foreach($this->internalInputSpace as $inputItem) {
            if(get_class($inputItem)==$inputItemClass) {
                array_push($result, $inputItem);
            }
        }
        return $result;
    }

    public function __toString() {
        $inputCount = count($this->internalInputSpace);
        $outputCount = count($this->internalOutputSpace);
        return __CLASS__ . "[{$inputCount}>{$outputCount}]";
    }
}