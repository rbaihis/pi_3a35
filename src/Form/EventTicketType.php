<?php

namespace App\Form;

use App\Entity\EventTicket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventTicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('matricule_event')
            ->add('image')
            ->add('date_ticket')
            ->add('valide_ticket')
            ->add('prix_ticket')
            ->add('description_ticket')
            ->add('adresse')
            ->add('reserve')
            ->add('userID')
            ->add('eventID')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EventTicket::class,
        ]);
    }
}
