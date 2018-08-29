<?php

namespace Cespi\Bundle\IsoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistroType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('descripcion')
            /*->add('fechaUltimaActualizacion', 'date', array(
                	'widget' => 'single_text',
                	'format' => 'dd/MM/yyyy',
            ))*/
            ->add('fechaUltimaActualizacion', 'text', array('attr' => array(
                 'placeholder' => 'dd/mm/yyyy'
             )))

            ->add('revisionActual')
            ->add('alcances',null,array('multiple' => true, 'expanded' => true))            
            ->add('alcancesEditor',null,array('multiple' => true, 'expanded' => true))                            
            
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cespi\Bundle\IsoBundle\Entity\Registro'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cespi_bundle_isobundle_registro';
    }
}
