<?php

namespace App\Form;

use App\Entity\Medecin;
use App\Entity\Service;
use App\Entity\Specialite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MedecinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('matricule', HiddenType::class)
            ->add('email')
            ->add('prenom')
            ->add('nom')
            ->add('telephone')
            ->add('datenaissance' , DateType::class,[
                'widget'=>'single_text',
                'format'=> 'yyyy-MM-dd'
            ] )
            ->add('service', EntityType::class,[
                'class' => Service::class,
                'choice_label' => 'libelle'
            ])
            ->add('specialites', EntityType::class,[
                'class' => Specialite::class,
                'choice_label' => 'libelle',
                'multiple' => true,
                'by_reference' => false

            ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Medecin::class,
        ]);
    }
}


