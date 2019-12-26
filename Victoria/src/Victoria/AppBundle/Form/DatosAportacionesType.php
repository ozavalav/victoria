<?php

namespace Victoria\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class DatosAportacionesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre',null,array(
                'required' => true,
                'attr' => array(
                    'placeholder' => 'Ingrese nombre del donante', 
                    'maxlength' => 250)
            ))
            ->add('tipoAportador', ChoiceType::Class, array(
                'choices' => array(
                    'Persona' => 1, 
                    'Institución' => 2 
                ),
                'label' => 'Tipo Aportador',
                'choices_as_values' => true,
                'expanded' => true,
                'multiple' => false,
                'required' => true,
                'attr' => array('class' => 'radio-inline'),
            ))
            ->add('tipoAportacion', ChoiceType::Class, array(
                'choices' => array(
                    'Economica' => 1, 
                    'En especies' => 2 
                ),
                'label' => 'Tipo Aportación',
                'choices_as_values' => true,
                'expanded' => true,
                'multiple' => false,
                'required' => true,
                'attr' => array('class' => 'radio-inline'),
            ))
            ->add('descripcion', TextareaType::class, array(
                'label' => 'Descripción',
                'attr' => array(
                    'placeholder' => 'Descripción de la donación',
                    'maxlength' => 500,
                    'rows' => 2)
            ))
            ->add('valorAportacion',null,array(
                'required' => true, 
                'label' => 'Valor',
                'attr' => array('placeholder' => 'Ingrese valor de la donación'),
            ))
            ->add('telefono',null,array(
                'required' => true, 
                'label' => 'Teléfono',
                'attr' => array('placeholder' => 'Ingrese un número teléfonico'),
            ))
            ->add('email',null,array(
                'label' => 'Email',
                'attr' => array('placeholder' => 'Ingrese correo valido'),
            ))
            ->add('compromiso', TextareaType::class, array(
                'label' => 'Compromiso',
                'attr' => array(
                    'maxlength' => 500, 
                    'rows' => 2,
                    'placeholder' => 'Ingrese el compromiso adquirido con el donante',
                )
            ))
            ->add('aportadorActual', ChoiceType::Class, array(
                'choices' => array(
                    'Actual' => 1, 
                    'Futuro' => 2 
                ),
                'label' => 'Aportante',
                'choices_as_values' => true,
                'expanded' => true,
                'multiple' => false,
                'required' => true,
                'attr' => array('class' => 'radio-inline'),
            ))
            ->add('idCampana', EntityType::class, array(
                'class' => 'VictoriaAppBundle:DatosCampanasPoliticas',
                'label' => 'Campaña politica', 'attr'=>array('required' => true)))
                        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Victoria\AppBundle\Entity\DatosAportaciones'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'victoria_appbundle_datosaportaciones';
    }
}
