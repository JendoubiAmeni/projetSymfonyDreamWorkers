<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;


class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         // Get today's date
        $today = new \DateTime();

        $builder
        ->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $form = $event->getForm();
            $data = $event->getData();

            $prix = $data->getPrix();
            $nbPlace = $data->getNbPlace();

            $totalPrice = $prix * $nbPlace;

            $data->setPrixTotale($totalPrice);
        
    })

        ->add('date_res', DateType::class, [
            'widget' => 'single_text',
            'data' => new \DateTime(),
        ])
            ->add('heure_res' ,TextType::class , array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'entrer heure',
                    'class' => 'form-control'
                )
            ))
            ->add('nb_place' ,IntegerType::class , array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Enter le nombre de places',
                    'class' => 'form-control'
                )
            ))
            ->add('prix_totale',IntegerType::class , array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'prix totales',
                    'class' => 'form-control'
                )
            ))
            ->add('prix', IntegerType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'prix du ticket',
                    'class' => 'form-control'
                )
            ))
            ->add('type_ticket',TextType::class , array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'type de ticket',
                    'class' => 'form-control'
                )
            ));
            //->add('email', TextType::class)
            //->add('phone', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
