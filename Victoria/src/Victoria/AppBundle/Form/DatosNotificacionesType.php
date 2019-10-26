<?php

namespace Victoria\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class DatosNotificacionesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $cmpId = $options['attr']['campana'];
        
        if($cmpId == 0 ) {
            $strw = 'c.idCampana > ?1';
        } else {
            $strw = 'c.idCampana = ?1';
        }
        
        $builder
            ->add('mensaje', TextareaType::class, array( 'attr' => array('rows' => 4, 'cols' => '10')))
            //->add('estado')
            //->add('fechaEnviado')
            //->add('fechaRecibido')
            //->add('idUsuario')
            //->add('idCampana',null, array('label' => 'Campaña', 'attr' => array('required' => true), ))
            //->add('idDistrito',null, array('label' => 'Distrito', 'attr' => array('required' => true), ))
            ->add('idCampana',EntityType::class,array(
            //'mapped' => false,    
            'class' => 'VictoriaAppBundle:DatosCampanasPoliticas',
            'choices_as_values' => true,    
            'label' => 'Campaña',    
            'required' => true,
            'query_builder' => function (EntityRepository $er) use ($cmpId, $strw) {
                return $er->createQueryBuilder('c')
                    ->where($strw)    
                    ->orderBy('c.nombre')
                    ->setParameter(1,$cmpId);
                }
            ))
            ->add('idDistrito',EntityType::class,array(
            //'mapped' => false,    
            'class' => 'VictoriaAppBundle:DatosDistritos',
            'choices_as_values' => true,    
            'label' => 'Distritos',    
            'required' => true,
            'query_builder' => function (EntityRepository $er) use ($cmpId, $strw) {
                return $er->createQueryBuilder('c')
                    ->where($strw)    
                    ->orderBy('c.nombre')
                    ->setParameter(1,$cmpId);
                }
            ))    
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Victoria\AppBundle\Entity\DatosNotificaciones'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'victoria_appbundle_datosnotificaciones';
    }
}
