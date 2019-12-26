<?php

namespace Victoria\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class DatosComisionesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descripcion')
            ->add('idEstructura', EntityType::class, array(
                'class' => 'VictoriaAppBundle:DatosEstructuras',
                'label' => 'Estructura', 'attr'=>array('required' => true)))
                
            ->add('idPersona', EntityType::class, array(
                'class' => 'VictoriaAppBundle:DatosPersonas',
                'label' => 'Personas', 'attr'=>array('required' => true)))
                
            ->add('idTipoComision', EntityType::class, array(
                'class' => 'VictoriaAppBundle:AdTiposComision',
                'label' => 'Tipo comision', 'attr'=>array('required' => true)))
                
            ->add('idCampana', EntityType::class, array(
                'class' => 'VictoriaAppBundle:DatosCampanasPoliticas',
                'label' => 'Campaña politica', 'attr'=>array('required' => true)))
                
            ->add('idDistrito', EntityType::class, array(
                'class' => 'VictoriaAppBundle:DatosDistritos',
                'label' => 'Distrito', 'attr'=>array('required' => true)))
                
            ->add('idCv', EntityType::class, array(
                'class' => 'VictoriaAppBundle:DatosCentrosVotacion',
                'label' => 'Centro de Votación', 'attr'=>array('required' => true)))

        ;

    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Victoria\AppBundle\Entity\DatosComisiones'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'victoria_appbundle_datoscomisiones';
    }
}
