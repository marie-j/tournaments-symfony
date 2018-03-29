<?php

namespace App\Form;

use App\Entity\Participant;
use App\Entity\Tournament;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TournamentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'attr' => array('class' => 'form-control')
            ))
            ->add('date', DateType::class, array(
                'attr' => array('class' => 'form-group')
            ))
            ->add('type', TextType::class, array(
                'attr' => array('class' => 'form-control')
            ))
            ->add('participants', EntityType::class, array(
                'class' => Participant::class,
                'choice_label' => 'name',
                'multiple' => true,
                'attr' => array('class' => 'form-control')
            ))
            ->add('winner', EntityType::class, array(
                'class' => Participant::class,
                'choice_label' => 'name',
                'placeholder' => 'Choose a winner',
                'required' => false,
                'attr' => array('class' => 'form-control')
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Tournament::class
        ));
    }
}