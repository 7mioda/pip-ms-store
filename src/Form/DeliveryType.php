<?php

namespace App\Form;

use App\Entity\Delivery;
use App\Entity\Order;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeliveryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('status')
            ->add('address')
            ->add('coordinateX')
            ->add('coordinateY')
            ->add('createdAt', DateTimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('deliveredAt', DateTimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('order',  EntityType::class, [
                'choice_label' => 'id',
                'by_reference' => true,
                'expanded' => true,
                'class'    => Order::class,
                'query_builder' => function(\Doctrine\ORM\EntityRepository $er) {
                    $qb = $er->createQueryBuilder('d');
                    return $qb->orderBy('d.id', 'ASC');
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Delivery::class,
            'csrf_protection' => false,
            'validation_groups' => false,
        ]);
    }
}
