<?php

namespace App\Form;

use App\Entity\FlashSale;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FlashSaleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('beginDate', DateTimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('endDate', DateTimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('products',  CollectionType::class)
            ->add('price')
        ;
    }

    //2011-06-05 12:15:00

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FlashSale::class,
            'csrf_protection' => false,
            'validation_groups' => false,
        ]);
    }
}
