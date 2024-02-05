<?php

namespace App\Form;

use App\Entity\Adventurer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdventurerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('class')
            ->add('health', NumberType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
    }
}