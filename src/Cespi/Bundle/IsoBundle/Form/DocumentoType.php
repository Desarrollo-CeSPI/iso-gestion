<?php

namespace Cespi\Bundle\IsoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Cespi\Bundle\IsoBundle\Entity\Alcances;

class DocumentoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        
      
        $builder
            ->add('nombre')
            ->add('ruta')
            ->add('revision')
            /*->add('fechaAprobado', 'date', array(
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
            ))
            ->add('fechaRevision', 'date', array(
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
            ))
            ->add('fechaCreacion', 'date', array(
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
            ))
            ->add('fechaVigencia', 'date', array(
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
            ))*/
            ->add('fechaAprobado', 'text', array())
            ->add('fechaRevision', 'text', array())
            ->add('fechaCreacion', 'text', array())
            ->add('fechaVigencia', 'text', array())
            ->add('descripcion')
            ->add('tipo',null, array('required' => true))
            ->add('estado',null, array('required' => true))
          
            ->add('editor',null,array('multiple' => true, 'expanded' => true))
            ->add('revisor',null,array('multiple' => true, 'expanded' => true))
            ->add('aprobador',null,array('multiple' => true, 'expanded' => true))
            ->add('audiencia',null,array('multiple' => true, 'expanded' => true))
            ->add('responsable',null,array('multiple' => true, 'expanded' => true))            
                
            ->add('alcances',null,array('multiple' => true, 'expanded' => true))            
                        
                ;
    }
    
   
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cespi\Bundle\IsoBundle\Entity\Documento'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cespi_bundle_isobundle_documento';
    }
}
