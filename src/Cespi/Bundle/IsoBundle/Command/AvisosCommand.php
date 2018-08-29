<?php

namespace Cespi\Bundle\IsoBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AvisosCommand extends ContainerAwareCommand
{
    const DIAS= 7;
            
            
    protected function configure()
    {
        $this
            ->setName('iso:avisos')
            ->setDescription('Verifica las fechas de los registros que se usan para avisar a los usuarios involucrados');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $header = 'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
                  'From: guarani@unlp.edu.ar' . "\r\n" .
                 'Reply-To: guarani@unlp.edu.ar' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
        
        $resultado = array();
        $output->writeln("<info>Buscando fechas.</info>");
        $em = $this->getContainer()->get('doctrine');
        $entities = $em->getRepository('CespiIsoBundle:RegistroCargadoDato')->controlAviso();
        
        //filtrar los ultimos de cada uno y guardarlo en $resultado solo si está a self::DIAS dias de hoy
        //$id_registro_cargado = -1;
        foreach ($entities as $entity) {
            //if ($id_registro_cargado != $entity->getIdRegistroCargado()->getId()) {
            //$id_registro_cargado = $entity->getIdRegistroCargado()->getId();
            $date = new \DateTime();
            $datedb = new \DateTime($entity->getDato());
            $date->setTimeZone(new \DateTimeZone('America/Buenos_Aires'));
            $diff_dias = $datedb->diff($date);
            $diff_dias = $diff_dias->format('%a');
            //se podria parametrizar la cantidad de dias
            if ($diff_dias <= self::DIAS) {
                $resultado[] = $entity;
                $nombres_campos[$entity->getId()] = $entity->getIdRegistroCampo()->getNombre();
            }
            //}
        }


        foreach ($resultado as $res) {
            $usuarios = array();
            $campos = $em->getRepository('CespiIsoBundle:RegistroCargadoDato')->getCamposAviso($res);
            foreach ($campos as $campo) {

                if ($campo->getIdRegistroCampo()->getIdTipoCampo()->getTipo() == 'Usuarios') {
                    $usuarios = array_merge($usuarios, unserialize($campo->getDato()));
                    $usuarios = array_unique($usuarios);
                }
            }
            $nombre_campo = $nombres_campos[$res->getId()];
            $context = $this->getContainer()->get('router');
            $link = $context->generate('registrocargado_todos', array('id' => $campo->getIdRegistroCargado()->getIdRegistro()->getId()),  UrlGeneratorInterface::ABSOLUTE_URL);
            $link = "<a href=\"" . $link . "\">" . $link . "</a>";
            foreach ($usuarios as $usuario_id) {
                $a = $em->getRepository('CespiIsoBundle:Usuarios')->findOneById($usuario_id);
                $output->writeln("Se enviara aviso a " . $a->getEmail() . " del campo " . $nombre_campo . ". Por el ID de registro: " . $campo->getIdRegistroCargado()->getId() . ". Nombre de registro: " . $campo->getIdRegistroCargado()->getIdRegistro()->getNombre());                                                             
                mail($a->getEmail(), utf8_decode("Aviso de aproximación a fecha para " . $nombre_campo . ". Sistema ISO"), utf8_decode("Queda menos de " .  self::DIAS ." días para llegar a la fecha marcada en el registro " . $campo->getIdRegistroCargado()->getIdRegistro()->getNombre()) . ": " . $link, $header);
            }
            //$output->writeln($res->getDato());
        }
        $output->writeln("Finalizado.");
    }

}