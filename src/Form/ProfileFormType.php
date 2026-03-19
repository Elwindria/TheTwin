<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;

class ProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', null, ['empty_data' => ''])
            ->add('lastName', null, ['empty_data' => ''])
            ->add('email', EmailType::class, ['empty_data' => ''])
            // Champ pour uploader une photo de profil (pas obligatoire)
            ->add('avatarFile', FileType::class, [
                'mapped'   => false, // ce champ ne correspond pas directement à une propriété de User
                'required' => false,
                'label'    => 'Photo de profil',
                'constraints' => [
                    new File(
                        maxSize: '2M',
                        mimeTypes: ['image/jpeg', 'image/png', 'image/webp'],
                        mimeTypesMessage: 'Veuillez uploader une image valide (jpg, png, webp)',
                    ),
                ],
            ])
            ->add('newPassword', RepeatedType::class, [
                'type'           => PasswordType::class,
                'mapped'         => false,
                'required'       => false,
                'first_options'  => ['label' => 'Nouveau mot de passe'],
                'second_options' => ['label' => 'Confirmer le mot de passe'],
                'constraints'    => [
                    new Length(
                        min: 6,
                        minMessage: 'Le mot de passe doit faire au moins {{ limit }} caractères',
                        max: 4096,
                    ),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
