<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('cin')
            ->add('phoneNumber')
            ->add('email')
            ->add('password')
            ->add('roles')
            ->add('address')
            ->add('status')
            ->add('coordinateLat')
            ->add('coordinateLng')
            //->add('cardNumber')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_protection' => false,
            'validation_groups' => false,
        ]);
    }
}
