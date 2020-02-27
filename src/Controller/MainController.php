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
        // $this->addFlash('Éxito!','Demo solicitada');

        return $this->render("user/registro.html.twig" 
            ); // ["usuarios"=> $usuarios]

       // return $this->render("user/formUser.html.twig");
    }

    /**
     * @Route("/registro", methods={"POST"}, name="post_user")
     */
    public function postUser(Request $request, EntityManagerInterface $em){
        $nombre = $request->get('nombre');
        $email = $request->get('email');
        $city = $request->get('ciudad'); 

        $usuario = new Usuario();
        $usuario->setNombre($nombre);
        $usuario->setEmail($email);
        $usuario->setCity($city);

        $em->persist($usuario);
        $em->flush();

        $repo = $em->getRepository(Usuario::class);
        $usuarios = $repo->findAll();
        
        return $this->render("user/registro.html.twig",
            [
             "nombre"=>$nombre,
             "email"=>$email,
             "city"=>$city,
             "usuarios"=>$usuarios
        ]);

        // return $this->render("/user/registro.html.twig",
        // [
        //     "nombre"=>$nombre,
        //     "email"=>$email,
        //     "city"=>$city,
        //     "usuarios"=>$usuarios
        // ]);
    }


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