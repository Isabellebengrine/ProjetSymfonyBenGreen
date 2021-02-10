<?php

namespace App\Form;

use App\Entity\Products;
use App\Entity\Purchases;
use App\Entity\Suppliers;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PurchasesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('purchasesSuppliersref', TextType::class, [
                'label' => 'Réf. du Fournisseur',
            ])
            ->add('purchasesDate', DateType::class, [
                'widget' => 'choice',
                'label' => 'Date d\'achat',
            ])
            ->add('purchasesPrice', MoneyType::class, [
                'label' => 'Prix',
            ])
            ->add('purchasesQuantity', IntegerType::class, [
                'label' => 'Quantité achetée',
            ])
            ->add('suppliers', EntityType::class, [
                'class' => Suppliers::class,
                'label' => 'Nom du Fournisseur',
            ])
            ->add('products', EntityType::class, [
                'class' => Products::class,
                'label' => 'Nom du Produit acheté',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Purchases::class,
        ]);
    }
}
