<?php


namespace Jarosoft\Factory\Model;


interface Craftable {
    public static function getRecipe() : Recipe;
}