<?php

namespace App\Form;

use App\Entity\Property;
use App\Entity\PropertyType as EntityPropertyType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description'
            ])
            ->add('superficie', NumberType::class, [
                'label' => 'Superficie'
            ])
            ->add('price', NumberType::class, [
                'label' => 'Prix'
            ])
            ->add('capacity', NumberType::class, [
                'label' => 'Capacité'
            ])
            ->add('rooms', NumberType::class, [
                'label' => 'Chambres'
            ])
            ->add('pieces', NumberType::class, [
                'label' => 'Pièces'
            ])
            ->add('water', CheckboxType::class, [
                'label' => 'Eau',
                "required" => false
            ])
            ->add('electricity', CheckboxType::class, [
                'label' => 'Électricité',
                "required" => false
            ])
            ->add('literie', TextareaType::class, [
                'label' => 'Literie',
            ])
            ->add('sanitaire', TextareaType::class, [
                'label' => 'Sanitaires',
            ])
            ->add('includes', TextareaType::class, [
                'label' => 'Les inclus',
            ])
            ->add('activities', TextareaType::class, [
                'label' => 'Activités',
            ])
            ->add('propertyType', EntityType::class, [
                'label' => 'Type de propriété',
                "class" => EntityPropertyType::class,
                "choice_label" => "title",
                "attr" => [
                    "class" => "form-control"
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }
}
