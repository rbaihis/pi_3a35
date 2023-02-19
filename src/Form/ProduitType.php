<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;



class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description', TextType::class, [
                'label' => 'Nom du produit',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le description du produit ne peut pas être vide',
                    ]),
                ],
            ])
            ->add('prix', IntegerType::class, [
                'label' => 'Prix',
                'constraints' => [
                    new NotBlank([
                        'message' => 'price cannot be blank',
                    ]),
                    new Range([
                        'min' => 0.0,
                        'max' => 100000000.000000000,
                        'notInRangeMessage' => 'price must be between {{ min }} and {{ max }}',
                    ]),
                ],
            ])
            ->add('categorie_produit')
            ->add('image_produit', FileType::class, [
                'label' => 'Image Produit',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new \Symfony\Component\Validator\Constraints\Image([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid JPG/PNG document',
                    ])
                ],
                 ])
            ->add('nom_produit', TextType::class, [
                'label' => 'Nom du produit',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le nom du produit ne peut pas être vide',
                    ]),
                    new Length([
                        'min' => 3,
                        'max' => 40,
                        'minMessage' => 'Le nom du produit doit comporter au moins {{ limit }} caractères',
                        'maxMessage' => 'Le nom du produit ne doit pas comporter plus de {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('marque', TextType::class, [
                'label' => 'Marque',
                'constraints' => [
                    new NotBlank([
                        'message' => 'La marque  du produit ne peut pas être vide',
                    ]),
                    new Length([
                        'min' => 4,
                        'max' => 20,
                        'minMessage' => 'La marque du produit doit comporter au moins {{ limit }} caractères',
                        'maxMessage' => 'La marquedu produit ne doit pas comporter plus de {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('quantite_produit', IntegerType::class, [
                'label' => 'Age',
                'constraints' => [
                    new NotBlank([
                        'message' => 'the quantity cannot be blank',
                    ]),
                    new Range([
                        'min' => 1,
                        'max' => 1000,
                        'notInRangeMessage' => 'the quantity must be between {{ min }} and {{ max }}',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
