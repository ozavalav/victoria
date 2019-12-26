<?php

namespace Victoria\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType;

class DatosEventosType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
            ->add('titulo',null,array('label' => 'Titulo', 'attr' => array('maxlength' => 256)))
            ->add('descripcion',null,array('label' => 'Descripcion', 'attr' => array('maxlength' => 256)))
            ->add('fechaInicio',TextType::class,array('label'=>'Fecha inicio'))                
            ->add('fechaFinal',TextType::class,array('label'=>'Fecha final'))
            ->add('usuarioCreacion')
            ->add('fechaCreacion')
            ->add('usuarioUltimaModificacion')
            ->add('fechaUltimaModificacion')
            ->add('idCampana',null,array('label' => 'Campaña:', 'attr'=>array('required' => true)))    
            ->add('idDistrito',null,array('label' => 'Distrito:', 'attr'=>array('required' => true)))

        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Victoria\AppBundle\Entity\DatosEventos'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'victoria_appbundle_datoseventos';
    }
}
