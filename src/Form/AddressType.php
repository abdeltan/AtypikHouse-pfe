<?php

namespace App\Form;

use App\Entity\Addresse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('street_number', NumberType::class, [
                'label' => 'Rue N°'
            ])
            ->add('street_name', TextType::class, [
                'label' => 'Nom de rue'
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville'
            ])
            ->add('code_zip', TextType::class, [
                'label' => 'Code postal'
            ])
            ->add('country', CountryType::class, [
                'label' => 'Pays',
                'preferred_choices' => array('FR'),
                'choice_translation_locale' => 'fr',
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            /* ->add('save', SubmitType::class, ['label' => 'Enregister']) */;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Addresse::class,
        ]);
    }
}
