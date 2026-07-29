<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UsernameFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', null, [
                'label' => false,
                'constraints' => [
                    new NotBlank(message: 'Le nom d\'utilisateur ne peut pas être vide'),
                    new Length(min: 3, minMessage: 'Au moins {{ limit }} caractères', max: 50),
                ],
            ])
        ;
    }
}