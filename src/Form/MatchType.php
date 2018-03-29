<?php

namespace App\Form;


use App\Entity\Match;
use App\Entity\Participant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MatchType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number', IntegerType::class, array(
                'attr' => array('class' => 'form-control')
            ))
            ->add('participant1', EntityType::class, array(
                'class' => Participant::class,
                'choice_label' => 'name',
                'placeholder' => 'Choose participant 1',
                'attr' => array('class' => 'form-control')
            ))
            ->add('score1', IntegerType::class, array(
                'attr' => array('class' => 'form-control')
            ))
            ->add('participant2', EntityType::class, array(
                'class' => Participant::class,
                'choice_label' => 'name',
                'placeholder' => 'Choose participant 2',
                'attr' => array('class' => 'form-control')
            ))
            ->add('score2', IntegerType::class, array(
                'attr' => array('class' => 'form-control')
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Match::class
        ));
    }
}