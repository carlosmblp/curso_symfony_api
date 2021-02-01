<?php
namespace App\Controller;
use App\Entity\Usuario;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use FOS\RestBundle\Controller\AbstractFOSRestController;

class UsuarioController extends AbstractController
{


    /**
     * @Route("/getAllUser", name="getAllUser", methods={"GET"})
     */
    public function getAllUser(): Response
    {   


        $em = $this->getDoctrine()->getManager();

        $usuarios = $this->getDoctrine()->getRepository(Usuario::class)->findAll();
        return new JsonResponse(json_encode(serialize($usuarios)),200);
      
    }

    /**
     * @Route("/add_user", name="add_user", methods={"POST"})
     */
    public function add_user(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $nombre = $data['nombre'];
        $apellido = $data['apellido'];
        $email = $data['email'];
        $f_nac = $data['f_nac'];
        $usuario = $data['usuario'];
        $password = $data['password'];

        if (empty($usuario) || empty($password)) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        $newUser = new Usuario();

        $newUser
            ->setNombre($nombre)
            ->setApellido($apellido)
            ->setEmail($email)
            ->setFNac($f_nac)
            ->setPassword($password)
            ->setUsuario($usuario)
          ;

        $this->manager->persist($newUser);
        $this->manager->flush();

        return new JsonResponse(['status' => 'Usuario created!'], Response::HTTP_CREATED);
    }

    
}

?>