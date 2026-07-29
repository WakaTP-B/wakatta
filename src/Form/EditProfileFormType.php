<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;

class EditProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', RepeatedType::class, [
                'type' => EmailType::class,
                'mapped' => false,
                'required' => false,
                'invalid_message' => 'Les emails ne correspondent pas',
                'first_options' => [
                    'label' => 'Nouveau mail',
                    'attr' => ['placeholder' => 'Nouveau mail...'],
                    'constraints' => [
                        new Email(message: 'Cette adresse email n\'est pas valide'),
                    ],
                ],
                'second_options' => [
                    'label' => 'Confirmer nouveau mail',
                    'attr' => ['placeholder' => 'Confirmer nouveau mail...'],
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'required' => false,
                'invalid_message' => 'Les mots de passe ne correspondent pas',
                'first_options' => [
                    'label' => 'Changer mot de passe',
                    'attr' => ['autocomplete' => 'new-password', 'placeholder' => 'Nouveau mot de passe...'],
                    'constraints' => [
                        new Length(min: 6, minMessage: 'Votre mot de passe doit comporter au moins {{ limit }} caractères', max: 4096),
                    ],
                ],
                'second_options' => [
                    'label' => 'Confirmer nouveau mot de passe',
                    'attr' => ['autocomplete' => 'new-password', 'placeholder' => 'Confirmer nouveau mot de passe...'],
                ],
            ])
            ->add('currentPassword', PasswordType::class, [
                'label' => 'Mot de passe actuel',
                'mapped' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Mot de passe actuel...'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
