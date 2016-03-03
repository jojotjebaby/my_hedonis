<?php

namespace SiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SalesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('adresse')
            ->add('tel')
            ->add('website')
            ->add('lattitude')
            ->add('longitude')


            ->add('type', ChoiceType::class, array('choices' => array('Bar' => 'bar','Shop' => 'shop'),'choices_as_values' => true))
            ->add('state', ChoiceType::class, array('choices' => array(
                'Antwerpen' => 'antwerpen',
                'Brussel' => 'brussel',
                'Henegouwen' => 'henegouwen',
                'Limburg' => 'limburg',
                'Luik' => 'luik',
                'Luxemburg' => 'luxemburg',
                'Namen' => 'namen',
                'Oost-vlaanderen' => 'oost-vlaanderen',
                'Vlaams-brabant' => 'vlaams-brabant',
                'Waals-brabant' => 'waals-brabant',
                'West-vlaanderen' => 'west-vlaanderen'
            ),'choices_as_values' => true))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SiteBundle\Entity\Sales'
        ));
    }
}
