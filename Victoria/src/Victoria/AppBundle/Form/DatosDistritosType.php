<?php

namespace Victoria\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;


class DatosDistritosType extends AbstractType
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
            /*->add('idCampana', EntityType::class, array(
                'class' => 'VictoriaAppBundle:DatosCampanasPoliticas',
                'label' => 'Campaña',
            ))*/
            ->add('idCampana',EntityType::class,array(
            //'mapped' => false,    
            'class' => 'VictoriaAppBundle:DatosCampanasPoliticas',
            'label' => 'Campaña',    
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
            'data_class' => 'Victoria\AppBundle\Entity\DatosDistritos'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'victoria_appbundle_datosdistritos';
    }
}
