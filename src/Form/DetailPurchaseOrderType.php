<?php

namespace App\Form;

use App\Entity\DetailPurchaseOrder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
class DetailPurchaseOrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantity', IntegerType::class,['data' => 1])
            ->add('unit');
           /*  ->add('product') */
          /*   ->add('purchaseOrder');  */
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DetailPurchaseOrder::class,
        ]);
    }
}
