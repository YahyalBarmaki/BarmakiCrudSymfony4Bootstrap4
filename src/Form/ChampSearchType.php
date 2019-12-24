<?php

namespace App\Form;

use App\Entity\PersonSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChampSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class,[
                'label'=> false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Donner votre nom'
                ]
            ])
            ->add('prenom',TextType::class,[
                'label'=> false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Donner votre prenom'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PersonSearch::class,
            'method'=> 'get',
            'csrf_protection'=> false
        ]);
    }
    public function getBlocPrefix(){
        return '';
    }
}
