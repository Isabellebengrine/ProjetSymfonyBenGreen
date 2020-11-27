<?php

namespace App\DataFixtures;

use App\Entity\Categorietva;
use App\Entity\Customers;
use App\Entity\Employee;
use App\Entity\Orderdetail;
use App\Entity\Products;
use App\Entity\Rubrique;
use App\Entity\Suppliers;
use App\Entity\Supplierstype;
use App\Entity\Totalorder;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        //to use faker to fill database in with fake data :
        $faker = \Faker\Factory::create('fr_FR');

        //to create items of class categorietva :
        $catparticulier = new Categorietva();
        $catparticulier->setCategorietvaCoefficient("0.20")
            ->setCategorietvaNom("Particuliers");

        $catpro = new Categorietva();
        $catpro->setCategorietvaCoefficient("0.10")
            ->setCategorietvaNom("Professionnels");

        $manager->persist($catparticulier);
        $manager->persist($catpro);

        //to create 3 items of class employee :
        $emp1 = new Employee();
        $emp1->setEmployeeName($faker->name);
        $manager->persist($emp1);
        $emp2 = new Employee();
        $emp2->setEmployeeName($faker->name);
        $manager->persist($emp2);
        $emp3 = new Employee();
        $emp3->setEmployeeName($faker->name);
        $manager->persist($emp3);

        //to create items of class supplierstype :

        $constructeur = new Supplierstype();
        $constructeur->setSupplierstypeName("Constructeur");
        $importateur = new Supplierstype();
        $importateur->setSupplierstypeName("Importateur");

        $manager->persist($constructeur);
        $manager->persist($importateur);

        //to create suppliers items : I make 5 suppliers for each supplierstype :
        for ($h=1; $h<6; $h++){
            $supplier = new Suppliers();
            $supplier->setSuppliersName($faker->company)
                ->setSuppliersAddress($faker->streetAddress)
                ->setSuppliersCity($faker->city)
                ->setSuppliersPhone($faker->phoneNumber)
                ->setSuppliersZipcode($faker->postcode)
                ->setSupplierstype($constructeur);
            $manager->persist($supplier);
        }
        for ($h=1; $h<6; $h++){
            $supplier = new Suppliers();
            $supplier->setSuppliersName($faker->company)
                ->setSuppliersAddress($faker->streetAddress)
                ->setSuppliersCity($faker->city)
                ->setSuppliersPhone($faker->phoneNumber)
                ->setSuppliersZipcode($faker->postcode)
                ->setSupplierstype($importateur);
            $manager->persist($supplier);
        }

        //to create the main product rubriques :

        $guitare = new Rubrique();
        $guitare->setRubriqueName("Guitares et Basses")
            ->setRubriquePicture("CATEGORIES guitare.png");

        $micro = new Rubrique();
        $micro->setRubriqueName("Micros")
            ->setRubriquePicture("CATEGORIES micro.png");

        $piano = new Rubrique();
        $piano->setRubriqueName("Pianos")
            ->setRubriquePicture("CATEGORIES piano.png");

        $batterie = new Rubrique();
        $batterie->setRubriqueName("Batteries")
            ->setRubriquePicture("CATEGORIES batterie.png");

        $saxo = new Rubrique();
        $saxo->setRubriqueName("Saxophones")
            ->setRubriquePicture("CATEGORIES saxo.png");

        $cable = new Rubrique();
        $cable->setRubriqueName("Cables")
            ->setRubriquePicture("CATEGORIES cable.png");

        $case = new Rubrique();
        $case->setRubriqueName("Cases")
            ->setRubriquePicture("CATEGORIES cases.png");

        $sono = new Rubrique();
        $sono->setRubriqueName("Sono")
            ->setRubriquePicture("CATEGORIES sono.png");

        $manager->persist($guitare);
        $manager->persist($micro);
        $manager->persist($piano);
        $manager->persist($batterie);
        $manager->persist($saxo);
        $manager->persist($cable);
        $manager->persist($case);
        $manager->persist($sono);

        //pour les sous-rubriques de chaque rubrique principale : on veut 3 sous-rub pour chaque rubrique parent : voir comment factoriser pour éviter redondance?
        for ($j=1; $j<4; $j++){
            $sousrubrique = new Rubrique();
            $sousrubrique->setRubriqueName($faker->word())
                ->setRubriquePicture($faker->imageUrl())
                ->setParent($guitare);
            $manager->persist($sousrubrique);

            //to create 4 products in each $guitare sous- rubrique :
            for($m=1; $m<5; $m++){
                $product = new Products();
                $product->setProductsName('Produit n°'.$m)
                    ->setProductsDescription($faker->sentence())
                    ->setProductsStock($faker->randomNumber())
                    ->setProductsStatus($faker->boolean)
                    ->setProductsPrice($faker->numerify())
                    ->setProductsPicture($faker->imageUrl())
                    ->setRubrique($sousrubrique);
                $manager->persist($product);

                //to create fake orders of each product - only for customers of emp2:

                for($g = 0; $g<2; $g++){
                        $customer = new Customers();
                        $customer->setCustomersName($faker->name)
                            ->setCustomersAddress($faker->streetAddress)
                            ->setCustomersCity($faker->city)
                            ->setCustomersZipcode($faker->postcode)
                            ->setCustomersPhone($faker->phoneNumber)
                            ->setCategorietva($catparticulier)
                            ->setEmployee($emp2);
                        $manager->persist($customer);

                        //to make 5 fake orders :
                        for ($o=1; $o<6; $o++){
                            $order = new Totalorder();
                            $order->setTotalorderBilladdress($faker->streetAddress)
                                ->setTotalorderDate($faker->dateTimeThisYear)
                                ->setTotalorderDeliveryaddress($faker->streetAddress)
                                ->setTotalorderInvoicedate($faker->dateTimeThisMonth)
                                ->setTotalorderInvoicenb($faker->randomNumber(6))
                                ->setCustomers($customer);
                            $manager->persist($order);

                            //for each order I make 3 orderdetail items :
                            for ($d=1; $d<4; $d++){
                                $detail = new Orderdetail();
                                $detail->setOrderdetailPrice($faker->randomNumber(3))
                                    ->setOrderdetailQuantity($faker->randomDigitNotNull)
                                    ->setTotalorder($order)
                                    ->setProducts($product);
                                $manager->persist($detail);
                            }
                        }
                    }

            }
        }
        for ($k=1; $k<4; $k++){
            $sousrubrique = new Rubrique();
            $sousrubrique->setRubriqueName($faker->word())
                ->setRubriquePicture($faker->imageUrl())
                ->setParent($piano);
            $manager->persist($sousrubrique);

            //to create 4 products in each $piano sous- rubrique :
            for($m=1; $m<5; $m++){
                $product = new Products();
                $product->setProductsName('Produit n°'.$m)
                    ->setProductsDescription($faker->sentence())
                    ->setProductsStock($faker->randomNumber())
                    ->setProductsStatus($faker->boolean)
                    ->setProductsPrice($faker->numerify())
                    ->setProductsPicture($faker->imageUrl())
                    ->setRubrique($sousrubrique);
                $manager->persist($product);

                //to create fake orders of that product :

                //2 clients de $emp3
                for($g = 0; $g<2; $g++){
                    $customer = new Customers();
                    $customer->setCustomersName($faker->name)
                            ->setCustomersAddress($faker->streetAddress)
                            ->setCustomersCity($faker->city)
                            ->setCustomersZipcode($faker->postcode)
                            ->setCustomersPhone($faker->phoneNumber)
                            ->setCategorietva($catparticulier)
                            ->setEmployee($emp3);
                    $manager->persist($customer);

                    //for each of these customers I make 5 fake orders :
                    for ($o=1; $o<6; $o++){
                        $order = new Totalorder();
                        $order->setTotalorderBilladdress($faker->streetAddress)
                            ->setTotalorderDate($faker->dateTimeThisYear)
                            ->setTotalorderDeliveryaddress($faker->streetAddress)
                            ->setTotalorderInvoicedate($faker->dateTimeThisMonth)
                            ->setTotalorderInvoicenb($faker->randomNumber(6))
                            ->setCustomers($customer);
                        $manager->persist($order);

                        //for each order I make 3 orderdetail items :
                        for ($d=1; $d<4; $d++){
                            $detail = new Orderdetail();
                            $detail->setOrderdetailPrice($faker->randomNumber(3))
                                ->setOrderdetailQuantity($faker->randomDigitNotNull)
                                ->setTotalorder($order)
                                ->setProducts($product);
                            $manager->persist($detail);
                        }
                    }
                }
            }
        }
        for ($l=1; $l<4; $l++){
            $sousrubrique = new Rubrique();
            $sousrubrique->setRubriqueName($faker->word())
                ->setRubriquePicture($faker->imageUrl())
                ->setParent($saxo);
            $manager->persist($sousrubrique);

            //to create 4 products in each $saxo sous- rubrique :
            for($m=1; $m<5; $m++){
                $product = new Products();
                $product->setProductsName('Produit n°'.$m)
                    ->setProductsDescription($faker->sentence())
                    ->setProductsStock($faker->randomNumber())
                    ->setProductsStatus($faker->boolean)
                    ->setProductsPrice($faker->numerify())
                    ->setProductsPicture($faker->imageUrl())
                    ->setRubrique($sousrubrique);
                $manager->persist($product);

                //to create fake orders of that product :

                //for $emp1 employee I make 5 customers :
                for($g = 0; $g<5; $g++){
                    $customer = new Customers();
                    $customer->setCustomersName($faker->name)
                        ->setCustomersAddress($faker->streetAddress)
                        ->setCustomersCity($faker->city)
                        ->setCustomersZipcode($faker->postcode)
                        ->setCustomersPhone($faker->phoneNumber)
                        ->setCategorietva($catparticulier)
                        ->setEmployee($emp1);
                    $manager->persist($customer);

                    //for each customer I make 5 fake orders :
                    for ($o=1; $o<6; $o++){
                        $order = new Totalorder();
                        $order->setTotalorderBilladdress($faker->streetAddress)
                            ->setTotalorderDate($faker->dateTimeThisYear)
                            ->setTotalorderDeliveryaddress($faker->streetAddress)
                            ->setTotalorderInvoicedate($faker->dateTimeThisMonth)
                            ->setTotalorderInvoicenb($faker->randomNumber(6))
                            ->setCustomers($customer);
                        $manager->persist($order);

                        //for each order I make 3 orderdetail items :
                        for ($d=1; $d<4; $d++){
                            $detail = new Orderdetail();
                            $detail->setOrderdetailPrice($faker->randomNumber(3))
                                ->setOrderdetailQuantity($faker->randomDigitNotNull)
                                ->setTotalorder($order)
                                ->setProducts($product);
                            $manager->persist($detail);
                        }
                    }
                }
            }
        }

        //when or if needed, add datafixtures for table purchases and delivery :
        //purchases need suppliers and products
        //delivery needs customers and orderdetail

        $manager->flush();
    }
}
