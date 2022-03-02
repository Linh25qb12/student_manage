<?php

namespace App\Repository;

use App\Entity\Score;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Score|null find($id, $lockMode = null, $lockVersion = null)
 * @method Score|null findOneBy(array $criteria, array $orderBy = null)
 * @method Score[]    findAll()
 * @method Score[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScoreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Score::class);
    }

    public function findByStudentID($value)
    {
        return $this->createQueryBuilder('s')
            ->setParameter('val', $value)
            ->andWhere('s.student = :val')
            ->orderBy('s.student', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findScoreByStudentIdAndSubjectId($student, $subject){
        return $this->createQueryBuilder("s")
            ->setParameters(
                [
                    'student' => $student,
                    'subject' => $subject
                ]
            )
            ->where("s.student = :student")
            ->andWhere("s.subject = :subject")
            ->getQuery()
            ->getResult();
    }
}
