<?php

namespace App\Form;

use App\Entity\Products;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
            ->add('productsDescription', TextType::class, [
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
            ->add('productsStock', TextType::class, [
                'label' => 'Quantité en stock',
                //'help' => 'Indiquez ici le nom du produit',
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

            ->add('productsStatus', TextType::class, [
                'label' => 'Statut',
                'attr' => [
                    'placeholder' => 'Choisir 0 ou 1',
                ],
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[0-1]{1}$/',
                        'message' => 'Caractère(s) non valide(s)'
                    ]),
                ]
            ])
            ->add('productsPrice', TextType::class, [
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
