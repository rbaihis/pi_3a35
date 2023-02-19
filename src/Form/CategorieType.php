<?php

namespace App\Form;

use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_categorie', TextType::class, [
                'label' => 'Categorie',
                'constraints' => [
                    new NotBlank([
                        'message' => 'La Categorie ne peut pas être vide',
                    ]),
                    new Length([
                        'min' => 4,
                        'max' => 20,
                        'minMessage' => 'La Categorie doit comporter au moins {{ limit }} caractères',
                        'maxMessage' => 'La Categorie ne doit pas comporter plus de {{ limit }} caractères',
                    ]),
                ],
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Categorie::class,
        ]);
    }
}
