<?php

namespace App\Form;

use App\Entity\Medecin;
use App\Entity\Service;
use App\Entity\Specialite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SpecialiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle')
            //->add('service')
            ->add('service', EntityType::class,[
                'class' => Service::class,
                'choice_label' => 'libelle'
            ])
            //->add('medecins')
            ->add('medecins', EntityType::class,[
                'class' => Medecin::class,
                'choice_label' => 'prenom',
                'multiple' => true,
                'by_reference' => false
            ])
            ->add('save', SubmitType::class);


        }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Specialite::class,
        ]);
    }
}
