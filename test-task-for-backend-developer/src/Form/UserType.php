<?php

namespace App\Form;

use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('name', TextType::class, [
                'label'  => 'Eesnimi:',
            ])
            ->add('lastname', TextType::class, [
                'label'  => 'Perekonnanimi:',
            ])
            ->add('personalCode', TextType::class, [
                'label'  => 'Isikukood:',
            ])
            ->add('phone', TextType::class, [
                'label'  => 'Telefon:',
            ])
            ->add('email', EmailType::class, [
                'label'  => 'Email',
            ])
            ->add('code', TextType::class, [
                'label'  => 'Kood:',
            ])
            ->add('birthday', BirthdayType::class, [
                'label'  => 'Sünnipäev:',
            ])
            ->add('username', TextType::class, [
                'label'  => 'Kasutajanimi:',
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options'  => ['label' => 'Parool'],
                'second_options' => ['label' => 'Parool uuesti'],
                'invalid_message' => 'Paroolid ei ole samad!'
            ]);

            if(in_array('ROLE_OWNER', $options['role'])) {
                // do as you want if admin
                $builder
                    ->add('position', ChoiceType::class, [
                        'choices'  => array(
                            'Omanik' => 'Omanik',
                            'Direktor' => 'Direktor',
                            'Kaupluse juht' => 'Kaupluse juht',
                            'Assistent' => 'Assistent',
                            'Kassapidaja' => 'Kassapidaja',
                            'Remontija' => 'Remontija'
                        ),
                        'label'  => 'Amet:'
                    ]);
            } else if(in_array('ROLE_MANAGER', $options['role'])) {
                $builder
                    ->add('position', ChoiceType::class, [
                        'choices'  => array(
                            'Kaupluse juht' => 'Kaupluse juht',
                            'Assistent' => 'Assistent',
                            'Kassapidaja' => 'Kassapidaja',
                            'Remontija' => 'Remontija'
                        ),
                        'label'  => 'Amet:'
                    ]);
            } else if(in_array('ROLE_LEADER', $options['role'])) {
                $builder
                ->add('position', ChoiceType::class, [
                    'choices' => array(
                        'Kassapidaja' => 'Kassapidaja',
                    ),
                    'label'  => 'Amet:'
                ]);
            } 
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'validation_groups' => array('addUser'),
            'data_class' => User::class,
            'role' => ['ROLE_USER']
        ]);
    }
}
