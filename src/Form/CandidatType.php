<?php

namespace App\Form;

use App\Entity\Candidat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;


class CandidatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username' ,TextType::class)
            ->add('Email', EmailType::class)
            ->add('Password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options' => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
            ))
            ->add('civilite' ,TextType::class)
            ->add('dateDeNaissance' ,BirthdayType::class)
            ->add('lieuNaissance' ,TextType::class)
            ->add('adresse' ,TextType::class)
            ->add('ville' ,TextType::class)
            ->add('nationalite' ,TextType::class)
            ->add('telephone' ,TextType::class)
            ->add('cv' ,FileType::class , array(
                'required' => false,
                'data_class' => null,))
            ->add('lettreDeMotivation' ,FileType::class , array(
                'required' => false,
                'data_class' => null,))
            ->add('specialite' ,TextType::class)
            ->add('etablissement' ,TextType::class)
            ->add('photo', FileType::class, [
                'label' => ' votre photo',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // everytime you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',

                        'mimeTypesMessage' => 'Please upload a valid jpg image',
                    ])
                ],
            ])

            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Candidat::class,
        ]);
    }
}
