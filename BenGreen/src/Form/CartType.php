<?php

namespace App\Form;

use App\Entity\Totalorder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('orderdetails', CollectionType::class, [
                'entry_type' => CartItemType::class
            ])
            ->add('totalorderBilladdress', TextType::class, [
                'label' => 'Adresse de facturation'
            ])
            ->add('totalorderDeliveryaddress', TextType::class, [
                'label' => 'Adresse de livraison'
            ])
            //->add('totalorderDiscount')//see later if we add a discount field in cart page
            //->add('customers')
            ->add('save', SubmitType::class, [
                'label' => 'Valider'
            ])
            ->add('clear', SubmitType::class, [
                'label' => 'Effacer'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Totalorder::class,
        ]);
    }
}
