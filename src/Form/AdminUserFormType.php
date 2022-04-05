<?php

namespace App\Form;


use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminUserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Prénom'
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('sex', ChoiceType::class, [
                'label' => 'Sexe',
                'attr' => ['class' => 'form-control'],
                'choices'  => [
                    'Homme' => 'Homme',
                    'Femme' => 'Femme',
                    'Je préfère ne pas le dire' => 'Je préfère ne pas le dire',
                ],
            ])
            ->add('email', EmailType::class,[
                'label' => 'Email'
            ])
            ->add('phone', TextType::class,[
                'label' => 'Tél'
            ])
            ->add('birthDate', DateType::class, [
                'label' => 'Date de naissance',
                'widget' => 'single_text',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
