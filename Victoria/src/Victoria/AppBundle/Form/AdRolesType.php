<?php

namespace Victoria\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AdRolesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rol')
            ->add('idEstado',ChoiceType::class,
                    array('choices' => array('Activo' => 1, 'Inactivo' => 2), 
                    'empty_data' => 1, 
                    'multiple'=>false, 
                    'expanded'=>false, 
                    'placeholder' => false, 
                    'required' => true, 
                    'label' => 'Estado', 
                    'choices_as_values' => true,))
            //->add('fechaCreacion')
            //->add('usuarioCreacion')
            //->add('usuarioUltimaModificacion')
            //->add('fechaUltimaModificacion')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Victoria\AppBundle\Entity\AdRoles'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'focal_appbundle_adroles';
    }
}
