<?php

namespace App\Form;

use App\Entity\PollResponse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;

class PollResponseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextType::class, [
                'required'       => false,
                'constraints' => [
                    new Length([
                        'min' => 2, 'minMessage' => 'Veuillez reformuler cette réponse , minimum 2 caractère, ou supprimer ce champ',
                        'max' => 50, 'maxMessage' => 'Veuillez reformuler cette réponse , maximum 50 caractère, ou supprimer ce champ'
                    ]),
                    // new NotBlank([
                    //     'message' => 'Ce champ ne peut pas étres vide'
                    // ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PollResponse::class,
        ]);
    }
}
