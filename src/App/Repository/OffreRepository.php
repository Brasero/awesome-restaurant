<?php

namespace App\Repository;

use App\Entity\Offre;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * @extends EntityRepository<Offre>
 * @method Offre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Offre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Offre[]    findAll()
 * @method Offre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OffreRepository extends EntityRepository
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, $em->getClassMetadata(Offre::class));
    }

    public function findByName(string $name): ?Offre
    {
        return $this->findOneBy(['nom' => $name]);
    }

    public function findByType(string $type): ?Offre
    {
        return $this->findOneBy(['type' => $type]);
    }

    public function findPaginated(int $page, int $limit): array
    {
        $offset = ($page - 1) * $limit;
        return $this->findBy([], ['nom' => 'ASC'], $limit, $offset);
    }
}
