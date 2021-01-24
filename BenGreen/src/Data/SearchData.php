<?php


namespace App\Data;


use App\Entity\Rubrique;

class SearchData
{
    /**
     * @var int
     */
    public $page = 1;//default value

    /**
     * @var string
     */
    public $q = '';

    /**
     * @var Rubrique[]
     */
    public $rubriques = [];

    /**
     * @var null|integer
     */
    public $max;//no default value

    /**
     * @var null|integer
     */
    public $min;//no def value

}