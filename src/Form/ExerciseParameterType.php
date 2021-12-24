<?php

namespace App\Form;

use App\Enum\Direction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Range;

class ExerciseParameterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('direction', ChoiceType::class, [
                'choices' => [
                    'Dans les deux sens' => Direction::TranslateBoth,
                    'Uniquement vers ma langue maternelle' => Direction::TranslateInbound,
                    'Uniquement vers ma langue d\'apprentissage' => Direction::TranslateOutbound,
                ],
                'constraints' => [
                    new Choice(Direction::cases())
                ]
            ])
            ->add('count', NumberType::class, [
                'attr' => [
                    'min' => 5,
                    'max' => 50,
                    'step' => 5,
                    'value' => 25
                ],
                'label' => 'Nombre de mots à réviser',
                'constraints' => [
                    new Range(['min' => 5, 'max' => 50])
                ]
            ])
            ->add('revision', CheckboxType::class, [
                'label' => 'Ne pas inclure des mots que je connais déjà',
                'required' => false
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Lancer le test',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
