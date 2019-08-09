<?php

namespace Jarosoft\Factory\Controller;

use Jarosoft\Factory\Model\BreadPackage;
use Jarosoft\Factory\Model\Conveyor;
use Jarosoft\Factory\Model\Factory;
use Jarosoft\Factory\Model\FlourPackage;
use Jarosoft\Factory\Model\Machine;
use Jarosoft\Factory\Model\Stack;
use Jarosoft\Factory\Model\WaterCan;

require_once '../../vendor/autoload.php';

class SimpleProcess {
    public static function main() {

        $waterStack = new Stack (new WaterCan(), 200);
        $flourStack = new Stack (new FlourPackage(), 40);
        $breadStack = new Stack (new BreadPackage(), 0);
        $breadMachine = new Machine(BreadPackage::getRecipe());
        $conveyor1 = new Conveyor($waterStack, $breadMachine, 20);
        $conveyor2 = new Conveyor($flourStack, $breadMachine, 20);
        $conveyor3 = new Conveyor($breadMachine, $breadStack, 20);

        $factory = ( new Factory() )
            ->addElement($breadMachine)
            ->addElement($conveyor1)
            ->addElement($conveyor2)
            ->addElement($conveyor3);

        echo "Start:\n";
        echo "Water: {$waterStack}\n";
        echo "Flour: {$flourStack}\n";
        echo "Bread: {$breadStack}\n";

        $factory->loop(80);

        echo "End:\n";
        echo "Water: {$waterStack}\n";
        echo "Flour: {$flourStack}\n";
        echo "Bread: {$breadStack}\n";

    }
}

SimpleProcess::main();