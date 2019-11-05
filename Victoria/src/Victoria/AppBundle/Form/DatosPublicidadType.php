<?php

namespace Victoria\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DatosPublicidadType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipoPublicidad',null,array('label' => 'Tipo Publicidad'))
            ->add('descripcion')
            ->add('preparadoPor')
            ->add('aprobadoPor')
            ->add('estado')
            ->add('nombreMedioPublicidad')
            ->add('tipoAnuncio')
            ->add('comprobantePago')
            ->add('target')
            ->add('pautaPublicitaria')
            ->add('personasAlcanzadas')
            ->add('meGusta',null,array('label' => ' '))
            ->add('meEncanta',null,array('label' => ' '))
            ->add('meDivierte',null,array('label' => ' '))
            ->add('meEnoja',null,array('label' => ' '))
            ->add('meEnoja',null,array('label' => ' '))
            ->add('meEntristece',null,array('label' => ' '))
            ->add('meAsombra',null,array('label' => ' '))
            ->add('comentariosPositivos')
            ->add('comentariosNegativos')
            ->add('compartidos')
            ->add('fechaCreacion')
            ->add('usuarioCreacion')
            ->add('usuarioUltimaModificacion')
            ->add('fechaUltimaModificacion')
            ->add('idCampana')
            ->add('idDistrito')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Victoria\AppBundle\Entity\DatosPublicidad'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'victoria_appbundle_datospublicidad';
    }
}
