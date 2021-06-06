<?php

namespace App\Module1\Repository;

use App\Module1\Entity\User;
use App\WebService\Rest\UserAPI\UserApi;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository
{
    private $userApi;

    public function __construct(UserApi $userApi)
    {
        $this->userApi = $userApi;
    }

    public function getUsers(): array
    {
        $response = $this->userApi->request('GET', 'todos');
        return json_decode($response->getContent());
    }

    public function getUserById(int $id): object
    {
        $response = $this->userApi->request('GET', 'todos/'.$id);
        return json_decode($response->getContent());
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
