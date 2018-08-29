<?php

namespace Cespi\Bundle\IsoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UsuariosType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('apellido')
            ->add('nombre')
            ->add('nroDocumento')
            ->add('email')
            
            
            
            ->add('perfil', 'choice', array('choices'=> array('ROLE_USER' => 'Usuario','ROLE_ADMIN' => 'Administrador')))
            ->add('password', 'hidden')
            
            ->add('password', 'repeated', array(
                'type' => 'password',
                'invalid_message' => 'Las contraseñas deben coincidir.',
                'options' => array('always_empty' => false, 'attr' => array('class' => 'password-field')),
                'required' => false,
                'first_options'  => array('label' => 'Contraseña','attr' => array("autocomplete" => "off")),
                'second_options' => array('label' => 'Repita la contraseña','attr' => array("autocomplete" => "off")),
             ))
        
            
                
                
            ->add('alcances',null,array('multiple' => true, 'expanded' => true))            
                
             ;
        
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cespi\Bundle\IsoBundle\Entity\Usuarios'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cespi_bundle_isobundle_usuarios';
    }
}
