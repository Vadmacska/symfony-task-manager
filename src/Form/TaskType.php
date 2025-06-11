<?php

namespace App\Form;

use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('description', TextareaType::class)
            ->add('deadline', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Oczekujący' => 'Oczekujący',
                    'Wykonany' => 'Wykonany',
                    'Odrzucony' => 'Odrzucony',
                ],
            ])
            ->add('parent', EntityType::class, [
                'class' => Task::class,
                'choice_label' => 'title',
                'required' => false,
                'placeholder' => 'Brak (zadanie główne)',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
