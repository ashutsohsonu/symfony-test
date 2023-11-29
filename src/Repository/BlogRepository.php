<?php

namespace App\Repository;

use App\Entity\Blog;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<Blog>
 *
 * @method Blog|null find($id, $lockMode = null, $lockVersion = null)
 * @method Blog|null findOneBy(array $criteria, array $orderBy = null)
 * @method Blog[]    findAll()
 * @method Blog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, CacheItemPoolInterface $cache)
    {
        parent::__construct($registry, Blog::class);
        $this->cache = $cache;
    }

    /**
     * @param Blog $blog
     * @param $userId
     * @return void
     */
    public function save(Blog $blog, $userId)
    {
        $now = new \DateTime('now');
        $blog->setUserId($userId);
        $blog->setCreatedAt($now);
        $blog->setUpdatedAt($now);
        $this->_em->persist($blog);
        $this->_em->flush();
    }

    /**
     * @param int $userId
     * @return Blog|Blog[]
     */
    public function getBlogList(array $userRoles, int $userId = 0): Blog|array
    {
        $cacheKey = 'blog_lists-'.$userId;

        // Try to get data from cache
        $result = $this->cache->getItem($cacheKey);
        if (!$result->isHit()) {
            if (in_array('ROLE_ADMIN', $userRoles)) {
                $data = $this->findAll();
            } else {
                $data = $this->findBy(["userId" => $userId]);
            }
            $result->set($data);
            $result->expiresAfter(3600);
            $this->cache->save($result);
        } else {
            $data = $result->get();
        }

        return $data;
    }

}
