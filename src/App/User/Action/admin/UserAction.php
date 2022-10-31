<?php

namespace App\User\Action;

use App\Entity\User;
use Framework\Toaster\Toaster;
use Psr\Container\ContainerInterface;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Psr7\ServerRequest;

class UserAction {

    private EntityManagerInterface $manager;
    private Toaster $toaster;
    
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->toaster = $container->get(Toaster::class);
        $this->manager = $container->get(EntityManagerInterface::class);
    }

    public function delete(ServerRequest $request): string {

        $id = $request->getAttribute("id");
        $user = $this->manager->find(User::class, $id);

        $this->manager->remove($user);
        $this->manager->flush();
        $user = $this->manager->find(User::class, $id);
        if(!is_null($user)){
            return "false";
            $this->toaster->createToast("Une erreur s'est produite", Toaster::ERROR);
        }
        return "true";
        $this->toaster->createToast("Utilisateur supprimé", Toaster::SUCCESS);

    }
}