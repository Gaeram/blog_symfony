<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\ArticleCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('isPublished')
            ->add('author')
            ->add('content')

            // Ajout champ category pour article.html.twig
            // Ajout entityType pour le lier à une entité
            // Parametre input pour les categories

            ->add('category', EntityType::class, [
                'class'=> ArticleCategory::class,
                'choice_label'=> 'title'

            ])

            ->add('image', FileType::class, [
                'mapped'=>false,
                'required'=>false
            ])
            ->add('submit',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
