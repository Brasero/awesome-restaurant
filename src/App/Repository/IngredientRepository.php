<?php

namespace App\Repository;

use App\Entity\Ingredient;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * @extends EntityRepository<Ingredient>
 * @method Ingredient|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ingredient|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ingredient[]    findAll()
 * @method Ingredient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IngredientRepository extends EntityRepository
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, $em->getClassMetadata(Ingredient::class));
    }

    public function findByName(string $name): ?Ingredient
    {
        return $this->findOneBy(['nom' => $name]);
    }

    public function findByType(string $type): ?Ingredient
    {
        return $this->findOneBy(['type' => $type]);
    }

    public function findPaginated(int $page, int $limit): array
    {
        $offset = ($page - 1) * $limit;
        return $this->findBy([], ['nom' => 'ASC'], $limit, $offset);
    }
}
