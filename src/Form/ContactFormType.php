<?php

namespace App\Form;

use App\Entity\Contact;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, options:[
                'attr' => [
                    'minlength' => '5',
                    'maxlength' => '30',
                    'autofocus' => null
                ],
                'label' => 'Email'
            ])
            ->add('name', TextType::class, options:[
                'attr' => [
                    'minlength' => '3',
                    'maxlength' => '20'
                ],
                'label' => 'Name'
            ])
            ->add('subject', TextType::class, options:[
                'attr' => [
                    'minlength' => '3',
                    'maxlength' => '30'
                ],
                'label' => 'Subject'
            ])
            ->add('message', TextType::class, options:[
                'attr' => [
                    'minlength' => '3',
                    'maxlength' => '200'
                ],
                'label' => 'Message'
            ])
            ->add('submit', SubmitType::class, options:[
                'attr' => [
                    'class' => 'margin-bottom-none'
                ],
                'label' => 'Send',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
            'attr' => ['id' => 'contact']
        ]);
    }
}