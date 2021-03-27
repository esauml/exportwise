<?php

namespace App\Form;

use App\Entity\Enterprise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class EnterpriseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('companyName', null, ['required' => true])
            ->add('country', ChoiceType::class, [
                'required' => true,
                'choices' => [
                    'France' => 'France',
                    'Mexique' => 'Mexique',
                    'UK' => 'UK',
                    'Russie' => 'Russia',
                    'Japon' => 'Japan',
                    'Finlande' => 'Finlande',
                    'Philippines' => 'Philippines',
                ],
            ])
            ->add('phone', null, ['required' => true])
            ->add('contactName', null, ['required' => true]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Enterprise::class,
            'translation_domain' =>'forms'
        ]);
    }
}
