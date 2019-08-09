<?php


namespace Jarosoft\Factory\Model;


class Recipe {
    /**
     * @var array
     */
    private $amountPerInput;
    /**
     * @var array
     */
    private $amountPerOutput;
    /**
     * @var int
     */
    private $time;

    /**
     * Recipe constructor.
     * @param array $amountPerInput
     * @param array $amountPerOutput
     * @param int $time
     */
    public function __construct(array $amountPerInput, array $amountPerOutput, int $time) {
        $this->amountPerInput = $amountPerInput;
        $this->amountPerOutput = $amountPerOutput;
        $this->time = $time;
    }

    public function getInputs() {
        return array_keys($this->amountPerInput);
    }

    public function getOutputs() {
        return array_keys($this->amountPerOutput);
    }

    public function getInputAmount(string $input) : int {
        return $this->amountPerInput[$input];
    }

    public function getOutputAmount (string $output) : int {
        return $this->amountPerOutput[$output];
    }

    public function __toString() {
        return __CLASS__ . ": " . print_r($this->amountPerInput, true) . " => " . print_r($this->amountPerOutput);
    }
}