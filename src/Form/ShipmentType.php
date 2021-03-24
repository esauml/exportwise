<?php

namespace App\Form;

use App\Entity\Shipment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShipmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('posting_date')
            ->add('arrive_date')
            ->add('comision')
            ->add('total')
            ->add('status')
            ->add('acceptanceOrder')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Shipment::class,
        ]);
    }
}
