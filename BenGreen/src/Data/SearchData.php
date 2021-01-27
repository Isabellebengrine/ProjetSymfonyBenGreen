<?php


namespace App\Data;


use App\Entity\Rubrique;

//represents data from search on catalogue page :
//enables us to know the type of data sent in a search :
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