<?php

namespace App\Form;

use App\Entity\Module;
use App\Entity\Professeur;
use App\Repository\ProfesseurRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class ProfesseurType extends AbstractType
{
    private ProfesseurRepository $professeurRepository;
      public function __construct(ProfesseurRepository $professeurRepository)
      {
        $this->professeurRepository=$professeurRepository;
      }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomComplet')
            ->add('email',EmailType::class,[ 
             ])
          //   ->add("roles",ChoiceType::class,[])
            ->add('grade',ChoiceType::class, [
                'choices'  => array_map(fn($value): array => [$value['grade']=>$value['grade']] ,$this->professeurRepository->findDistinctGrade())  ])
               // ->add('roles')
               ->add('password',PasswordType::class,[
              ]) 
            ->add('modules',EntityType::class, [
                'class' => Module::class,
                'mapped' => true,
                'label' => 'Module',
                'choice_label' => 'libelle',
                'multiple' => true,
                'expanded' => true
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
            'data_class' => Professeur::class,
        ]);
    }
}
