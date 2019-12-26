<?php

namespace Victoria\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class DatosEquiposType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre',null,array('label' => 'Nombre', 'attr' => array('maxlength' => 64)))
            ->add('marca',null,array('label' => 'Marca', 'attr' => array('maxlength' => 64)))
            ->add('modelo',null,array('label' => 'Modelo', 'attr' => array('maxlength' => 64)))
            ->add('numeroSerie',null,array('label' => 'Numero de serie', 'attr' => array('maxlength' => 64)))
            ->add('descripcion', TextareaType::class, array(
                'label' => 'Descripción',
                'attr' => array(
                    'placeholder' => 'Descripción del equipo',
                    'maxlength' => 128,
                    'rows' => 2)
            ))
            ->add('cantidad',null,array('label' => 'Cantidad'))
            ->add('responsable',null,array('label' => 'Responsable', 'attr' => array('maxlength' => 128)))
            ->add('ubicacion',null,array('label' => 'Ubicacion', 'attr' => array('maxlength' => 128)))
            ->add('estado', ChoiceType::Class, array(
                'choices' => array(
                    'Bueno' => 1, 
                    'Regular' => 2,
                    'Malo' => 3 
                ),
                'label' => 'Estado',
                'choices_as_values' => true,
                'required' => true,
                'attr' => array('required' => true),
            ))
            ->add('idCampana',null,array('label' => 'Campaña:', 'attr'=>array('required' => true)))    
            ->add('idCategoria',null,array('label' => 'Categoria:', 'attr'=>array('required' => true)))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Victoria\AppBundle\Entity\DatosEquipos'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'victoria_appbundle_datosequipos';
    }
}
