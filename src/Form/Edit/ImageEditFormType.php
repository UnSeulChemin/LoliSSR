<?php

namespace App\Form\Edit;

use App\Entity\Image;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ImageEditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, options:[
                'label' => 'Name'
            ])
            ->add('type', TextType::class, options:[
                'label' => 'Type'
            ])
            ->add('gender', TextType::class, options:[
                'label' => 'Gender'
            ])
            ->add('submit', SubmitType::class, options:[
                'attr' => [
                    'class' => 'margin-bottom-none'
                ],                
                'label' => 'Edit Image',
            ])            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
            'attr' => ['id' => 'edit_image']
        ]);
    }
}