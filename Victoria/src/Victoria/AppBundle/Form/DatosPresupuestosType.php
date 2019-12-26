<?php

namespace Victoria\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

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
            //->add('idActividadEgreso')
            ->add('fuenteEgreso',ChoiceType::class, array(
                'choice_list' => new ChoiceList(
                array(1, 2, 3),
                array('Propios', 'Donación', 'Otro')
                ), 'expanded' => true
            ))
            ->add('descripcion',null,array('label' => 'Descripción', 'attr' => array('maxlength'=> 256)))
            ->add('lugarEvento',null,array('label' => 'Lugar', 'attr' => array('maxlength'=> 256)))
            ->add('objetivoEvento', TextareaType::class, array( 'attr' => array('maxlength'=> 510, 'rows' => 2, 'cols' => '10')))
            //->add('fechaEvento')
            //->add('preparadoPor')
            //->add('aprobadoPor')
            //->add('estado')
            //->add('totalPresupuestoEstimado')
            //->add('totalPresupuestoEjecutado')
            ->add('idCampana',null,array('label'=>'Campaña', 'attr'=>array('required' => true)))
            ->add('idDistrito',null,array('label' => 'Distrito', 'attr'=>array('required' => true)))
            ->add('idCv',null,array('label' => 'Centro Votación', 'attr'=>array('required' => true)))  

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
