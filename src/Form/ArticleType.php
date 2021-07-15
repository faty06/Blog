<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class,[
                'label' => 'Titre'
            ])
            ->add('content', TextareaType::class,[
                'label' => 'Contenu'
            ])
            ->add('createAt', DateTimeType::class, [
                'widget' => 'single_text', //mettre
                'label' => "Date de création",
                'data' => new \DateTime('NOW') // je prets rempli le champ avec la date du jour
            ])
            ->add('isPulished',CheckboxType::class, [
                'label' => 'Publié',
                'data' => true // ici le checkbox est automatique pret rempli
            ])
            //->add('category')
            //->add('tag')
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
