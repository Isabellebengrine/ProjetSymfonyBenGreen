<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class)

            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options' => array(
                    'label' => 'Mot de passe',
                    'help' => 'Plus votre mot de passe est long et comprend des caractères de types variés, plus il est sécurisé !',
                    'constraints' => [
                        new Regex([
                            'pattern' => '/^[A-Za-z0-9&\"()!?;:,%$\/\*éèàçâêûîôäëüïö\_\-\s\+]+$/',
                            'message' => 'Caractère(s) non valide(s)'
                        ]),]
                ),
                'second_options' => array(
                    'label' => 'Confirmation du mot de passe'
                ),
            ))

            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous avez oublié de cocher cette case',
                    ]),
                ],
            ])

            ->add('role', HiddenType::class, [
                'attr' => [//valeur par défaut :
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
