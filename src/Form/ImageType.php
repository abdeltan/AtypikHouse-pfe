<?php

namespace App\Form;

use App\Entity\Image;
use App\Entity\Property;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'path',
                FileType::class,
                [
                    'label' => 'Image',
                    'constraints' => [
                        new File([
                            'maxSize' => '1M',
                            'mimeTypes' => [
                                'image/*',
                            ],
                            'mimeTypesMessage' => 'Please upload a valid Image document',
                        ])
                    ],
                ]
            )
            ->add('property', EntityType::class, [
                'label' => 'Annonce',
                "class" => Property::class,
                "choice_label" => "title",
                "attr" => [
                    "class" => "form-control"
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }
}
