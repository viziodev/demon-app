<?php

namespace App\Form;

use App\Form\EtudiantType;
use App\Entity\Inscription;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('classe')
            ->add('etudiant',EtudiantType::class,[
                'label'=>false, 
                "required"=>false,
                "label_attr" => [
                    "class" => "d-none"
                ], 
                'attr'=>[ ]
            ])
            ->add('save',SubmitType::class,[
                'label' => 'Enregistrer',
                'attr'=>[
                  'class'=>'btn btn-primary btn-sm btn-sm float-right'
                ],
                
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Inscription::class,
        ]);
    }
}
