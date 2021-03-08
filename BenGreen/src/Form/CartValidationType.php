<?php

namespace App\Form;

use App\Entity\Totalorder;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class CartValidationType extends AbstractType
{
    private $security;

    public function __construct (Security $security) {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('totalorderBilladdress', \Symfony\Component\Form\Extension\Core\Type\TextType::class, [
                'label' => 'Adresse de facturation'
            ])
            ->add('totalorderDeliveryaddress', \Symfony\Component\Form\Extension\Core\Type\TextType::class, [
                'label' => 'Adresse de livraison'
            ])
            ->add('customers', EntityType::class, [
                'class' => \App\Entity\Customers::class,
                'label' => 'Client',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->where('c = :customer')
                        ->setParameter('customer', $this->security->getUser()->getCustomer());
                }
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
