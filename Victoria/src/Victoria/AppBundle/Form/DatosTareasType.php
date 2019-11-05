<?php

namespace Victoria\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DatosTareasType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo',null,array('label'=>'Titulo'))
            ->add('descripcion',null,array('label'=>'Descripcion'))
            ->add('fechaCreacion')
            ->add('usuarioCreacion')
            ->add('usuarioUltimaModificacion')
            ->add('fechaUltimaModificacion')
            ->add('idEstado',null,array('label'=>'Estado')) 
            ->add('idEventos',null,array('label'=>'Evento'))
            ->add('idResponsable',null,array('label'=>'Responsable'))
            ->add('progreso',null,array('label'=>'Progreso'))


        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Victoria\AppBundle\Entity\DatosTareas'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'victoria_appbundle_datostareas';
    }
}
