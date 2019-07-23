<?php

namespace App\Form;

use App\Entity\Order;
use App\Entity\OrderLine;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderLineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantity')
            ->add('price')
            ->add('product',  EntityType::class, [
                'choice_label' => 'id',
                'by_reference' => true,
                'multiple' => false,
                'expanded' => true,
                'class'    => Product::class,
                'query_builder' => function(\Doctrine\ORM\EntityRepository $er) {
                    $qb = $er->createQueryBuilder('d');
                    return $qb->orderBy('d.name', 'ASC');
                }
            ])
            ->add('order',  EntityType::class, [
                'choice_label' => 'id',
                'by_reference' => true,
                'multiple' => false,
                'expanded' => true,
                'class'    => Order::class,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OrderLine::class,
            'csrf_protection' => false,
            'validation_groups' => false,
        ]);
    }
}
