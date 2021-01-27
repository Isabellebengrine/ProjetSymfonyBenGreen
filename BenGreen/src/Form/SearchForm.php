<?php


namespace App\Form;


use App\Data\SearchData;
use App\Entity\Rubrique;
use App\Repository\RubriqueRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchForm extends AbstractType
{
    //to build form used in search on catalogue:
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('q', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Rechercher'
                ]
            ])
            ->add('rubriques', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => Rubrique::class,
                'query_builder' => function (RubriqueRepository $repo){
                    return $repo->createQueryBuilder('r')
                        ->select('r')
                        ->where('r.parent is null');//only main product categories
                },
                //to have a list of checkboxes :
                'expanded' => true,
                'multiple' => true
            ])
            ->add('min', NumberType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Prix min'
                ]
            ])
            ->add('max', NumberType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Prix max'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        //to remove the default return of SearchData array:
        return '';
    }

}