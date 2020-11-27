<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', TextType::class, [
                'label' => 'Adresse e-mail :',
                'attr' => [
                    'placeholder' => 'annonym@hotmail.com',
                ],
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/',
                        'message' => 'Adresse mail non valide'
                    ]),
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe',
                'help' => 'Plus votre mot de passe est long et comprend des caractères de types variés, plus il est sécurisé !',
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[A-Za-z0-9&\"()!?;:,%$\/\*éèàçâêûîôäëüïö\_\-\s\+]+$/',
                        'message' => 'Caractère(s) non valide(s)'
                    ]),
                ]
            ])

            ->add('confirm_password', PasswordType::class, [
                'label' => 'Répétez votre mot de passe'
            ])

            ->add('role', HiddenType::class, [
                'attr' => [
                    'value' => 'client',
                ],
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
