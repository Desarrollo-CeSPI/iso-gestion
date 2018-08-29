<?php

namespace Cespi\Bundle\IsoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\CallbackTransformer;


class RegistroControlCambiosType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idRegistro', 'hidden')
                            
                
            ->add('revision')
          /*  ->add('fecha', 'date', array(
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy' 	))  */         
                
            ->add('fecha', 'date', array(
               'widget' => 'single_text',

               // do not render as type="date", to avoid HTML5 date pickers
              // 'html5' => false,

               // add a class that can be selected in JavaScript
               'attr' => ['class' => 'js-datepicker', 'placeholder' => 'Formato: YYYY-MM-DD'],
                ))
            ->add('motivo')
            ->add('user', 'hidden')
            ->add('updatedAt', 'hidden')
            ->add('link')
                        
                
                
                

        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
           
            'data_class' => 'Cespi\Bundle\IsoBundle\Entity\RegistroControlCambios'
            
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cespi_bundle_isobundle_registrocontrolcambios';
    }
}
