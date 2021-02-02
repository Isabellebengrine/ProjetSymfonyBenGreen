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

        //pour les sous-rubriques de chaque rubrique principale :
        //on veut 3 sous-rub pour chaque rubrique parent : (voir comment factoriser pour éviter redondance?)
        $srguitare1 = new Rubrique();
        $srguitare1->setRubriqueName("Guitares acoustiques")
            ->setRubriquePicture("gacoustiq.png")
            ->setParent($guitare);
        $manager->persist($srguitare1);

        $srguitare2 = new Rubrique();
        $srguitare2->setRubriqueName("Guitares classiques")
            ->setRubriquePicture("gclassiq.png")
            ->setParent($guitare);
        $manager->persist($srguitare2);

        $srguitare3 = new Rubrique();
        $srguitare3->setRubriqueName("Guitares électriques")
            ->setRubriquePicture("gelec.png")
            ->setParent($guitare);
        $manager->persist($srguitare3);

        //to create 4 products in each $guitare sub-category (with customers, totalorders and orderdetails for each) :
        for($m=1; $m<5; $m++){
            $product = new Products();
            $product->setProductsName('Produit n°'.$m)
                ->setProductsDescription($faker->sentence())
                ->setProductsStock($faker->numberBetween($min = 1, $max = 20))
                ->setProductsStatus($faker->boolean)
                ->setProductsPrice($faker->numberBetween($min = 50, $max = 5000))
                ->setProductsPicture("https://picsum.photos/id/" . $faker->numberBetween($min = 1, $max = 1100) . "/290/180")
                ->setRubrique($srguitare1);
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
        for($m=1; $m<5; $m++){
            $product = new Products();
            $product->setProductsName('Produit n°'.$m)
                ->setProductsDescription($faker->sentence())
                ->setProductsStock($faker->numberBetween($min = 1, $max = 20))
                ->setProductsStatus($faker->boolean)
                ->setProductsPrice($faker->numberBetween($min = 50, $max = 5000))
                ->setProductsPicture("https://picsum.photos/id/" . $faker->numberBetween($min = 1, $max = 1100) . "/290/180")
                ->setRubrique($srguitare2);
            $manager->persist($product);

            //to create fake orders of each product - only for customers of emp1:
            for($g = 0; $g<2; $g++){
                $customer = new Customers();
                $customer->setCustomersName($faker->name)
                    ->setCustomersAddress($faker->streetAddress)
                    ->setCustomersCity($faker->city)
                    ->setCustomersZipcode($faker->postcode)
                    ->setCustomersPhone($faker->phoneNumber)
                    ->setCategorietva($catparticulier)
                    ->setEmployee($emp1);
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
        for($m=1; $m<5; $m++){
            $product = new Products();
            $product->setProductsName('Produit n°'.$m)
                ->setProductsDescription($faker->sentence())
                ->setProductsStock($faker->numberBetween($min = 1, $max = 20))
                ->setProductsStatus($faker->boolean)
                ->setProductsPrice($faker->numberBetween($min = 50, $max = 5000))
                ->setProductsPicture("https://picsum.photos/id/" . $faker->numberBetween($min = 1, $max = 1100) . "/290/180")
                ->setRubrique($srguitare3);
            $manager->persist($product);

            //to create fake orders of each product - only for customers of emp3:
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

        //to create 3 $piano sous-rubrique :
        $srpiano1 = new Rubrique();
        $srpiano1->setRubriqueName("Pianos à queue")
            ->setRubriquePicture("pianoqueue.png")
            ->setParent($piano);
        $manager->persist($srpiano1);

        $srpiano2 = new Rubrique();
        $srpiano2->setRubriqueName("Pianos droits")
            ->setRubriquePicture("pianodroit.png")
            ->setParent($piano);
        $manager->persist($srpiano2);

        $srpiano3 = new Rubrique();
        $srpiano3->setRubriqueName("Pianos numériques")
            ->setRubriquePicture("pnumeriq.png")
            ->setParent($piano);
        $manager->persist($srpiano3);

        //to create 4 products in each $piano sub-category (with customers, totalorders and orderdetails for each):
        for($m=1; $m<5; $m++){
            $product = new Products();
            $product->setProductsName('Produit n°'.$m)
                ->setProductsDescription($faker->sentence())
                ->setProductsStock($faker->numberBetween($min = 1, $max = 20))
                ->setProductsStatus($faker->boolean)
                ->setProductsPrice($faker->numberBetween($min = 50, $max = 5000))
                ->setProductsPicture("https://picsum.photos/id/" . $faker->numberBetween($min = 1, $max = 1100) . "/290/180")
                ->setRubrique($srpiano1);
            $manager->persist($product);

            //to create fake orders of each product - only for customers of emp1:
            for($g = 0; $g<2; $g++){
                $customer = new Customers();
                $customer->setCustomersName($faker->name)
                    ->setCustomersAddress($faker->streetAddress)
                    ->setCustomersCity($faker->city)
                    ->setCustomersZipcode($faker->postcode)
                    ->setCustomersPhone($faker->phoneNumber)
                    ->setCategorietva($catparticulier)
                    ->setEmployee($emp1);
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
        for($m=1; $m<5; $m++){
            $product = new Products();
            $product->setProductsName('Produit n°'.$m)
                ->setProductsDescription($faker->sentence())
                ->setProductsStock($faker->numberBetween($min = 1, $max = 20))
                ->setProductsStatus($faker->boolean)
                ->setProductsPrice($faker->numberBetween($min = 50, $max = 5000))
                ->setProductsPicture("https://picsum.photos/id/" . $faker->numberBetween($min = 1, $max = 1100) . "/290/180")
                ->setRubrique($srpiano2);
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
        for($m=1; $m<5; $m++){
            $product = new Products();
            $product->setProductsName('Produit n°'.$m)
                ->setProductsDescription($faker->sentence())
                ->setProductsStock($faker->numberBetween($min = 1, $max = 20))
                ->setProductsStatus($faker->boolean)
                ->setProductsPrice($faker->numberBetween($min = 50, $max = 5000))
                ->setProductsPicture("https://picsum.photos/id/" . $faker->numberBetween($min = 1, $max = 1100) . "/290/180")
                ->setRubrique($srpiano3);
            $manager->persist($product);

            //to create fake orders of each product - only for customers of emp3:
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

        //to make 3 $saxo sub-categories :
        $srsaxo1 = new Rubrique();
        $srsaxo1->setRubriqueName("Saxos altos")
            ->setRubriquePicture("saxoalto.png")
            ->setParent($saxo);
        $manager->persist($srsaxo1);

        $srsaxo2 = new Rubrique();
        $srsaxo2->setRubriqueName("Saxos barytons")
            ->setRubriquePicture("saxobaryton.png")
            ->setParent($saxo);
        $manager->persist($srsaxo2);

        $srsaxo3 = new Rubrique();
        $srsaxo3->setRubriqueName("Saxos sopranos")
            ->setRubriquePicture("saxosoprano.png")
            ->setParent($saxo);
        $manager->persist($srsaxo3);

        //to create 4 products in each $saxo sub-category (with customers, totalorders and orderdetails for each):
        for($m=1; $m<5; $m++){
            $product = new Products();
            $product->setProductsName('Produit n°'.$m)
                ->setProductsDescription($faker->sentence())
                ->setProductsStock($faker->numberBetween($min = 1, $max = 20))
                ->setProductsStatus($faker->boolean)
                ->setProductsPrice($faker->numberBetween($min = 50, $max = 5000))
                ->setProductsPicture("https://picsum.photos/id/" . $faker->numberBetween($min = 1, $max = 1100) . "/290/180")
                ->setRubrique($srsaxo1);
            $manager->persist($product);

            //to create fake orders of each product - only for customers of emp1:
            for($g = 0; $g<2; $g++){
                $customer = new Customers();
                $customer->setCustomersName($faker->name)
                    ->setCustomersAddress($faker->streetAddress)
                    ->setCustomersCity($faker->city)
                    ->setCustomersZipcode($faker->postcode)
                    ->setCustomersPhone($faker->phoneNumber)
                    ->setCategorietva($catparticulier)
                    ->setEmployee($emp1);
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
        for($m=1; $m<5; $m++){
            $product = new Products();
            $product->setProductsName('Produit n°'.$m)
                ->setProductsDescription($faker->sentence())
                ->setProductsStock($faker->numberBetween($min = 1, $max = 20))
                ->setProductsStatus($faker->boolean)
                ->setProductsPrice($faker->numberBetween($min = 50, $max = 5000))
                ->setProductsPicture("https://picsum.photos/id/" . $faker->numberBetween($min = 1, $max = 1100) . "/290/180")
                ->setRubrique($srsaxo2);
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
        for($m=1; $m<5; $m++){
            $product = new Products();
            $product->setProductsName('Produit n°'.$m)
                ->setProductsDescription($faker->sentence())
                ->setProductsStock($faker->numberBetween($min = 1, $max = 20))
                ->setProductsStatus($faker->boolean)
                ->setProductsPrice($faker->numberBetween($min = 50, $max = 5000))
                ->setProductsPicture("https://picsum.photos/id/" . $faker->numberBetween($min = 1, $max = 1100) . "/290/180")
                ->setRubrique($srsaxo3);
            $manager->persist($product);

            //to create fake orders of each product - only for customers of emp3:
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

        //to make 3 $micro sub-categories :
        $srmicro1 = new Rubrique();
        $srmicro1->setRubriqueName("Micros de chant")
            ->setRubriquePicture("microschant.png")
            ->setParent($micro);
        $manager->persist($srmicro1);

        $srmicro2 = new Rubrique();
        $srmicro2->setRubriqueName("Micros pour instruments")
            ->setRubriquePicture("microsinstrument.png")
            ->setParent($micro);
        $manager->persist($srmicro2);

        $srmicro3 = new Rubrique();
        $srmicro3->setRubriqueName("Micros sans fil")
            ->setRubriquePicture("microsansfil.png")
            ->setParent($micro);
        $manager->persist($srmicro3);

        //to create 1 product in each $micro sub-category (with customers, totalorders and orderdetails for each):
        for($m=1; $m<2; $m++){
            $product = new Products();
            $product->setProductsName('Produit n°'.$m)
                ->setProductsDescription($faker->sentence())
                ->setProductsStock($faker->numberBetween($min = 1, $max = 20))
                ->setProductsStatus($faker->boolean)
                ->setProductsPrice($faker->numberBetween($min = 50, $max = 5000))
                ->setProductsPicture("https://picsum.photos/id/" . $faker->numberBetween($min = 1, $max = 1100) . "/290/180")
                ->setRubrique($srmicro1);
            $manager->persist($product);

            //to create fake orders of each product - only for customers of emp1:
            for($g = 0; $g<2; $g++){
                $customer = new Customers();
                $customer->setCustomersName($faker->name)
                    ->setCustomersAddress($faker->streetAddress)
                    ->setCustomersCity($faker->city)
                    ->setCustomersZipcode($faker->postcode)
                    ->setCustomersPhone($faker->phoneNumber)
                    ->setCategorietva($catparticulier)
                    ->setEmployee($emp1);
                $manager->persist($customer);

                //to make 2 fake orders :
                for ($o=1; $o<3; $o++){
                    $order = new Totalorder();
                    $order->setTotalorderBilladdress($faker->streetAddress)
                        ->setTotalorderDate($faker->dateTimeThisYear)
                        ->setTotalorderDeliveryaddress($faker->streetAddress)
                        ->setTotalorderInvoicedate($faker->dateTimeThisMonth)
                        ->setTotalorderInvoicenb($faker->randomNumber(6))
                        ->setCustomers($customer);
                    $manager->persist($order);

                    //for each order I make 1 orderdetail item :
                    for ($d=1; $d<2; $d++){
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
        for($m=1; $m<2; $m++){
            $product = new Products();
            $product->setProductsName('Produit n°'.$m)
                ->setProductsDescription($faker->sentence())
                ->setProductsStock($faker->numberBetween($min = 1, $max = 20))
                ->setProductsStatus($faker->boolean)
                ->setProductsPrice($faker->numberBetween($min = 50, $max = 5000))
                ->setProductsPicture("https://picsum.photos/id/" . $faker->numberBetween($min = 1, $max = 1100) . "/290/180")
                ->setRubrique($srmicro2);
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

                //to make 2 fake orders :
                for ($o=1; $o<3; $o++){
                    $order = new Totalorder();
                    $order->setTotalorderBilladdress($faker->streetAddress)
                        ->setTotalorderDate($faker->dateTimeThisYear)
                        ->setTotalorderDeliveryaddress($faker->streetAddress)
                        ->setTotalorderInvoicedate($faker->dateTimeThisMonth)
                        ->setTotalorderInvoicenb($faker->randomNumber(6))
                        ->setCustomers($customer);
                    $manager->persist($order);

                    //for each order I make 1 orderdetail item :
                    for ($d=1; $d<2; $d++){
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
        for($m=1; $m<2; $m++){
            $product = new Products();
            $product->setProductsName('Produit n°'.$m)
                ->setProductsDescription($faker->sentence())
                ->setProductsStock($faker->numberBetween($min = 1, $max = 20))
                ->setProductsStatus($faker->boolean)
                ->setProductsPrice($faker->numberBetween($min = 50, $max = 5000))
                ->setProductsPicture("https://picsum.photos/id/" . $faker->numberBetween($min = 1, $max = 1100) . "/290/180")
                ->setRubrique($srmicro3);
            $manager->persist($product);

            //to create fake orders of each product - only for customers of emp3:
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

                //to make 2 fake orders :
                for ($o=1; $o<3; $o++){
                    $order = new Totalorder();
                    $order->setTotalorderBilladdress($faker->streetAddress)
                        ->setTotalorderDate($faker->dateTimeThisYear)
                        ->setTotalorderDeliveryaddress($faker->streetAddress)
                        ->setTotalorderInvoicedate($faker->dateTimeThisMonth)
                        ->setTotalorderInvoicenb($faker->randomNumber(6))
                        ->setCustomers($customer);
                    $manager->persist($order);

                    //for each order I make 1 orderdetail item :
                    for ($d=1; $d<2; $d++){
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

        //to make 3 $batterie sub-categories :
        $srbatterie1 = new Rubrique();
        $srbatterie1->setRubriqueName("Batteries acoustiques")
            ->setRubriquePicture("bacoustiq.png")
            ->setParent($batterie);
        $manager->persist($srbatterie1);

        $srbatterie2 = new Rubrique();
        $srbatterie2->setRubriqueName("Batteries électroniques")
            ->setRubriquePicture("belectroniq.png")
            ->setParent($batterie);
        $manager->persist($srbatterie2);

        $srbatterie3 = new Rubrique();
        $srbatterie3->setRubriqueName("Percussions")
            ->setRubriquePicture("percussions.png")
            ->setParent($batterie);
        $manager->persist($srbatterie3);

        //to create 1 product in each $batterie sub-category (with customers, totalorders and orderdetails for each):
        for($m=1; $m<2; $m++){
            $product = new Products();
            $product->setProductsName('Produit n°'.$m)
                ->setProductsDescription($faker->sentence())
                ->setProductsStock($faker->numberBetween($min = 1, $max = 20))
                ->setProductsStatus($faker->boolean)
                ->setProductsPrice($faker->numberBetween($min = 50, $max = 5000))
                ->setProductsPicture("https://picsum.photos/id/" . $faker->numberBetween($min = 1, $max = 1100) . "/290/180")
                ->setRubrique($srbatterie1);
            $manager->persist($product);

            //to create fake orders of each product - only for customers of emp1:
            for($g = 0; $g<2; $g++){
                $customer = new Customers();
                $customer->setCustomersName($faker->name)
                    ->setCustomersAddress($faker->streetAddress)
                    ->setCustomersCity($faker->city)
                    ->setCustomersZipcode($faker->postcode)
                    ->setCustomersPhone($faker->phoneNumber)
                    ->setCategorietva($catparticulier)
                    ->setEmployee($emp1);
                $manager->persist($customer);

                //to make 2 fake orders :
                for ($o=1; $o<3; $o++){
                    $order = new Totalorder();
                    $order->setTotalorderBilladdress($faker->streetAddress)
                        ->setTotalorderDate($faker->dateTimeThisYear)
                        ->setTotalorderDeliveryaddress($faker->streetAddress)
                        ->setTotalorderInvoicedate($faker->dateTimeThisMonth)
                        ->setTotalorderInvoicenb($faker->randomNumber(6))
                        ->setCustomers($customer);
                    $manager->persist($order);

                    //for each order I make 1 orderdetail item :
                    for ($d=1; $d<2; $d++){
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
        for($m=1; $m<2; $m++){
            $product = new Products();
            $product->setProductsName('Produit n°'.$m)
                ->setProductsDescription($faker->sentence())
                ->setProductsStock($faker->numberBetween($min = 1, $max = 20))
                ->setProductsStatus($faker->boolean)
                ->setProductsPrice($faker->numberBetween($min = 50, $max = 5000))
                ->setProductsPicture("https://picsum.photos/id/" . $faker->numberBetween($min = 1, $max = 1100) . "/290/180")
                ->setRubrique($srbatterie2);
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

                //to make 2 fake orders :
                for ($o=1; $o<3; $o++){
                    $order = new Totalorder();
                    $order->setTotalorderBilladdress($faker->streetAddress)
                        ->setTotalorderDate($faker->dateTimeThisYear)
                        ->setTotalorderDeliveryaddress($faker->streetAddress)
                        ->setTotalorderInvoicedate($faker->dateTimeThisMonth)
                        ->setTotalorderInvoicenb($faker->randomNumber(6))
                        ->setCustomers($customer);
                    $manager->persist($order);

                    //for each order I make 1 orderdetail item :
                    for ($d=1; $d<2; $d++){
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
        for($m=1; $m<2; $m++){
            $product = new Products();
            $product->setProductsName('Produit n°'.$m)
                ->setProductsDescription($faker->sentence())
                ->setProductsStock($faker->numberBetween($min = 1, $max = 20))
                ->setProductsStatus($faker->boolean)
                ->setProductsPrice($faker->numberBetween($min = 50, $max = 5000))
                ->setProductsPicture("https://picsum.photos/id/" . $faker->numberBetween($min = 1, $max = 1100) . "/290/180")
                ->setRubrique($srbatterie3);
            $manager->persist($product);

            //to create fake orders of each product - only for customers of emp3:
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

                //to make 2 fake orders :
                for ($o=1; $o<3; $o++){
                    $order = new Totalorder();
                    $order->setTotalorderBilladdress($faker->streetAddress)
                        ->setTotalorderDate($faker->dateTimeThisYear)
                        ->setTotalorderDeliveryaddress($faker->streetAddress)
                        ->setTotalorderInvoicedate($faker->dateTimeThisMonth)
                        ->setTotalorderInvoicenb($faker->randomNumber(6))
                        ->setCustomers($customer);
                    $manager->persist($order);

                    //for each order I make 1 orderdetail item :
                    for ($d=1; $d<2; $d++){
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

        //to make 3 $cable sub-categories :
        $srcable1 = new Rubrique();
        $srcable1->setRubriqueName("Boitiers de scène")
            ->setRubriquePicture("multipaire.png")
            ->setParent($cable);
        $manager->persist($srcable1);

        $srcable2 = new Rubrique();
        $srcable2->setRubriqueName("Câbles audio")
            ->setRubriquePicture("cableaudio.png")
            ->setParent($cable);
        $manager->persist($srcable2);

        $srcable3 = new Rubrique();
        $srcable3->setRubriqueName("Câbles video")
            ->setRubriquePicture("cablevideo.png")
            ->setParent($cable);
        $manager->persist($srcable3);

        //to create 1 product in each $cable sub-category (with customers, totalorders and orderdetails for each):
        for($m=1; $m<2; $m++){
            $product = new Products();
            $product->setProductsName('Produit n°'.$m)
                ->setProductsDescription($faker->sentence())
                ->setProductsStock($faker->numberBetween($min = 1, $max = 20))
                ->setProductsStatus($faker->boolean)
                ->setProductsPrice($faker->numberBetween($min = 50, $max = 5000))
                ->setProductsPicture("https://picsum.photos/id/" . $faker->numberBetween($min = 1, $max = 1100) . "/290/180")
                ->setRubrique($srcable1);
            $manager->persist($product);

            //to create fake orders of each product - only for customers of emp1:
            for($g = 0; $g<2; $g++){
                $customer = new Customers();
                $customer->setCustomersName($faker->name)
                    ->setCustomersAddress($faker->streetAddress)
                    ->setCustomersCity($faker->city)
                    ->setCustomersZipcode($faker->postcode)
                    ->setCustomersPhone($faker->phoneNumber)
                    ->setCategorietva($catparticulier)
                    ->setEmployee($emp1);
                $manager->persist($customer);

                //to make 2 fake orders :
                for ($o=1; $o<3; $o++){
                    $order = new Totalorder();
                    $order->setTotalorderBilladdress($faker->streetAddress)
                        ->setTotalorderDate($faker->dateTimeThisYear)
                        ->setTotalorderDeliveryaddress($faker->streetAddress)
                        ->setTotalorderInvoicedate($faker->dateTimeThisMonth)
                        ->setTotalorderInvoicenb($faker->randomNumber(6))
                        ->setCustomers($customer);
                    $manager->persist($order);

                    //for each order I make 1 orderdetail item :
                    for ($d=1; $d<2; $d++){
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
        for($m=1; $m<2; $m++){
            $product = new Products();
            $product->setProductsName('Produit n°'.$m)
                ->setProductsDescription($faker->sentence())
                ->setProductsStock($faker->numberBetween($min = 1, $max = 20))
                ->setProductsStatus($faker->boolean)
                ->setProductsPrice($faker->numberBetween($min = 50, $max = 5000))
                ->setProductsPicture("https://picsum.photos/id/" . $faker->numberBetween($min = 1, $max = 1100) . "/290/180")
                ->setRubrique($srcable2);
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

                //to make 2 fake orders :
                for ($o=1; $o<3; $o++){
                    $order = new Totalorder();
                    $order->setTotalorderBilladdress($faker->streetAddress)
                        ->setTotalorderDate($faker->dateTimeThisYear)
                        ->setTotalorderDeliveryaddress($faker->streetAddress)
                        ->setTotalorderInvoicedate($faker->dateTimeThisMonth)
                        ->setTotalorderInvoicenb($faker->randomNumber(6))
                        ->setCustomers($customer);
                    $manager->persist($order);

                    //for each order I make 1 orderdetail item :
                    for ($d=1; $d<2; $d++){
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
        for($m=1; $m<2; $m++){
            $product = new Products();
            $product->setProductsName('Produit n°'.$m)
                ->setProductsDescription($faker->sentence())
                ->setProductsStock($faker->numberBetween($min = 1, $max = 20))
                ->setProductsStatus($faker->boolean)
                ->setProductsPrice($faker->numberBetween($min = 50, $max = 5000))
                ->setProductsPicture("https://picsum.photos/id/" . $faker->numberBetween($min = 1, $max = 1100) . "/290/180")
                ->setRubrique($srcable3);
            $manager->persist($product);

            //to create fake orders of each product - only for customers of emp3:
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

                //to make 2 fake orders :
                for ($o=1; $o<3; $o++){
                    $order = new Totalorder();
                    $order->setTotalorderBilladdress($faker->streetAddress)
                        ->setTotalorderDate($faker->dateTimeThisYear)
                        ->setTotalorderDeliveryaddress($faker->streetAddress)
                        ->setTotalorderInvoicedate($faker->dateTimeThisMonth)
                        ->setTotalorderInvoicenb($faker->randomNumber(6))
                        ->setCustomers($customer);
                    $manager->persist($order);

                    //for each order I make 1 orderdetail item :
                    for ($d=1; $d<2; $d++){
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

        //to make 3 $case sub-categories :
        $srcase1 = new Rubrique();
        $srcase1->setRubriqueName("Flight cases")
            ->setRubriquePicture("flight.png")
            ->setParent($case);
        $manager->persist($srcase1);

        $srcase2 = new Rubrique();
        $srcase2->setRubriqueName("Housses et étuis")
            ->setRubriquePicture("housse.png")
            ->setParent($case);
        $manager->persist($srcase2);

        $srcase3 = new Rubrique();
        $srcase3->setRubriqueName("Systèmes de transport")
            ->setRubriquePicture("transport.png")
            ->setParent($case);
        $manager->persist($srcase3);

        //to create 1 product in each $case sub-category (with customers, totalorders and orderdetails for each):
        for($m=1; $m<2; $m++){
            $product = new Products();
            $product->setProductsName('Produit n°'.$m)
                ->setProductsDescription($faker->sentence())
                ->setProductsStock($faker->numberBetween($min = 1, $max = 20))
                ->setProductsStatus($faker->boolean)
                ->setProductsPrice($faker->numberBetween($min = 50, $max = 5000))
                ->setProductsPicture("https://picsum.photos/id/" . $faker->numberBetween($min = 1, $max = 1100) . "/290/180")
                ->setRubrique($srcase1);
            $manager->persist($product);

            //to create fake orders of each product - only for customers of emp1:
            for($g = 0; $g<2; $g++){
                $customer = new Customers();
                $customer->setCustomersName($faker->name)
                    ->setCustomersAddress($faker->streetAddress)
                    ->setCustomersCity($faker->city)
                    ->setCustomersZipcode($faker->postcode)
                    ->setCustomersPhone($faker->phoneNumber)
                    ->setCategorietva($catparticulier)
                    ->setEmployee($emp1);
                $manager->persist($customer);

                //to make 2 fake orders :
                for ($o=1; $o<3; $o++){
                    $order = new Totalorder();
                    $order->setTotalorderBilladdress($faker->streetAddress)
                        ->setTotalorderDate($faker->dateTimeThisYear)
                        ->setTotalorderDeliveryaddress($faker->streetAddress)
                        ->setTotalorderInvoicedate($faker->dateTimeThisMonth)
                        ->setTotalorderInvoicenb($faker->randomNumber(6))
                        ->setCustomers($customer);
                    $manager->persist($order);

                    //for each order I make 1 orderdetail item :
                    for ($d=1; $d<2; $d++){
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
        for($m=1; $m<2; $m++){
            $product = new Products();
            $product->setProductsName('Produit n°'.$m)
                ->setProductsDescription($faker->sentence())
                ->setProductsStock($faker->numberBetween($min = 1, $max = 20))
                ->setProductsStatus($faker->boolean)
                ->setProductsPrice($faker->numberBetween($min = 50, $max = 5000))
                ->setProductsPicture("https://picsum.photos/id/" . $faker->numberBetween($min = 1, $max = 1100) . "/290/180")
                ->setRubrique($srcase2);
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

                //to make 2 fake orders :
                for ($o=1; $o<3; $o++){
                    $order = new Totalorder();
                    $order->setTotalorderBilladdress($faker->streetAddress)
                        ->setTotalorderDate($faker->dateTimeThisYear)
                        ->setTotalorderDeliveryaddress($faker->streetAddress)
                        ->setTotalorderInvoicedate($faker->dateTimeThisMonth)
                        ->setTotalorderInvoicenb($faker->randomNumber(6))
                        ->setCustomers($customer);
                    $manager->persist($order);

                    //for each order I make 1 orderdetail item :
                    for ($d=1; $d<2; $d++){
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
        for($m=1; $m<2; $m++){
            $product = new Products();
            $product->setProductsName('Produit n°'.$m)
                ->setProductsDescription($faker->sentence())
                ->setProductsStock($faker->numberBetween($min = 1, $max = 20))
                ->setProductsStatus($faker->boolean)
                ->setProductsPrice($faker->numberBetween($min = 50, $max = 5000))
                ->setProductsPicture("https://picsum.photos/id/" . $faker->numberBetween($min = 1, $max = 1100) . "/290/180")
                ->setRubrique($srcase3);
            $manager->persist($product);

            //to create fake orders of each product - only for customers of emp3:
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

                //to make 2 fake orders :
                for ($o=1; $o<3; $o++){
                    $order = new Totalorder();
                    $order->setTotalorderBilladdress($faker->streetAddress)
                        ->setTotalorderDate($faker->dateTimeThisYear)
                        ->setTotalorderDeliveryaddress($faker->streetAddress)
                        ->setTotalorderInvoicedate($faker->dateTimeThisMonth)
                        ->setTotalorderInvoicenb($faker->randomNumber(6))
                        ->setCustomers($customer);
                    $manager->persist($order);

                    //for each order I make 1 orderdetail item :
                    for ($d=1; $d<2; $d++){
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

        //to make 3 $sono sub-categories :
        $srsono1 = new Rubrique();
        $srsono1->setRubriqueName("Amplificateurs")
            ->setRubriquePicture("ampli.png")
            ->setParent($sono);
        $manager->persist($srsono1);

        $srsono2 = new Rubrique();
        $srsono2->setRubriqueName("Enceintes")
            ->setRubriquePicture("enceinte.png")
            ->setParent($sono);
        $manager->persist($srsono2);

        $srsono3 = new Rubrique();
        $srsono3->setRubriqueName("Tables de mixage")
            ->setRubriquePicture("mixage.png")
            ->setParent($sono);
        $manager->persist($srsono3);

        //to create 1 product in each $sono sub-category (with customers, totalorders and orderdetails for each):
        for($m=1; $m<2; $m++){
            $product = new Products();
            $product->setProductsName('Produit n°'.$m)
                ->setProductsDescription($faker->sentence())
                ->setProductsStock($faker->numberBetween($min = 1, $max = 20))
                ->setProductsStatus($faker->boolean)
                ->setProductsPrice($faker->numberBetween($min = 50, $max = 5000))
                ->setProductsPicture("https://picsum.photos/id/" . $faker->numberBetween($min = 1, $max = 1100) . "/290/180")
                ->setRubrique($srsono1);
            $manager->persist($product);

            //to create fake orders of each product - only for customers of emp1:
            for($g = 0; $g<2; $g++){
                $customer = new Customers();
                $customer->setCustomersName($faker->name)
                    ->setCustomersAddress($faker->streetAddress)
                    ->setCustomersCity($faker->city)
                    ->setCustomersZipcode($faker->postcode)
                    ->setCustomersPhone($faker->phoneNumber)
                    ->setCategorietva($catparticulier)
                    ->setEmployee($emp1);
                $manager->persist($customer);

                //to make 2 fake orders :
                for ($o=1; $o<3; $o++){
                    $order = new Totalorder();
                    $order->setTotalorderBilladdress($faker->streetAddress)
                        ->setTotalorderDate($faker->dateTimeThisYear)
                        ->setTotalorderDeliveryaddress($faker->streetAddress)
                        ->setTotalorderInvoicedate($faker->dateTimeThisMonth)
                        ->setTotalorderInvoicenb($faker->randomNumber(6))
                        ->setCustomers($customer);
                    $manager->persist($order);

                    //for each order I make 1 orderdetail item :
                    for ($d=1; $d<2; $d++){
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
        for($m=1; $m<2; $m++){
            $product = new Products();
            $product->setProductsName('Produit n°'.$m)
                ->setProductsDescription($faker->sentence())
                ->setProductsStock($faker->numberBetween($min = 1, $max = 20))
                ->setProductsStatus($faker->boolean)
                ->setProductsPrice($faker->numberBetween($min = 50, $max = 5000))
                ->setProductsPicture("https://picsum.photos/id/" . $faker->numberBetween($min = 1, $max = 1100) . "/290/180")
                ->setRubrique($srsono2);
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

                //to make 2 fake orders :
                for ($o=1; $o<3; $o++){
                    $order = new Totalorder();
                    $order->setTotalorderBilladdress($faker->streetAddress)
                        ->setTotalorderDate($faker->dateTimeThisYear)
                        ->setTotalorderDeliveryaddress($faker->streetAddress)
                        ->setTotalorderInvoicedate($faker->dateTimeThisMonth)
                        ->setTotalorderInvoicenb($faker->randomNumber(6))
                        ->setCustomers($customer);
                    $manager->persist($order);

                    //for each order I make 1 orderdetail item :
                    for ($d=1; $d<2; $d++){
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
        for($m=1; $m<2; $m++){
            $product = new Products();
            $product->setProductsName('Produit n°'.$m)
                ->setProductsDescription($faker->sentence())
                ->setProductsStock($faker->numberBetween($min = 1, $max = 20))
                ->setProductsStatus($faker->boolean)
                ->setProductsPrice($faker->numberBetween($min = 50, $max = 5000))
                ->setProductsPicture("https://picsum.photos/id/" . $faker->numberBetween($min = 1, $max = 1100) . "/290/180")
                ->setRubrique($srsono3);
            $manager->persist($product);

            //to create fake orders of each product - only for customers of emp3:
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

                //to make 2 fake orders :
                for ($o=1; $o<3; $o++){
                    $order = new Totalorder();
                    $order->setTotalorderBilladdress($faker->streetAddress)
                        ->setTotalorderDate($faker->dateTimeThisYear)
                        ->setTotalorderDeliveryaddress($faker->streetAddress)
                        ->setTotalorderInvoicedate($faker->dateTimeThisMonth)
                        ->setTotalorderInvoicenb($faker->randomNumber(6))
                        ->setCustomers($customer);
                    $manager->persist($order);

                    //for each order I make 1 orderdetail item :
                    for ($d=1; $d<2; $d++){
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

        //when or if needed, add datafixtures for table purchases and delivery :
        //NB : purchases need suppliers and products
        //NB : delivery needs customers and orderdetail

        $manager->flush();
    }
}
