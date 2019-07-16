<?php

namespace App\Form;

use App\Entity\Post;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content')
            ->add('updatedAt', DateTimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('createdAt', DateTimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('user',  EntityType::class, [
                'choice_label' => 'id',
                'by_reference' => true,
                'multiple' => false,
                'expanded' => true,
                'class'    => User::class,
                'query_builder' => function(\Doctrine\ORM\EntityRepository $er) {
                    $qb = $er->createQueryBuilder('d');
                    return $qb->orderBy('d.firstName', 'ASC');
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
            'csrf_protection' => false,
            'validation_groups' => false,
        ]);
    }
}
