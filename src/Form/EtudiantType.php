<?php

namespace App\Form;

use App\Entity\Etudiant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EtudiantType extends AbstractType
{
    private TranslatorInterface $translator;
    public function __construct(TranslatorInterface $translator)
{
    $this->translator= $translator;
}
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,[
                "required"=>false,
                     "constraints"=>[
                    new NotBlank([
                    'message'=>$this->translator->trans('inscription.email.blank')
                    ]),
                    
                     ]
                    ])
             ->add('password')
            ->add('nomComplet')
           ->add('matricule',TextType::class,[
            
           ])
            ->add('tuteur')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Etudiant::class,
            'constraints' => [
                new UniqueEntity(
                    [
                    'fields' => ['email'],
                  'message'=>$this->translator->trans('inscription.email.unique')
                ])
            ]
        ]);
    }
}
