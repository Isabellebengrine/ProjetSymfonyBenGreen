<?php

namespace App\Form;

use App\Entity\Totalorder;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TotalorderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('totalorderDate', DateType::class, [
                'label' => 'Date'
            ])
            ->add('updatedAt', DateType::class, [
                'label' => 'Modifiée le'
            ])
            ->add('totalorderBilladdress', \Symfony\Component\Form\Extension\Core\Type\TextType::class, [
                'label' => 'Adresse de facturation'
            ])
            ->add('totalorderDeliveryaddress', \Symfony\Component\Form\Extension\Core\Type\TextType::class, [
                'label' => 'Adresse de livraison'
            ])
            ->add('totalorderDiscount', NumberType::class, [
                'label' => 'Discount'
            ])
            ->add('totalorderInvoicenb', NumberType::class, [
                'label' => 'N° Facture'
            ])
            ->add('totalorderInvoicedate', DateType::class, [
                'label' => 'Date de facture'
            ])
            ->add('totalorderDeadline', DateType::class, [
                'label' => 'Echéance'
    ])
            ->add('status', \Symfony\Component\Form\Extension\Core\Type\TextType::class, [
                'label' => 'Statut'
            ])
            ->add('customers', EntityType::class, [
                'class' => \App\Entity\Customers::class,
                'label' => 'Client'
            ])
            ->add('orderdetails', CollectionType::class, [
                // each entry in the array will be an "orderdetail" field
                'entry_type' => OrderdetailType::class,
                'label' => 'Détails :'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Totalorder::class,
        ]);
    }
}
