<?php

namespace Victoria\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DatosListaPublicidadType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipoAnuncio')
            ->add('descripcion')
            ->add('target')
            ->add('pautaPublicitaria')
            ->add('personasAlcanzadas')
            ->add('meGusta')
            ->add('meEncanta')
            ->add('meDivierte')
            ->add('meEnoja')
            ->add('meEntristece')
            ->add('comentariosPositivos')
            ->add('comentariosNegativos')
            ->add('compartidos')
            ->add('idPublicidad')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Victoria\AppBundle\Entity\DatosListaPublicidad'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'victoria_appbundle_datoslistapublicidad';
    }
}
