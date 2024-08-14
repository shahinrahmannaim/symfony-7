<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Recipe;
use DateTimeImmutable;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PostSubmitEvent;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;


class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('thumbnailFile', FileType::class)
            ->add('category',EntityType::class,[
                'class'=>Category::class,
                'choice_label'=>'name',
                'expanded'=> true,
            ])
            ->add('duration')
            ->add('content')
            ->add('submit', SubmitType::class,[
                'label'=>'Envoyer'
                ])
        ->addEventListener(FormEvents::POST_SUBMIT, $this->attacheTimeStamps(...))
           
            
        ;
    }
   

public function attacheTimeStamps(PostSubmitEvent $event):void{
    
    
    
}



    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
            'csrf_protection' => false
        ]);
    }
}
