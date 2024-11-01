<?php

namespace App\Repository;

use App\Entity\Visite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Visite>
 */
class VisiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Visite::class);
    }

    /**
     * Retourne toutes les visites triées sur un champ
     * @param string $champ
     * @param string $ordre
     * @return Visite[]
     */
    public function findAllOrderBy($champ, $ordre) : array {
        return $this->createQueryBuilder('v')
                ->orderBy('v.' . $champ, $ordre)
                ->getQuery()
                ->getResult();
    }

    /**
     * Retourne toutes les visites ayant une valeur spécifique
     * @param string $champ
     * @param mixed $valeur
     * @return Visite[]
     */
    public function findByEqualValue($champ, $valeur) : array {
        if ($valeur == "") {
            return $this->createQueryBuilder('v')
                ->orderBy('v.' . $champ, 'ASC') // Utilisez 'ASC' ou 'DESC' ici
                ->getQuery()
                ->getResult();
        } else {
            return $this->createQueryBuilder('v')
                ->where("v.$champ = :valeur")
                ->setParameter('valeur', $valeur)
                ->orderBy('v.datecreation', 'DESC')
                ->getQuery()
                ->getResult();
        }
    }

    /**     
     * Supprime une visite     
     * @param Visite $visite     
     * @return void     
     */    
    public function remove(Visite $visite) : void
    {        
        $this->getEntityManager()->remove($visite);        
        $this->getEntityManager()->flush();    
    }

    /**
     *  Ajoute ou modifie une visite
     * @param Visite $visite
     * @return void
     */
    public function add(Visite $visite): void
    {
        $this->getEntityManager()->persist($visite);
        $this->getEntityManager()->flush();
    }
}
