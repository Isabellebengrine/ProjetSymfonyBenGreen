<?php

namespace App\Form;

use App\Entity\Totalorder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('items', CollectionType::class, [
                'entry_type' => CartItemType::class
            ])
            ->add('totalorderBilladdress', TextType::class, [
                'label' => 'Adresse de facturation'
            ])
            ->add('totalorderDeliveryaddress', TextType::class, [
                'label' => 'Adresse de livraison'
            ])
            ->add('totalorderDiscount')
            //->add('customers')
            ->add('save', SubmitType::class)
            ->add('clear', SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Totalorder::class,
        ]);
    }
}
