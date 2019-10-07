<?php

namespace Victoria\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class DatosPresupuestosType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipoEgreso', EntityType::class, array(
                'class' => 'VictoriaAppBundle:AdTipoEgresos',
                'label' => 'Tipo Egreso'
            ))
            ->add('idActividadEgreso')
            ->add('fuenteEgreso',ChoiceType::class, array(
                'choice_list' => new ChoiceList(
                array(1, 2, 3),
                array('Propios', 'Donación', 'Otro')
                ), 'expanded' => true
            ))
            ->add('descripcion',null,array('label' => 'Descripción'))
            //->add('preparadoPor')
            //->add('aprobadoPor')
            //->add('estado')
            //->add('totalPresupuestoEstimado')
            //->add('totalPresupuestoEjecutado')
            ->add('idCampana',null,array('label'=>'Campaña'))
            ->add('idDistrito',null,array('label' => 'Distrito'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Victoria\AppBundle\Entity\DatosPresupuestos'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'victoria_appbundle_datospresupuestos';
    }
}
