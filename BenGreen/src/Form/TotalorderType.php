<?php

namespace App\Form;

use App\Entity\Totalorder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TotalorderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('orderdetails', CollectionType::class, [
                'entry_type' => OrderdetailType::class
            ])
//            ->add('totalorderDate')
//            ->add('updatedAt')
//            ->add('totalorderBilladdress')
//            ->add('totalorderDeliveryaddress')
//            ->add('totalorderDiscount')
//            ->add('totalorderInvoicenb')
//            ->add('totalorderInvoicedate')
//            ->add('totalorderDeadline')
//            ->add('status')
//            ->add('customers')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Totalorder::class,
        ]);
    }
}
