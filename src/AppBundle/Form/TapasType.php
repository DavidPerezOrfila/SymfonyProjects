<?php

namespace AppBundle\Form;

use AppBundle\Entity\tapas;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TapasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nazwa', TextType::class)
            ->add('opis', TextType::class)
            ->add('cena', MoneyType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'=> tapas::class
        ]);
    }

    public function getName()
    {
        return 'app_bundle_tapas_type';
    }
}
