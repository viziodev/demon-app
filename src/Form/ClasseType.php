<?php

namespace App\Form;

use App\Entity\Classe;
use Symfony\Component\Form\AbstractType;
use Twig\Node\Expression\Binary\SubBinary;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

class ClasseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle',TextType::class,[
                "required"=>false,
                "constraints"=>[
                    new NotBlank([
                        "message"=>"Le Libelle est Obligatoires"
               ])
               ]])
              ->add('niveau')
              ->add('filiere')
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
            'data_class' => Classe::class,
            'constraints' => [
                new UniqueEntity(
                    [
             'fields' => ['libelle'],
             'message'=>"Le libelle est unique"
          ]) 
          ]
        ]);
    }
}
