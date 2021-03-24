<?php

namespace App\Form;

use App\Entity\AcceptanceOrder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AcceptanceOrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('subtotal')
            ->add('expected_arrive_date')
            ->add('date_done')
            ->add('status')
            ->add('seller')
            ->add('buyer')
            ->add('purchaseOrder')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AcceptanceOrder::class,
        ]);
    }
}
