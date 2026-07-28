<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class DeleteAccountFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('password', PasswordType::class, [
                'label' => 'Confirmez avec votre mot de passe',
                'mapped' => false,
                'attr' => ['placeholder' => 'Mot de passe...'],
                'constraints' => [
                    new NotBlank(message: 'Veuillez entrer votre mot de passe pour confirmer'),
                ],
            ])
        ;
    }
}