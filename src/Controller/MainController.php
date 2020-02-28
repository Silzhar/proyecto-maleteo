<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Entity\Formulario;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Util\FormUtil;
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

        return $this->render("user/demo.html.twig", 
        ["usuarios"=> $usuarios] ); // 

       // return $this->render("user/formUser.html.twig");
    }

    /**
     * @Route("/demo", methods={"POST"}, name="post_user")
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
        
        return $this->render("user/demo.html.twig",
            [
             "nombre"=>$nombre,
             "email"=>$email,
             "city"=>$city,
             "usuarios"=>$usuarios
        ]);

    }

    /**
     * @Route("/login", methods={"GET"}, name="get_registro")
     */
    public function getRegistro(EntityManagerInterface $em){
        $repo = $em->getRepository(Formulario::class);
        $registro = $repo->findAll();

        return $this->render("user/login.html.twig",
        ["registro"=>$registro] );
    }

    /**
     * @Route("/login", methods={"POST"}, name="post_registro")
     */ 
    public function postRegistro(Request $request, EntityManagerInterface $em){
        $usuarioRegistro = $request->get('usuario');
        $pass = $request->get('password');
        $localidad = $request->get('localidad');

        $registro = new Formulario();
        $registro->setUsuario($usuarioRegistro);
        $registro->setPassword($pass);
        $registro->setLocalidad($localidad);

        $em->persist($registro);
        $em->flush();

        $repo = $em->getRepository(Formulario::class);
        $registros = $repo->findAll();

        return $this->render("user/login.html.twig");
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
