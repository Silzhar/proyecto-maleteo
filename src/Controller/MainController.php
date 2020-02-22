<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Entity\Formulario;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class MainController extends AbstractController{

// AbstractController extiende de twig para pintar el index.
    /**
     * @Route("/", methods={"GET"}, name="maleteo")
     */
    public function index () {
        return $this->render("user/maleteo.html.twig");
        
    }

    /**
     * @Route("/user/maleteo", methods={"GET"}, name="get_user")
     */
    public function getUsers(EntityManagerInterface $em){
        $repo = $em->getRepository(Usuario::class);
        $usuarios = $repo->findAll();
        $this->addFlash('Éxito!','Demo solicitada');

        return $this->render("user/maleteo.html.twig", 
            ["usuarios"=> $usuarios]);

       // return $this->render("user/formUser.html.twig");
    }

    /**
     * @Route("/", methods={"POST"}, name="post_user")
     */
    public function postUser(Request $request, EntityManagerInterface $em){
        $nombre = $request->get('nombre');
        $email = $request->get('email');
        $city = $request->get('ciudad'); 

        // if($nombre && $email && $city != false) {
        $usuario = new Usuario();
        $usuario->setNombre($nombre);
        $usuario->setEmail($email);
        $usuario->setCity($city);

        $em->persist($usuario);
        $em->flush();


        $repo = $em->getRepository(Usuario::class);
        $usuarios = $repo->findAll();
        
        return $this->render("user/formUser.html.twig",
            [
             "nombre"=>$nombre,
             "email"=>$email,
             "city"=>$city,
             "usuarios"=>$usuarios
        ]);
        // } else{
        //     return $this->render("user/maleteo.html.twig");
        // }

        // return $this->render("user/formUser.html.twig",
        // [
        //     "nombre"=>$nombre,
        //     "email"=>$email,
        //     "city"=>$city,
        //     "usuarios"=>$usuarios
        // ]);
    }

    /**
     * @Route("/insert")
     */
    // public function insertFormulario (EntityManagerInterface $em){
        
    //     $insertFormulario = new Formulario();
    //     $insertFormulario->setLocalidad("Coslada, madrid");
    //     $insertFormulario->setOpinion("Amables en el trato y solucionaron 
    //     mi problema de qué hacer con la maleta. Puede visitar el museo sin la carga.
    //      Muy recomendable.");
    //     $insertFormulario->setPassword("1coslada1");
    //     $insertFormulario->setUsuario("Isolda");

    //     // Guardar en base de datos.
    //     $em->persist($insertFormulario);
    //     $em->flush();

    //     return new Response("Insert efectuado con éxito");
    // }

    /**
     * @Route("/Formulario", name="insertar_formulario")
     */
    public function comentarios(EntityManagerInterface $em){

        // Recuperar datos del formulario.
        $repositorio = $em->getRepository(Formulario::class);
        $registro = $repositorio->findAll();

        return $this->render(
            'user/registro.html.twig',
            [
                'registros'=>$registro
            ]
            );
    }
}

?>

<!-- 
/**
* @Route("/", name="homepage")
*/
return new Response("Primera ruta"); -->