<?php

namespace App\Form;

use App\Entity\TestVocable;
use App\Enum\Direction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TestVocableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
            /** @var TestVocable $entity */
            $entity = $event->getData();
            $event->getForm()->get('vocable')->setData(Direction::TranslateInbound === $entity->getDirection() ? $entity->getVocable()->getOriginal() : $entity->getVocable()->getTranslation())
            ;
        });

        $builder
            ->add('id', HiddenType::class)
            ->add('vocable', TextType::class, [
                'mapped' => false,
                'label' => false,
                'disabled' => true,
            ])
	        ->add('answer', TextType::class, ['label' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TestVocable::class,
        ]);
    }
}
