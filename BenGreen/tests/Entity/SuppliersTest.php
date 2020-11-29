<?php

namespace App\Tests\Entity;

use App\Entity\Suppliers;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolation;

class SuppliersTest extends KernelTestCase
{
    // Création d'une méthode pour récupérer l'entité :

    public function getEntity(): Suppliers {
        return (new Suppliers())->setSuppliersName('Fournisseur Test PHPUnit')
            //    ->setSupplierstype(1) - enlevé car génère erreur car attend objet supplierstype et non integer;
            ->setSuppliersAddress('Test PHP Unit')
            ->setSuppliersZipcode('80000')
            ->setSuppliersCity('test php unit')
            ->setSuppliersPhone('12345678');
    }

    // Création d'une méthode pour la validation et récupération des erreurs :

    public function assertHasError(Suppliers $suppliers, $number = 0)
    {
        // validation
        self::bootKernel();
        // récupération du validator depuis le container :
        $errors = self::$container->get('validator')->validate($suppliers);
        //pour récupérer les erreurs :
        $messages = [];
        /**
         * @var ConstraintViolation $error
         */
        foreach ($errors as $error) {
            $messages[] = $error->getPropertyPath() . ' => ' . $error->getMessage();
        }


        // on s'attend à ne pas avoir d'erreur
        $this->assertCount($number, $errors);
    }

    // Appel des méthodes dans les fonctions testValid et testInvalid :

    public function testValid()
    {
        $this->assertHasError($this->getEntity(), 0);
    }

    public function testDigitInvalid()
    {
        //test pour string erronée (avec chiffres) :
        $this->assertHasError($this->getEntity()->setSuppliersName('t123est Supplier'), 1);
    }

    public function testBlankInvalid()
    {
        // test pour une chaine de caractères vide
        $this->assertHasError($this->getEntity()->setSuppliersName(''), 1);
    }


}