<?php

namespace Jarosoft\Factory\Model;

use PHPUnit\Framework\TestCase;

require_once "../../vendor/composer/autoload_psr4.php";

class RecipeTest extends Testcase {

    public function testGetInputs() {
        $breadRecipe = BreadPackage::getRecipe();
        $this->assertCount(2, $breadRecipe->getInputs());
    }

    public function testGetOutputs() {
        $breadRecipe = $this->_createBreadPackage();
        $this->assertCount(1, $breadRecipe->getOutputs());
    }

    public function testAmountPerInput() {
        $breadRecipe = $this->_createBreadPackage();
        $this->assertEquals(2, $breadRecipe->getInputAmount(FlourPackage::class));
        $this->assertEquals(2, $breadRecipe->getInputAmount(WaterCan::class));
    }

    public function testAmountPerOutput() {
        $breadRecipe = $this->_createBreadPackage();
        $this->assertEquals(1, $breadRecipe->getOutputAmount(BreadPackage::class));
    }

}
