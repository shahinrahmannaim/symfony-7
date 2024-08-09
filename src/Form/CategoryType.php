<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Recipe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PostSubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
                'empty_data'=> ''
            ])
            ->add('recipes',EntityType::class,[
                'class'=>Recipe::class,
                'choice_label'=>'title',
                'multiple'=>true,
                'expanded'=>true,
                'by_reference'=>false
            ])
          
            ->add('save', SubmitType::class,[
                'label'=>'Enregistre'
            ])
           ->addEventListener(FormEvents::POST_SUBMIT, $this->attacheTimeStamps(...))
         
        ;
    }
    public function attacheTimeStamps(PostSubmitEvent $event):void{
    
    
    
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
            'csrf_protection' => false
        ]);
    }
}
