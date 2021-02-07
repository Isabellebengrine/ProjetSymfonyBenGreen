<?php

namespace App\Form;

use App\Entity\Suppliers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SuppliersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('suppliersName')
            ->add('suppliersAddress')
            ->add('suppliersZipcode')
            ->add('suppliersCity')
            ->add('suppliersPhone')
            ->add('supplierstype')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Suppliers::class,
        ]);
    }
}
