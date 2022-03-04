<?php

namespace App\Form;

use App\Entity\Attribute;
use App\Entity\PropertyType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AttributeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre'
            ])
            ->add('required', CheckboxType::class, [
                'label' => 'Obligatoire'
            ])
            ->add('propertyType', EntityType::class, [
                'label' => 'Obligatoire',
                "class" => PropertyType::class,
                "choice_label" => "title",
                'multiple' => true,
                'expanded' => false,
                "attr" => [
                    "class" => "form-control"
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Attribute::class,
        ]);
    }
}
