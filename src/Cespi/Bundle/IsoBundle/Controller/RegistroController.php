<?php

namespace Cespi\Bundle\IsoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Cespi\Bundle\IsoBundle\Entity\Registro;
use Cespi\Bundle\IsoBundle\Entity\RegistroCargado;
use Cespi\Bundle\IsoBundle\Entity\RegistroCargadoDato;
use Cespi\Bundle\IsoBundle\Entity\RegistroDato;
use Cespi\Bundle\IsoBundle\Entity\RegistroCampos;
use Cespi\Bundle\IsoBundle\Form\RegistroType;
use Cespi\Bundle\IsoBundle\Entity\Usuarios;
use Symfony\Component\Security\Core\User\User;


/**
 * Registro controller.
 *
 */
class RegistroController extends Controller
{
    
    private function verificarPermisos($em, $registro){
        
       
        
        if (!$this->get('security.context')->isGranted('ROLE_ADMIN')){
        

            $alcances = $this->getUser()->getAlcances();
            $ids = array();
            foreach ($alcances as $alcance) :
                $ids[] = $alcance->getId();
            endforeach;

            $alcancesReg = $em->getRepository('CespiIsoBundle:RegistroAlcanceEditor')->findBy(array ('idRegistro' => $registro->getId(),
                'idAlcance' =>  $ids
            ));


            if (!$alcancesReg){
                 return false;
            }

            return true;
       } else {
            
            return true;
       }
     
        
        
    }
    
    private function getEntitiesByAlcance($em) {
            
        $ids = array();
        
        $alcances = $this->getUser()->getAlcances();
        foreach ($alcances as $alcance) :
            $ids[] = $alcance->getId();
        endforeach;
        
        $entities = $em->getRepository('CespiIsoBundle:RegistroAlcance')->findByIdAlcance($ids);
        
        $idReg = array();
        foreach ($entities as $registro_alcance) :
            $idReg[] = $registro_alcance->getIdRegistro();
        endforeach;
        
                
       //$entities = $em->getRepository('CespiIsoBundle:Registro')->findAll();
        $entities = $em->getRepository('CespiIsoBundle:Registro')->findById($idReg);
        
        return $entities;
    }

     private function getRegistro(Request $request)
    {
          $id = $request->get('id');
          $em = $this->getDoctrine()->getManager();
          $entity = $em->getRepository('CespiIsoBundle:Registro')->find($id);
          
          if (!$entity) {
            throw $this->createNotFoundException('No se encuentra el registro.');
        }else {
                return $entity;
                        
           }
    }
  
    
    private function getRegistroCargado(Request $request)
    {
          $id = $request->get('id');
          $em = $this->getDoctrine()->getManager();
          $entity = $em->getRepository('CespiIsoBundle:RegistroCargado')->find($id);
          
          if (!$entity) {
            throw $this->createNotFoundException('No se encuentra el registro cargado.');
        }else {
                return $entity;
                        
           }
    }  
    
    private function createFormCarga (Registro $registro)
    {

        $defaultData = array('message' => 'Type your message here');
        $em = $this->getDoctrine()->getManager();
        
        $campos = $em->getRepository('CespiIsoBundle:RegistroCampos')->findByIdRegistro($registro, array ('orden'=> 'ASC'));

        if (!$campos) {
            throw $this->createNotFoundException('El registro no tiene campos definidos.');
        }
        
        
         
        // Traigo solo los usuarios asociados a los alcances del registro.
        $alcances = $em->getRepository('CespiIsoBundle:RegistroAlcance')->findByIdRegistro($registro);
        $ids_alcances = array();
        foreach ($alcances as $alcance) :
            $ids_alcances[] = $alcance->getIdAlcance();
        endforeach;

        $users = $em->getRepository('CespiIsoBundle:Usuarios')->findAllByAlcances($ids_alcances);
        
        //$users = $em->getRepository('CespiIsoBundle:Usuarios')->findAll();

        $campos_date = array();
        $usuarios = array();
        foreach ($users as $user) {
            $usuarios[$user->getId()] = $user->getNombreCompleto();
        }

        $form = $this->createFormBuilder($defaultData);

        foreach ($campos as $campo) {
            $datos_widget = $campo->getIdTipoCampo()->getWidget($usuarios);
            //$form->add($campo->getNombreWidget(),$datos_widget[0], array_merge($datos_widget[1], array ('label' =>  $campo->getNombre())));     

            
            switch ($campo->getIdTipoCampo()) {
                case 'Fecha':
                     //$campos_date[]= 'form_'.$campo->getNombreWidget();
                    $campos_date[] = 'form_' . $campo->getId();
                    $form->add($campo->getId(), $datos_widget[0], array_merge($datos_widget[1], array('label' => $campo->getNombre())));
                    $form->add($campo->getId() . "control", 'checkbox', array(
                        //'data' => $campo->getControlEnvioEmail(),
                        'required' => false,
                        'label' => '¿Desea que se controle esta fecha para avisar a los usuarios?'
                    ));
                break;
                case 'Tabulado':
                    $valores = array();
                    $nombre= $campo->getNombre();
                    $opciones = substr($nombre, strpos($nombre,'(')+1,  strpos($nombre,')')- strpos($nombre,'(') - 1);
                    $valores = explode(',', $opciones);  
                    $nombre = substr($nombre, 0, strpos($nombre,'('));
                    $form->add($campo->getId(), $datos_widget[0], array_merge(array('choices' => $valores), array('multiple' => true, 'empty_value' => 'Elija una opción',  'invalid_message' => 'Tipo de dato inválido','label' => $nombre)));
                break;
            
                case 'Tipo':  
                case 'Estado':
                    //Los tipos agregados en la tabla tipo_campo_valor que van a ser mostrados como campo select
                    $pasar_a_valores = array();
                    $valores = $em->getRepository('CespiIsoBundle:TipoCampoValor')->findByTipoCampoId($campo->getIdTipoCampo());
                    foreach ($valores as $v) { 
                            $pasar_a_valores[$v->getValor()] = $v->getTexto();
                    }
                    $form->add($campo->getId(), $datos_widget[0], array_merge(array('choices' => $pasar_a_valores), array('empty_value' => 'Elija una opción',  'invalid_message' => 'Tipo de dato inválido','label' => $campo->getNombre())));
                    
                    break;
                default:
                    $form->add($campo->getId(), $datos_widget[0], array_merge($datos_widget[1], array('invalid_message' => 'Tipo de dato inválido','label' => $campo->getNombre())));
                    
            }
            
           
        }

        $form->add('Guardar', 'submit', array('label' => 'Guardar', 'attr' => array('class' => 'marg btn btn-primary btn-sm')));
        $form = $form->getForm();

        $return = array();
        $return['form'] = $form;
        $return['campos_date'] = $campos_date;
        $return['campos'] = $campos;

        return $return;
    }

    public function cargarAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $registro = $this->getRegistro($request);
        
        $puede = $this->verificarPermisos($em, $registro);
        
        if (!$puede) {
            $this->get('session')->getFlashBag()->add('error', 'No tiene los permisos para modificar el registro');
            return $this->redirect($this->generateUrl('cargar_registros'));
        }

		  $return = $this->createFormCarga ($registro);
		  $form = $return['form'];
		  $campos_date = $return['campos_date'];  
		  $campos = $return['campos'];        
	
		  $form->handleRequest($request);        
        
        if ($form->isValid()) {
            
            $data = $form->getData();
            
            // Guardo el registro cargado
            $registro_cargado = new RegistroCargado();
            $registro_cargado->setIdRegistro($registro);
            $registro_cargado->setUser($this->getUser()->getId());  
            $em->persist($registro_cargado);
            $em->flush();
            
            // Guardo los campos
            foreach ($campos as $campo){
                
             $dato_registro_cargado = new RegistroCargadoDato();
             
             if (isset($data[$campo->getId()])){
               
                $dato_campo = $data[$campo->getId()];
                              
                switch ($campo->getIdTipoCampo()) {
                    case 'Texto':
                    case 'Numero':
                     	// No hace nada, graba el dato como esta
                    break;
                    case 'Fecha' :
                                  $dato_campo = date_create_from_format('d/m/Y', $dato_campo); //sacar cuando se use tipo date
            			  $dato_campo = $dato_campo->format('Y-m-d H:i:s');
                                  $dato_registro_cargado->setControlEnvioEmail($data[$campo->getId() . 'control']);
                    break;
                    	case 'Usuarios':
                        case 'Tabulado':
                       $dato_campo = serialize($dato_campo);
							break;
                }
                    
                    
                
                $dato_registro_cargado->setIdRegistroCargado($registro_cargado);
                $dato_registro_cargado->setIdRegistroCampo($campo);
                $dato_registro_cargado->setDato($dato_campo);
              	$dato_registro_cargado->setUser($this->getUser()->getId());                
                       

                $em->persist($dato_registro_cargado);
                $em->flush();
                }
             }
            
                $this->get('session')->getFlashBag()->add('success', 'Se guardaron los cambios');
                return $this->redirect($this->generateUrl('cargar_registros'));
            
            }else{
                $this->get('session')->getFlashBag()->add('error', 'Verifique los datos ingresados');  
            }
           
        return $this->render('CespiIsoBundle:Registro:new.html.twig', array(
            'registro' => $registro,
            'form'   => $form->createView(),
            'campos_date' => $campos_date,
        ));
    }
    
     /**
     * Displays a form to edit an existing Registro entity.
     *
     */

    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CespiIsoBundle:Registro')->find($id);
        
        /* Por poner campos de fecha 'text' y no 'date' (problema con chrome)*/
        $this->convertirFechasAString($entity);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Registro entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CespiIsoBundle:Registro:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


     public function editCargadoAction(Request $request)
    {
        
        $em = $this->getDoctrine()->getManager();

        $registro_cargado = $this->getRegistroCargado($request);
        
        $registro = $registro_cargado->getIdRegistro();
        
        $puede = $this->verificarPermisos($em, $registro);
        
        if (!$puede) {
            $this->get('session')->getFlashBag()->add('error', 'No tiene los permisos para modificar el registro');
            return $this->redirect($this->generateUrl('cargar_registros'));
        }
        
        $posicion='V';
        if ($request->get('vista') == 'H') { $posicion = 'H'; }
        $url_back = $this->generateUrl('registrocargado_todos', array('id' => $registro->getId(),'posicion' => $posicion));
        
        $return = $this->createFormCarga($registro);
        $form = $return['form'];
        $campos_date = $return['campos_date'];
        $campos = $return['campos'];
        $hoy = new \Datetime();
        $form->handleRequest($request);

        if ($form->isValid()) {
            
            $data = $form->getData();
            
            // Guardo los campos
            foreach ($campos as $campo) {
                $dato_registro_cargado = new RegistroCargadoDato();
                
                if (isset($data[$campo->getId()])) {

                    $dato_campo = $data[$campo->getId()];

                    switch ($campo->getIdTipoCampo()) {
                        case 'Texto':
                        case 'Numero':
                            // No hace nada, graba el dato como esta
                            break;
                        case 'Fecha' :
                            $dato_campo = date_create_from_format('d/m/Y', $dato_campo);        //sacar cuando se use tipo date    			 
            		    $dato_campo = $dato_campo->format('Y-m-d H:i:s');
                            //$campo->setControlEnvioEmail($dato_campo['control_envio_email']);
                            $dato_registro_cargado->setControlEnvioEmail($data[$campo->getId() . 'control']);
                            break;
                        case 'Usuarios':
                        case 'Tabulado':
                            $dato_campo = serialize($dato_campo);
                            break;
                        default:
                            break;
                    }
                    
                    $dato_registro_cargado->setCreatedAt($hoy);
                    $dato_registro_cargado->setIdRegistroCargado($registro_cargado);
                    $dato_registro_cargado->setIdRegistroCampo($campo);
                    $dato_registro_cargado->setDato($dato_campo);
            
                    $dato_registro_cargado->setUser($this->getUser()->getId());

                    $em->persist($dato_registro_cargado);
                    $em->flush();
                    
                    
                    
                }
                
            }
            $this->get('session')->getFlashBag()->add('success', 'Se guardaron los cambios');
            //return $this->redirect($this->generateUrl('registrocargado_show', array('id' => $registro_cargado->getId())));
            return $this->redirect($url_back);
        } else {
            $datos = $em->getRepository('CespiIsoBundle:RegistroCargadoDato')->findByIdRegistroCargado($registro_cargado);
            $i=0;
            // cargo el registro con los datos que tenia
            foreach ($campos as $campo) {
                foreach ($datos as $indice => $dato) {

                    if ($campo == $dato->getIdRegistroCampo()) {

                        switch ($campo->getIdTipoCampo()) {
                            /*case 'Texto':
                            case 'Numero':
                                $form->get($campo->getId())->setData($dato->getDato());
                                break;*/
                            case 'Fecha' :

                                $fecha = date_create_from_format('Y-m-d H:i:s', $dato->getDato());
                                $fecha = $fecha->format('d/m/Y'); // sacar cuando se use tipo date
                                $form->get($campo->getId())->setData($fecha);
                                $form->get($campo->getId() . "control")->setData(($dato->getControlEnvioEmail()) ? true : false);
                                break;
                            case 'Usuarios':
                            case 'Tabulado':
                               
                                /*$dato_campo = unserialize($dato->getDato());
                                $form->get($campo->getId())->setData($dato_campo);*/
                                
                                // si no es un array lo convierto en un array, esto es porque se modificó 
                                // la aplicación para que este tipo de campos permita selección múltiple.

                                $unserializado = @unserialize($dato->getDato());
                                if ($unserializado !== false) {
                                    $valores_array = $unserializado; 
                                } else {
                                     $valores_array = array($dato->getDato());
                                }

                                $form->get($campo->getId())->setData($valores_array);
                                
                                break;
                            default:
                                //'Calificacion' y 'Tipo'. Por ahora 'Texto' y 'Numero' tienen el mismo comportamiento, sino descomentar arriba.
                                $form->get($campo->getId())->setData($dato->getDato());
                                break;
                        }
                    }
                }
            }
            
            $this->get('session')->getFlashBag()->add('error', 'Verifique los datos ingresados');
        }

        return $this->render('CespiIsoBundle:Registro:editcargado.html.twig', array(
                    'registro' => $registro,
                    'form' => $form->createView(),
                    'campos_date' => $campos_date,
                    'registro_cargado' => $registro_cargado->getId(),
                    'url_back' => $url_back
        ));
    }

    /**
     * Lists all Registro entities.
     *
     */
    public function indexAction()
    {
        
      /*  
        if ($this->getUser()->getPerfil() == 'ROLE_ADMIN'){
      */  
        if ( $this->get('security.context')->isGranted('ROLE_ADMIN') ) {
            $em = $this->getDoctrine()->getManager();

            $entities = $em->getRepository('CespiIsoBundle:Registro')->findAll();
            //$entities = $this->getEntitiesByAlcance( $em = $this->getDoctrine()->getManager());

            return $this->render('CespiIsoBundle:Registro:index.html.twig', array(
                'entities' => $entities,
            ));
      
        } else {
            
            
            $this->get('session')->getFlashBag()->add('error', 'No tiene los permisos para modificar registros');
            return $this->redirect($this->generateUrl('cargar_registros'));
            
        }
        
    }
    
    
    public function registroBuscarAction(Request $request) {
        
        
        $texto_buscado = strtolower($request->get('texto_buscar'));
        $em = $this->getDoctrine()->getManager();
        
        //$registros = $em->getRepository('CespiIsoBundle:Registro')->findAll();
        
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')){
               $registros = $em->getRepository('CespiIsoBundle:Registro')->findAll();
        }else{
               $registros = $this->getEntitiesByAlcance( $em = $this->getDoctrine()->getManager());
        }
        
           
        // si no está en blanco
        if ($texto_buscado){
        
       
        $registros_filtrado = array();
        $datos = array();
        
        foreach ($registros as $registro){
            $registros_filtrado[$registro->getId()] = $registro;
            $registros_cargados = $em->getRepository('CespiIsoBundle:RegistroCargado')->findByIdRegistro($registro->getId());

            $campos = $em->getRepository('CespiIsoBundle:RegistroCampos')->findByIdRegistro($registro, array ('orden'=> 'ASC'));
        
            $registros_cargados_filtrado = array();
            
            $lo_encontro = false;

            if (\strpos(strtolower($registro->getNombre()), strtolower($texto_buscado)) !== FALSE) {
              
                $lo_encontro = true;
            }
            
            if (\strpos(strtolower($registro->getDescripcion()), strtolower($texto_buscado)) !== FALSE) {
                $lo_encontro = true;
            }        
            
            for ($i = 0; $i < count($registros_cargados) && $lo_encontro == false ; $i++) {
 
                $registro_cargado = $registros_cargados[$i];
               
                $datos[$registro_cargado->getId()] = $em->getRepository('CespiIsoBundle:RegistroCargadoDato')->findByIdRegistroCargado($registro_cargado->getId());

                foreach ($datos[$registro_cargado->getId()] as $dato) {
                    $datos_unificados[$registro_cargado->getId()][$dato->getIdRegistroCampo()->getId()] = $dato;
                }

                $datos[$registro_cargado->getId()] = $datos_unificados[$registro_cargado->getId()];

                $registros_cargados_filtrado[$registro_cargado->getId()] = $registro_cargado;
               
                
                foreach ($campos as $campo) {

                    foreach ($datos[$registro_cargado->getId()] as $indice => $dato) {

                        if ($dato->getIdRegistroCampo()->getId() == $campo->getId()) {

                            switch ($campo->getIdTipoCampo()) {
                                case 'Texto':
                                case 'Numero':
                                    // No hace nada, muestra el dato como esta
                                    break;
                                case 'Tabulado':
                                if ($dato->getDato()!= ''){
                                    $valores = array();
                                    $nombre= $campo->getNombre();
                                    $opciones = substr($nombre, strpos($nombre,'(')+1,  strpos($nombre,')')- strpos($nombre,'(') - 1);
                                    $valores = explode(',', $opciones);  

                                    $dato->setDato($valores[$dato->getDato()]);
                                }
                                break;
                                case 'Tipo':
                                case 'Estado':                                
                                    //Los tipos agregados en la tabla tipo_campo_valor que van a ser mostrados como campo select                      
                                    $pasar_a_valores = array();
                                    $valores = $em->getRepository('CespiIsoBundle:TipoCampoValor')->findByTipoCampoId($campo->getIdTipoCampo());
                                    foreach ($valores as $v) { 
                                        $pasar_a_valores[$v->getValor()] = $v->getTexto();
                                    }
                                    $dato->setDato($pasar_a_valores[$dato->getDato()]);
                                    break;
                                case 'Fecha' :
                                    $fecha = date_create_from_format('Y-m-d H:i:s', $dato->getDato());
                                    $newformat = date_format($fecha, 'd/m/Y');
                                    $dato->setDato($newformat);
                                    break;
                                case 'Usuarios':
                                    $usuarios = unserialize($dato->getDato());
                                    $usr_string = '';
                                    foreach ($usuarios as $usuario) {
                                        $usr_string .= $em->getRepository('CespiIsoBundle:Usuarios')->findOneById($usuario) . " - ";
                                    }
                                    $dato->setDato($usr_string);
                                    break;
                            }

                           
                            
                            if (\strpos(strtolower($dato->getDato()), strtolower($texto_buscado)) == FALSE) {
                                // Si esta no hago nada, lo hago asi para chequerar que devuelva FALSE
                                // y que no se interprete el 0 como false si la encuentra al comienzo.
                                
                            }else{
                               $lo_encontro = true;
                            }
                        }
                    }
                }
                if (!$lo_encontro)
                    unset ($registros_cargados_filtrado[$registro_cargado->getId()]); 
            }
            // si ningun registro cargado tenia el dato vuelo al registro
            if (empty($registros_cargados_filtrado) && !$lo_encontro){
                   unset ($registros_filtrado[$registro->getId()]); 
               
            }
            
        }    

        }else{
            $registros_filtrado =  $registros;
        }
        
        return $this->render('CespiIsoBundle:Registro:alta.html.twig', array(
            'entities' => $registros_filtrado,
            'texto_buscado' => $texto_buscado,
        ));
      

        
    }
    
     /**
     * Lists all Registro entities.
     *
     */
    public function altaAction()
    {
       
        $em = $this->getDoctrine()->getManager();
        
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')){
            $entities = $em->getRepository('CespiIsoBundle:Registro')->findAll();
        }else{
            //$entities = $em->getRepository('CespiIsoBundle:Registro')->findAll();
            $entities = $this->getEntitiesByAlcance( $em = $this->getDoctrine()->getManager());
        }
        return $this->render('CespiIsoBundle:Registro:alta.html.twig', array(
            'entities' => $entities,
        ));
    }
    
      
    /**
     * Creates a new Registro entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Registro();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        
        /* Por poner campos de fecha 'text' y no 'date' (problema con chrome)*/
        $this->convertirStringAFecha($entity);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('registro_show', array('id' => $entity->getId())));
        }

        return $this->render('CespiIsoBundle:Registro:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
    

   

    /**
    * Creates a form to create a Registro entity.
    *
    * @param Registro $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Registro $entity)
    {
        $form = $this->createForm(new RegistroType(), $entity, array(
            'action' => $this->generateUrl('registro_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Crear','attr' => array('class' => 'marg btn btn-primary btn-sm')));

        return $form;
    }

    /**
     * Displays a form to create a new Registro entity.
     *
     */
    public function newAction()
    {
        $entity = new Registro();
        $form   = $this->createCreateForm($entity);

        return $this->render('CespiIsoBundle:Registro:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Registro entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CespiIsoBundle:Registro')->find($id);
		  $cambios = $em->getRepository('CespiIsoBundle:RegistroControlCambios')->findByIdRegistro($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Registro entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CespiIsoBundle:Registro:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(), 
            'cambios'	  => $cambios,
            
        ));
    }

   
   
    /**
    * Creates a form to edit a Registro entity.
    *
    * @param Registro $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Registro $entity)
    {
        $form = $this->createForm(new RegistroType(), $entity, array(
            'action' => $this->generateUrl('registro_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar','attr' => array('class' => 'marg btn btn-primary btn-sm')));

        return $form;
    }
    /**
     * Edits an existing Registro entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CespiIsoBundle:Registro')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Registro entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        /* Por poner campos de fecha 'text' y no 'date' (problema con chrome)*/
        $this->convertirFechasAString($entity);
        /* */  
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
             /* Por poner campos de fecha 'text' y no 'date' (problema con chrome)*/    
            $this->convertirStringAFecha($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Se guardaron los cambios');
            return $this->redirect($this->generateUrl('registro_edit', array('id' => $id)));
        }else{
            $this->get('session')->getFlashBag()->add('error', 'Verifique los datos ingresados');
        }

        return $this->render('CespiIsoBundle:Registro:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Registro entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CespiIsoBundle:Registro')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Registro entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('registro'));
    }

    /**
     * Creates a form to delete a Registro entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('registro_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Borrar','attr' => array('class' => 'btn btn-danger btn-sm')))
            ->getForm()
        ;
    }
    
    private function convertirStringAFecha(&$entity) {
        $entity->setFechaUltimaActualizacion(date_create_from_format('d/m/Y', $entity->getFechaUltimaActualizacion())); //sacar cuando se use tipo date
       
    }
    private function convertirFechasAString(&$entity) {
        $entity->setFechaUltimaActualizacion($entity->getFechaUltimaActualizacion()->format('d/m/Y')); //sacar cuando se use tipo date      
    }
}
