<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('image')
            ->add('status')
            ->add('price')
            ->add('discountEndDate', DateTimeType::class, array(
                'widget' => 'single_text',
            ))
            ->add('discountBeginDate', DateTimeType::class, array(
                'widget' => 'single_text',
            ))
            ->add('discount')
            ->add('seller')
            ->add('category')
        ;
    }

//2011-06-05 12:15:00

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
            'csrf_protection' => false,
            'validation_groups' => false,
        ]);
    }
}
