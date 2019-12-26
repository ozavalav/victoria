<?php

namespace Victoria\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class DatosPersonasType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $cmpId = $options['label'];
        
        if($cmpId == 0 ) {
            $strw = 'c.idCampana > ?1';
        } else {
            $strw = 'c.idCampana = ?1';
        }
        $cmpes = $options['attr']['estructura'];
        
        $builder
            ->add('nombres',null,array('label' => 'Nombres', 'attr' => array('maxlength' => 256)))
            ->add('apellidos',null,array('label' => 'Apellidos', 'attr' => array('maxlength' => 256)))
            ->add('numeroIdentidad',null,array('label' => 'NumeroIdentidad', 'attr' => array('maxlength' => 13)))
            ->add('telefono1',null,array('label' => 'Telefono1', 'attr' => array('maxlength' => 14)))
            ->add('telefono2',null,array('label' => 'Telefono2', 'attr' => array('maxlength' => 14)))
            ->add('telefono3',null,array('label' => 'Telefono3', 'attr' => array('maxlength' => 14)))
            ->add('email',null,array('label' => 'Email', 'attr' => array('maxlength' => 256)))
            //->add('idEstructura')
            ->add('idEstructura', EntityType::class, array(
                'required' => true,
                'label' => 'Estructura',
                'empty_value' => '-- Seleccione una estructura --',
                'empty_data'  => null,               
                'class' => 'VictoriaAppBundle:DatosEstructuras',
                'choice_label' => 'nombre',
            ))     
            /*->add('idCampana', EntityType::class, array(
                'class' => 'VictoriaAppBundle:DatosCampanasPoliticas',
                'label' => 'Campaña'
            ))
            ->add('idDistrito', EntityType::class, array(
                'class' => 'VictoriaAppBundle:DatosDistritos',
                'label' => 'Distrito'
            ))*/
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
            ->add('idComision',EntityType::class,array(
            //'mapped' => false,    
            'class' => 'VictoriaAppBundle:AdTiposComision',
            'label' => 'Comision',    
            'attr' => array('required' => true),
            'query_builder' => function (EntityRepository $er) use ($cmpes) {
                return $er->createQueryBuilder('c')  
                    ->where('c.idEstructura >= ?1')    
                    ->orderBy('c.descripcion')
                    ->setParameter(1,$cmpes);
                }
            ))     
            //->add('estado')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Victoria\AppBundle\Entity\DatosPersonas'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'victoria_appbundle_datospersonas';
    }
}
