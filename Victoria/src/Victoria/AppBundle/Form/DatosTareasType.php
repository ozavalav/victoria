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
            ->add('titulo',null,array('label'=>'Titulo', 'attr'=>array('required' => true, 'maxlength'=> 50)))
            ->add('descripcion',null,array('label'=>'Descripcion', 'attr'=>array('required' => true, 'maxlength'=> 256)))
            ->add('fechaCreacion')
            ->add('usuarioCreacion')
            ->add('usuarioUltimaModificacion')
            ->add('fechaUltimaModificacion')
            ->add('idEstado',null,array('label' => 'Estado:', 'attr'=>array('required' => true)))
            ->add('idEventos',null,array('label' => 'Eventos:', 'attr'=>array('required' => true)))
            ->add('idResponsable',null,array('label' => 'Responsable:', 'attr'=>array('required' => true)))
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
