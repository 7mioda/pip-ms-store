<?php

namespace App\Form;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content')
            ->add('createdAt', DateTimeType::class, [
                'widget' => 'single_text',])
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
            ->add('post',  EntityType::class, [
                'choice_label' => 'id',
                'by_reference' => true,
                'multiple' => false,
                'expanded' => true,
                'class'    => Post::class,
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
            'data_class' => Comment::class,
            'csrf_protection' => false,
            'validation_groups' => false,
        ]);
    }
}