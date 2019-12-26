<?php

namespace Victoria\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class DatosVotantesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombres')
            ->add('apellidos')
            ->add('numeroIdentidad',null,array('label'=>'Número identidad','attr' => array('required'=>'true', 'pattern' => '[0-9]{13}')))
            ->add('edad',null,array('attr' => array('required'=>true, 'pattern'=> '[0-9]{18,150}', 'title' => 'Ingrese un numero igual o mayor a 18')))
            ->add('sexo',ChoiceType::class, array(
                'choice_list' => new ChoiceList(
                array(1, 2),
                array('Masculino', 'Femenino')
                ), 
                'expanded' => true,
                'label' => 'Sexo',
            ))
            ->add('telefonos')
            ->add('email')
            ->add('idCv',null,array('label' => 'cv:', 'required'=>true))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Victoria\AppBundle\Entity\DatosVotantes'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'victoria_appbundle_datosvotantes';
    }
}
