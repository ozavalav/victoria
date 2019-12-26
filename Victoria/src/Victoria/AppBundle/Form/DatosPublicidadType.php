<?php

namespace Victoria\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class DatosPublicidadType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipoPublicidad',null,array('required' => true, 'label' => 'Tipo Publicidad'))
            ->add('descripcion',null,array('required' => true, 'label' => 'Descripción'))
            ->add('preparadoPor')
            ->add('aprobadoPor')
            ->add('estado')
            ->add('nombreMedioPublicidad')
            ->add('tipoAnuncio')
            ->add('comprobantePago', FileType::class, [
                'label' => 'Comprobante Pago',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // everytime you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes

            ])
            ->add('target')
            ->add('pautaPublicitaria')
            ->add('personasAlcanzadas')
            ->add('meGusta',null,array('label' => ' '))
            ->add('meEncanta',null,array('label' => ' '))
            ->add('meDivierte',null,array('label' => ' '))
            ->add('meEnoja',null,array('label' => ' '))
            ->add('meEnoja',null,array('label' => ' '))
            ->add('meEntristece',null,array('label' => ' '))
            ->add('meAsombra',null,array('label' => ' '))
            ->add('comentariosPositivos')
            ->add('comentariosNegativos')
            ->add('twitAfavor',null,array('label' => 'Twit a favor'))
            ->add('twitNoafavor',null,array('label' => 'Twit no a favor'))
            ->add('reTwit',null,array('label' => 'ReTwit'))
            ->add('compartidos')
            ->add('fechaCreacion')
            ->add('usuarioCreacion')
            ->add('usuarioUltimaModificacion')
            ->add('fechaUltimaModificacion')                
            ->add('idCampana',null,array('label' => 'Campaña:', 'attr'=>array('required' => true)))    
            ->add('idDistrito',null,array('label' => 'Distrito:', 'attr'=>array('required' => true)))
        ;
    }
    
    
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Victoria\AppBundle\Entity\DatosPublicidad'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'victoria_appbundle_datospublicidad';
    }
    
    
    
}
