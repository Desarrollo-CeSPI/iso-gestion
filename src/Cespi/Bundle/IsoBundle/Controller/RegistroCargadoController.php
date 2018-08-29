<?php

namespace Cespi\Bundle\IsoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Cespi\Bundle\IsoBundle\Entity\RegistroCargado;
use Cespi\Bundle\IsoBundle\Entity\RegistroCargadoDato;

/**
 * RegistroCargado controller.
 *
 */
class RegistroCargadoController extends Controller {

   
    /**
     * Lists all RegistroCargado entities.
     *
     */
    public function indexAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CespiIsoBundle:RegistroCargado')->findByIdRegistro($id);
        $registro = $em->getRepository('CespiIsoBundle:Registro')->findById($id);


        return $this->render('CespiIsoBundle:RegistroCargado:index.html.twig', array(
                    'entities' => $entities,
                    'registro' => $registro[0]
        ));
    }

    /**
     * Finds and displays a RegistroCargado entity.
     *
     */
    public function showAction($id, Request $request) {
        $em = $this->getDoctrine()->getManager();

        $muestra_historial = $request->get('historial');

        $entity = $em->getRepository('CespiIsoBundle:RegistroCargado')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RegistroCargado entity.');
        }

        $campos = $em->getRepository('CespiIsoBundle:RegistroCampos')->findByIdRegistro($entity->getIdRegistro(), array ('orden'=> 'ASC'));

        $datos = $em->getRepository('CespiIsoBundle:RegistroCargadoDato')->findByIdRegistroCargado($entity);

        if ($muestra_historial != 'si') {
            foreach ($datos as $dato) {
                $datos_unificados[$dato->getIdRegistroCampo()->getId()] = $dato;
            }

            $datos = $datos_unificados;
        }



        foreach ($campos as $campo) {

            foreach ($datos as $indice => $dato) {

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

                                    // si no es un array lo convierto en un array, esto es porque se modificó 
                                    // la aplicación para que este tipo de campos permita selección múltiple.

                                    $unserializado = @unserialize($dato->getDato());
                                    if ($unserializado !== false) {
                                        $valores_array = $unserializado; 
                                    } else {
                                         $valores_array = array($dato->getDato());
                                    }

                                    $valores_return = '';
                                    foreach ($valores_array as $valor_seleccionado)
                                        $valores_return .= $valores[$valor_seleccionado] . ',';
    
                                    $dato->setDato(rtrim ($valores_return, ','));
                                    
                            }
                        break;
                        case 'Tipo':
                        case 'Estado':
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
                }
            }
        }
        
        

        return $this->render('CespiIsoBundle:RegistroCargado:show.html.twig', array(
                    'entity' => $entity,
                    'datos' => $datos
        ));
    }

    /**
     * Finds and displays a RegistroCargado entity.
     *
     */
    public function showTodosAction($id,$posicion) {
        
        return $this->redirect($this->generateUrl('registrocargado_filtro', array('id' => $id, 'posicion' =>  $posicion) ));
    }
    
    private function xlsBOF() {
		 return pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
	  }
	  private function xlsEOF() {
		 return pack("ss", 0x0A, 0x00);
	  }
	  
	  private function xlsWriteNumber($Row, $Col, $Value) {
		 return pack("sssss", 0x203, 14, $Row, $Col, 0x0).pack("d", $Value);
		// return pack("d", $Value);
	  }
	  
	  private function xlsWriteLabel($Row, $Col, $Value) {
		  $L = strlen($Value);
		  return pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L) . $Value;
		  // return $Value;
	  }
    
    
    
    public function exportarRegistroCargadoAction($id, Request $request) {
        
        $em = $this->getDoctrine()->getManager();
        
        $registro = $em->getRepository('CespiIsoBundle:Registro')->find($id);
        
        $session = $request->getSession();
        $entities_filtrado = $session->get('entidades_filtrado', array());
        
        if (count ($entities_filtrado ))
           $entities = $entities_filtrado ; 
        else
           $entities = $em->getRepository('CespiIsoBundle:RegistroCargado')->findByIdRegistro($id);


        $campos = $em->getRepository('CespiIsoBundle:RegistroCampos')->findByIdRegistro($id, array ('orden'=> 'ASC'));

        $salida = array();
        $salida[] = $this->xlsBOF();
        
        $fila = 0;
        
        
        $salida[] = $this->xlsWriteLabel($fila++, 0, $registro->getNombre());
        $salida[] = $this->xlsWriteLabel($fila++, 0, utf8_decode("Revisión actual: ").$registro->getRevisionActual());
        
        $salida[] = $this->xlsWriteLabel($fila++, 0, utf8_decode("Fecha de la revisión actual: ").date_format($registro->getFechaUltimaActualizacion(), 'd/m/Y'));
        
        // $salida[] = $this->xlsWriteLabel($fila, 0, 'Fecha de Carga');
      
        for($i=0;$i<count($campos); $i++) {
            //$salida[] = $this->xlsWriteLabel($fila, $i+1, utf8_decode($campos[$i]->getNombre()));
            $nombre = $campos[$i]->getNombre();
            $a = strpos($nombre,'(');
            if ($a !== false){
                $nombre = substr($nombre, 0, strpos($nombre,'('));
            }
            $salida[] = $this->xlsWriteLabel($fila, $i, utf8_decode($nombre));
        }

        
        $col = 0;
        foreach ($entities as $entity) {
            
            $fila++;

            $datos[$entity->getId()] = $em->getRepository('CespiIsoBundle:RegistroCargadoDato')->findByIdRegistroCargado($entity->getId());
            /*
            foreach ($datos[$entity->getId()] as $dato) {
                $datos_unificados[$entity->getId()][$dato->getIdRegistroCampo()->getId()] = $dato;
            }
            */       
            // reordeno
            $orden = 0;
            
            foreach ($campos as $campo) {
                $cargado = false; 
                foreach ($datos[$entity->getId()] as $dato) {
                    if ($dato->getIdRegistroCampo()->getId() == $campo->getId()) {
                        //$datos_unificados[$entity->getId()][$dato->getIdRegistroCampo()->getId()] = $dato;
                        $datos_unificados[$entity->getId()][$orden] = $dato;
                        $cargado = true; 
                    }  
                }
                if (!$cargado) {
                    $vacio = new RegistroCargadoDato ;
                   // $vacio->setId('9999');
                    $vacio->setIdRegistroCampo($campo);
                    $vacio->setDato("");
                    

                    $datos_unificados[$entity->getId()][$orden] =  $vacio ;
    
                }
                $orden ++;
            }
            
            $datos[$entity->getId()] = $datos_unificados[$entity->getId()];

            // $col = 1;
            $col = 0;
            foreach ($campos as $campo) {

                //$newformat = date_format($entity->getCreatedAt(), 'd/m/Y');
                //$salida[] = $this->xlsWriteLabel($fila, 0, utf8_decode($newformat));
                    
                foreach ($datos[$entity->getId()] as $indice => $dato) {                 
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
                              
                                $unserializado = @unserialize($dato->getDato());
                                if ($unserializado !== false) {
                                    $valores_array = $unserializado; 
                                } else {
                                     $valores_array = array($dato->getDato());
                                }

                                $valores_return = '';
                                foreach ($valores_array as $valor_seleccionado)
                                    $valores_return .= $valores[$valor_seleccionado] . ',';
 
                                $dato->setDato(rtrim ($valores_return, ','));

                              }
                            break;
                            case 'Tipo':
                            case 'Estado':                                
                                if ($dato->getDato()!= ''){
                                    $pasar_a_valores = array();
                                    $valores = $em->getRepository('CespiIsoBundle:TipoCampoValor')->findByTipoCampoId($campo->getIdTipoCampo());
                                    foreach ($valores as $v) { 
                                        $pasar_a_valores[$v->getValor()] = $v->getTexto();
                                    }
                                    $dato->setDato($pasar_a_valores[$dato->getDato()]);
                                }
                                break;                           
                            case 'Fecha' :
                                if ($dato->getDato()!= ''){
                                    $fecha = date_create_from_format('Y-m-d H:i:s', $dato->getDato());
                                    $newformat = date_format($fecha, 'd/m/Y');
                                    $dato->setDato($newformat);
                                }
                                break;
                            case 'Usuarios':
                                if ($dato->getDato()!= ''){
                                    $usuarios = unserialize($dato->getDato());
                                    $usr_string = '';
                                    foreach ($usuarios as $usuario) {
                                        $usr_string .= $em->getRepository('CespiIsoBundle:Usuarios')->findOneById($usuario) . " - ";
                                    }
                                    $dato->setDato($usr_string);
                                }
                                break;
                        }
                        $salida[] = $this->xlsWriteLabel($fila, $col++, utf8_decode($dato->getDato()));
                    }
                }
            }
        }
        

        $salida[] = $this->xlsEOF();

        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment; filename=\"documentos_" . date("d_m_Y") . ".xls\"");
        header("Content-Transfer-Encoding: binary");
        header("Pragma: no-cache");
        header("Expires: 0");

        foreach ($salida as $sal) {
            echo $sal;
        }
        die();
        exit;

    }
    
    public function registroCargadoLimpiarFiltroAction($id,  Request $request) {
        $id_filtro_borrar = $request->get('id_filtro');
        $session = $request->getSession();
        $filters = $session->get('filters', array());
        unset ($filters[$id_filtro_borrar]);
        $session->set('filters', $filters);
        $posicion = $request->get('posicion');
        
        if ($posicion == '')
             $posicion = 'V';
        
        if (count($filters))
            return $this->redirect($this->generateUrl('registrocargado_filtro', array('id' => $id, 'posicion' =>  $posicion) ));
        else
            return $this->redirect($this->generateUrl('registrocargado_todos', array('id' => $id, 'posicion' =>  $posicion)));

    }
    
    public function registroCargadoFiltroAction($id, Request $request) {
        
        
        //$alcances = $this->getUser()->getAlcances();
        
        $posicion = $request->get('posicion');

        $datos = array();
        $entities_filtrado = array();
        $em = $this->getDoctrine()->getManager();
        $registro = $em->getRepository('CespiIsoBundle:Registro')->findOneById($id);

        $entities = $em->getRepository('CespiIsoBundle:RegistroCargado')->findByIdRegistro($id);

        $campos = $em->getRepository('CespiIsoBundle:RegistroCampos')->findByIdRegistro($id, array ('orden'=> 'ASC'));
       
        //die ("here for some reason");
        $session = $request->getSession();
        $filters = $session->get('filters', array());
       
        $filtrar = $request->get('filtrotexto');
        if ( $filtrar != ''){
            $request_id_tipo_campo = \substr($request->get('idTipoCampo'), 0,  \strpos($request->get('idTipoCampo'), ',') );
            $request_nombre_campo = \substr($request->get('idTipoCampo'), \strpos($request->get('idTipoCampo'), ',')+1, \strlen($request->get('idTipoCampo')) );        
            $request_texto_buscado = $request->get('filtrotexto');

            $filters[$request_id_tipo_campo]['campo'] = $request_nombre_campo;
            $filters[$request_id_tipo_campo]['texto'] = strtolower($request_texto_buscado);
            $filters[$request_id_tipo_campo]['id'] = $request_id_tipo_campo;

            $session->set('filters', $filters);

        }
                
        // entity representa la cabecera de un registro cargado
        foreach ($entities as $entity) {

            $datos[$entity->getId()] = $em->getRepository('CespiIsoBundle:RegistroCargadoDato')->findByIdRegistroCargado($entity->getId());
            
            // reordeno
            $orden = 0;
            
            foreach ($campos as $campo) {
                $cargado = false; 
                foreach ($datos[$entity->getId()] as $dato) {
                    if ($dato->getIdRegistroCampo()->getId() == $campo->getId()) {
                        //$datos_unificados[$entity->getId()][$dato->getIdRegistroCampo()->getId()] = $dato;
                        $datos_unificados[$entity->getId()][$orden] = $dato;
                        $cargado = true; 
                    }  
                }
                if (!$cargado) {
                    $vacio = new RegistroCargadoDato ;
                   // $vacio->setId('9999');
                    $vacio->setIdRegistroCampo($campo);
                    $vacio->setDato("");
                    

                    $datos_unificados[$entity->getId()][$orden] =  $vacio ;
    
                }
                $orden ++;
     
            }
                        
            
            $datos[$entity->getId()] = $datos_unificados[$entity->getId()];

            $entities_filtrado[$entity->getId()] = $entity;
            
            

            foreach ($campos as $campo) {
                
                foreach ($datos[$entity->getId()] as $indice => $dato) {
                    
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
                                    
                                    // si no es un array lo convierto en un array, esto es porque se modificó 
                                    // la aplicación para que este tipo de campos permita selección múltiple.

                                    $unserializado = @unserialize($dato->getDato());
                                    if ($unserializado !== false) {
                                        $valores_array = $unserializado; 
                                    } else {
                                         $valores_array = array($dato->getDato());
                                    }

                                    $valores_return = '';
                                    foreach ($valores_array as $valor_seleccionado)
                                        $valores_return .= $valores[$valor_seleccionado] . ',';
    
                                    $dato->setDato(rtrim ($valores_return, ','));
                                }
                            break;
                            case 'Tipo':
                            case 'Estado':                                
                                //Los tipos agregados en la tabla tipo_campo_valor que van a ser mostrados como campo select                      
                                if ($dato->getDato()!= ''){
                                    $pasar_a_valores = array();
                                    $valores = $em->getRepository('CespiIsoBundle:TipoCampoValor')->findByTipoCampoId($campo->getIdTipoCampo());
                                    foreach ($valores as $v) { 
                                        $pasar_a_valores[$v->getValor()] = $v->getTexto();
                                    }
                                    $dato->setDato($pasar_a_valores[$dato->getDato()]);
                                }
                                break;
                            case 'Fecha' :
                                if ($dato->getDato()!= ''){
                                    $fecha = date_create_from_format('Y-m-d H:i:s', $dato->getDato());
                                    $newformat = date_format($fecha, 'd/m/Y');
                                    $dato->setDato($newformat);
                                }
                                break;
                            case 'Usuarios':
                                if ($dato->getDato()!= ''){
                                    $usuarios = unserialize($dato->getDato());
                                    $usr_string = '';
                                    foreach ($usuarios as $usuario) {
                                        $usr_string .= $em->getRepository('CespiIsoBundle:Usuarios')->findOneById($usuario) . " - ";
                                    }
                                    $dato->setDato($usr_string);
                                }
                                break;
                        }
                        
                        if (isset($filters[$campo->getId()])){
                            if (\strpos(strtolower($dato->getDato()), strtolower($filters[$campo->getId()]['texto'] )) !== FALSE) {
                                // Si esta no hago nada, lo hago asi para chequerar que devuelva FALSE
                                // y que no se interprete el 0 como false si la encuentra al comienzo.
                            }else{
                                unset ($entities_filtrado[$entity->getId()]); 
                            }
                        }
                        
                        
                    }
                   
                }
            }
        }  
        
        
         
        foreach ($entities_filtrado as $e ){
             foreach ( $datos[$e->getId()] as $d ){
                if ($d->getIdRegistroCampo()->getIdTipoCampo() == 'Tabulado') :
                    $nombre= $d->getIdRegistroCampo()->getNombre();
                    $a = strpos($nombre,'(');

                    if ($a !== false){
                      $nombre = substr($nombre, 0, strpos($nombre,'('));
                      $d->getIdRegistroCampo()->setNombre($nombre);            
                    }
                endif ;
             }
             
        }
        
        
        
        $session->set('entidades_filtrado', $entities_filtrado);
        
        if ($posicion == 'V') {
            $tpl = 'CespiIsoBundle:RegistroCargado:showtodos.filtro.html.twig'; }
        else {
            $posicion = 'H';
            $tpl = 'CespiIsoBundle:RegistroCargado:showtodoshorizontal.filtro.html.twig';
        }

        return $this->render($tpl, array(
                    'entities' => $entities_filtrado,
                    'datos' => $datos,
                    'registro' => $registro,
                    'campos' => $campos,
                    'posicion' => $posicion,
                    'filtros' => $filters,
                    'vista' => $posicion
        ));
        
    }
    
    public function deleteAction($id) {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CespiIsoBundle:RegistroCargado')->find($id);
        $id_registro = $entity->getIdRegistro()->getId();
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Registro entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('registrocargado', array('id' => $id_registro)));
    }

}
