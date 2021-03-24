<?php

namespace App\Form;

use App\Entity\DetailAcceptanceOrder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DetailAcceptanceOrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantity')
            ->add('unit')
            ->add('product')
            ->add('acceptanceOrder')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DetailAcceptanceOrder::class,
        ]);
    }
}
