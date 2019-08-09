<?php


namespace Jarosoft\Factory\Model;


class BreadPackage extends Package implements Craftable {

    public static function getRecipe(): Recipe {
        return new Recipe(
            [
                WaterCan::class => 2,
                FlourPackage::class => 2,
            ],
            [
                BreadPackage::class => 1,
            ],
            2);
    }
}