<?php

namespace App\Form;

use App\Entity\Suppliers;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SuppliersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('suppliersName', TextType::class, [
                'label' => 'Nom du Fournisseur',
            ])
            ->add('suppliersAddress', TextType::class, [
                'label' => 'Adresse du Fournisseur',
            ])
            ->add('suppliersZipcode', TextType::class, [
                'label' => 'Code postal',
            ])
            ->add('suppliersCity', TextType::class, [
                'label' => 'Ville',
            ])
            ->add('suppliersPhone', TextType::class, [
                'label' => 'Téléphone',
            ])
            ->add('supplierstype', EntityType::class, [
                'class' => \App\Entity\Supplierstype::class,
                'label' => 'Catégorie',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Suppliers::class,
        ]);
    }
}
