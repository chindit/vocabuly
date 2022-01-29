<?php

namespace App\Form;

use App\Entity\TestExercise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TestExerciseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('vocables', CollectionType::class, [
                'entry_type' => TestVocableType::class,
                'allow_add' => false,
                'delete_empty' => false,
                'allow_delete' => false,
                'by_reference' => false,
                'entry_options' => ['label' => false],
                'label' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Soumettre',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TestExercise::class,
        ]);
    }
}
