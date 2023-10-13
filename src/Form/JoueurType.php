<?php

namespace App\Form;

use App\Entity\Joueurs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\Image as ConstraintsImage;

class JoueurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomJoueur')
            ->add('pseudonyme')
            ->add('birthdate', BirthdayType::class)
            // ->add('birthdate', DateType::class, [
            //  'years' => range(1900, 2050)
            //  ])
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class)
            ->add('avatar', FileType::class, [
                'attr' => [
                    'accept' => "image/*"
                ],
                'constraints' => [
                    new Image()
                ]
            ])
            ->add('envoyer', SubmitType::class);
        // ->add('nomJoueur')
        // ->add('pseudonyme')
        // ->add('birthdate')
        // ->add('email')
        // ->add('password')
        // ->add('avatar');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Joueurs::class,
        ]);
    }
}
