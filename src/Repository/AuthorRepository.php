<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends ServiceEntityRepository<Author>
 */
class AuthorRepository extends ServiceEntityRepository
{
    private $entityManager;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
        $this->entityManager = $registry->getManager(); // Get the EntityManager here
    }

    // Add a new author to the database
    public function add(Author $author, bool $flush = true): void
    {
        $this->entityManager->persist($author); // Use the injected EntityManager
        if ($flush) {
            $this->entityManager->flush();
        }
    }

    // Remove an author from the database
    public function remove(Author $author, bool $flush = true): void
    {
        $this->entityManager->remove($author); // Use the injected EntityManager
        if ($flush) {
            $this->entityManager->flush();
        }
    }

    public function search($value ):array{

        return $this->createQueryBuilder('a')
        ->where('a.email LIKE :email')
        ->setParameter('email','%'.$value.'%')
        ->getQuery()
        ->getResult();
    }

    // Other custom query methods can be added here
}
