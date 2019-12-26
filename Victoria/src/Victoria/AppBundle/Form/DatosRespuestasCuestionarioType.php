<?php

namespace Victoria\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class DatosRespuestasCuestionarioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombres')
            ->add('edad')
            ->add('direccion')
            ->add('porquePartidoEsSuAfinidad',ChoiceType::class, array(
                'choice_list' => new ChoiceList(
                array(1, 2, 3),
                array('Partido nacional', 'partido anti-corrupción', 'partido liberal')
                ), 
                'expanded' => true,
            ))


            ->add('porquePartidoVotara',ChoiceType::class, array(
                'choice_list' => new ChoiceList(
                array(1, 2, 3),
                array('Partido nacional', 'partido anti-corrupción', 'partido liberal')
                ), 
                'expanded' => true,
            ))
            ->add('porQuienVotaraParaPresidente',ChoiceType::class, array(
                'choice_list' => new ChoiceList(
                array(1, 2, 3),
                array('Juan Hernandez', 'Salvador Nasralla', 'Luiz Zelaya')
                ), 



                'expanded' => true,
            ))
            ->add('porQuienVotaraComoAlcalde',ChoiceType::class, array(
                'choice_list' => new ChoiceList(
                array(1, 2, 3),
                array('Nasry Asfura', 'Ricardo Álvarez', 'Miguel Rodrigo Pastor')
                ), 
                'expanded' => true,




            ))
            ->add('queBeneficioLeGustariaRecibirDelGobierno',ChoiceType::class, array(
                'choice_list' => new ChoiceList(
                array(1, 2, 3),
                array('Ecofogon', 'Agua', 'Luz')
                ), 
                'expanded' => true,
            ))     
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Victoria\AppBundle\Entity\DatosRespuestasCuestionario'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'victoria_appbundle_datosrespuestascuestionario';
    }
}
