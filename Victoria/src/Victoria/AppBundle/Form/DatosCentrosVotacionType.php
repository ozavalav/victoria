<?php

namespace Victoria\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class DatosCentrosVotacionType extends AbstractType
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
        
        $builder
            ->add('nombre')
            ->add('tipoCv')
            ->add('tipoCv',ChoiceType::class, array(
                'choice_list' => new ChoiceList(
                array(1, 2, 3),
                array('A', 'B', 'C')
                ), 
                'expanded' => true,
            ))    
            ->add('direccion',null,array('label' => 'Dirección'))
            ->add('nombreEdificio')
            ->add('cargarElectoral')
            ->add('numeroMesas')
            /*->add('idCampana', EntityType::class, array(
                'class' => 'VictoriaAppBundle:DatosCampanasPoliticas',
                'label' => 'Campaña'
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
            /*->add('idDistrito', EntityType::class, array(
                'class' => 'VictoriaAppBundle:DatosDistritos',
                'label' => 'Distrito'
            ))*/
            /*->add('idDistrito', ChoiceType::class, array(
                      'mapped' => false,
                      'choices' => array('-- Seleccione --' => null),
                      'label' => 'Distrito',
                      'required' => true,
                      'choices_as_values' => true,
                    )) */   
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Victoria\AppBundle\Entity\DatosCentrosVotacion'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'victoria_appbundle_datoscentrosvotacion';
    }
}
