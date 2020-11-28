<?php

namespace App\Form;

use App\Entity\Products;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Regex;

class ProductsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('productsName', TextType::class, [
                'label' => 'Nom du produit',
                'help' => 'Indiquez ici le nom du produit',
                'attr' => [
                    'placeholder' => 'Produit',
                ],
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[A-Za-zéèàçâêûîôäëüïö\_\-\s]+$/',
                        'message' => 'Caractère(s) non valide(s)'
                    ]),
                ]
            ])
            ->add('productsDescription', TextareaType::class, [
                'label' => 'Description',
                //'help' => 'Indiquez ici la description du produit',
                'attr' => [
                    'placeholder' => 'Description',
                ],
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[A-Za-zéèàçâêûîôäëüïö\_\-\s]+$/',
                        'message' => 'Caractère(s) non valide(s)'
                    ]),
                ]
            ])
            ->add('productsStock', NumberType::class, [
                'label' => 'Quantité en stock',
                'attr' => [
                    'placeholder' => 'Stock',
                ],
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[0-9]+$/',
                        'message' => 'Caractère(s) non valide(s)'
                    ]),
                ]
            ])

            ->add('productsPicture')

            ->add('productsStatus', CheckboxType::class, [
                'label' => 'Statut: Actif?',
                'required' => false,
            ])
            ->add('productsPrice', MoneyType::class, [
                'label' => 'Prix',
                'attr' => [
                    'placeholder' => 'Prix en euros',
                ],
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[0-9.,]+$/',
                        'message' => 'Caractère(s) non valide(s)'
                    ]),
                ]
            ])
            ->add('rubrique')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Products::class,
        ]);
    }
}
