<?php

namespace App\Form;

use App\Entity\Order;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('createdAt', DateTimeType::class, array(
                'widget' => 'single_text',
            ))
            ->add('validatedAt', DateTimeType::class, array(
                'widget' => 'single_text',
            ))
            ->add('totalPrice')
            ->add('note')
            ->add('user',  EntityType::class, [
                'choice_label' => 'id',
                'by_reference' => true,
                'expanded' => true,
                'class'    => User::class,
                'query_builder' => function(\Doctrine\ORM\EntityRepository $er) {
                    $qb = $er->createQueryBuilder('d');
                    return $qb->orderBy('d.firstName', 'ASC');
                }
            ])
//            ->add('delivery')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
            'csrf_protection' => false,
            'validation_groups' => false,
        ]);
    }
}
