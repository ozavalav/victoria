<?php

namespace Victoria\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class AdUserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombreUsuario',null, array('label' => 'Nombre y Apellido', 'attr' => array('maxlength' => 128, 'placeholder' => 'Nombre completo')))
            ->add('username',null, array('label' => 'Usuario', 'attr' => array('maxlength' => 25, 'placeholder' => 'Nombre de la cuenta')) )
            ->add('password', RepeatedType::class, 
                    array('type' => PasswordType::class,
                          'label' => 'Contraseña',
                          'attr' => array('maxlength' => 128, 'placeholder' => 'Clave de acceso'),
                          'invalid_message' => 'Claves tienen que ser iguales',
                          'required' => false,
                          'first_options' => array('label' => 'Contraseña'),
                          'second_options' => array('label' => 'Repetir Contraseña'),
                        ))
            //->add('salt')
            //->add('idEstado')
            //add('idMunicipio')
            //->add('idComunidad')
            //->add('isActive')
            ->add('email',null, array('label'=>'Correo', 'required' => true, 'attr' => array('maxlength' => 128, 'placeholder' => 'Correo electrónico del usuario')))
            //->add('fechaCreacion')
            //->add('usuarioCreacion')
            //->add('usuarioUltimaModificacion')
            //->add('fechaUltimaModificacion')
            /*->add('codDepartamento', EntityType::class, array(
                'required' => false,
                'label' => 'Departamento',
                'empty_value' => '-- Seleccione departamento --',
                'empty_data'  => null,               
                'class' => 'VictoriaAppBundle:AdDepartamentos',
                'choice_label' => 'nombre',
            ))*/
            ->add('idEstructura', EntityType::class, array(
                'required' => true,
                'label' => 'Estructura',
                'empty_value' => '-- Seleccione una estructura --',
                'empty_data'  => null,               
                'class' => 'VictoriaAppBundle:DatosEstructuras',
                'choice_label' => 'nombre',
            ))
            ->add('idCampana', EntityType::class, array(
                'required' => true,
                'label' => 'Campaña Politica',
                'empty_value' => '-- Seleccione una campaña --',
                'empty_data'  => null,               
                'class' => 'VictoriaAppBundle:DatosCampanasPoliticas',
                'choice_label' => 'nombre',
            ))     
            ->add('acceso', EntityType::class, array(
                'required' => true,
                'label' => 'Acceso',
                'empty_value' => '-- Seleccione acceso --',
                'empty_data'  => null,               
                'class' => 'VictoriaAppBundle:AdRoles',
                'choice_label' => 'rol',
            ))    
            ->add('user_roles',null,array('attr' => array('required' => true), 'label'=>'Rol de usuario'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Victoria\AppBundle\Entity\AdUser'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'focal_appbundle_aduser';
    }
}
