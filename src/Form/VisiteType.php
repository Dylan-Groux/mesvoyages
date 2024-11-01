<?php

namespace App\Form;

use App\Entity\Visite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use \DateTime;


class VisiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ville')
            ->add('pays')
            ->add('datecreation', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date',
                'data' => isset($option['data']) &&
                    $option['data']->getDateCreation() != null ? $option['data']->getDateCreation() : new DateTime ('now'),
            ])
            ->add('note')
            ->add('avis')
            ->add('tempmin', null, [
                'label' => 'Température maximum'
            ])
            ->add('tempmax', null, [
                'label' => 'Température minimum'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Visite::class,
        ]);
    }
}
