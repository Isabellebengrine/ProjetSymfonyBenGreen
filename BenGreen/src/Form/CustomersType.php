<?php

namespace App\Form;

use App\Entity\Categorietva;
use App\Entity\Customers;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class CustomersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('customersName', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Saisissez votre nom',
                ],
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[A-Za-zéèàçâêûîôäëüïö\-\s]+$/',
                        'message' => 'Caractère(s) non valide(s)'
                    ]),
                ]
            ])
            ->add('customersAddress', TextType::class, [
                'label' => 'Adresse',
                'attr' => [
                    'placeholder' => 'Saisissez votre adresse',
                ],
            ])
            ->add('customersZipcode', NumberType::class, [
                'label' => 'Code Postal',
                'attr' => [
                    'placeholder' => 'Saisissez votre code postal',
                ],
            ])
            ->add('customersCity', TextType::class, [
                'label' => 'Ville',
                'attr' => [
                    'placeholder' => 'Saisissez votre ville',
                ],
            ])
            ->add('customersPhone', TextType::class, [
                'label' => 'Téléphone',
                'attr' => [
                    'placeholder' => 'Saisissez votre numéro de téléphone',
                ],
            ])
            ->add('categorietva', EntityType::class, [
                'label' =>'Catégorie de TVA',
                'class' => Categorietva::class,
                'choice_label' => 'categorietvaNom',
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('Valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Customers::class,
        ]);
    }
}
