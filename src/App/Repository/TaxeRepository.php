<?php


namespace App\Repository;

use App\Entity\Taxe;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * @extends EntityRepository<Taxe>
 * @method Taxe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Taxe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Taxe[]    findAll()
 * @method Taxe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaxeRepository extends EntityRepository
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, $em->getClassMetadata(Taxe::class));
    }

    public function findByName(string $id): ?Taxe
    {
        return $this->findOneBy(['id' => $id]);
    }

    public function findByType(string $type): ?Taxe
    {
        return $this->findOneBy(['type' => $type]);
    }

    public function findPaginated(int $page, int $limit): array
    {
        $offset = ($page - 1) * $limit;
        return $this->findBy([], ['id' => 'ASC'], $limit, $offset);
    }

}
