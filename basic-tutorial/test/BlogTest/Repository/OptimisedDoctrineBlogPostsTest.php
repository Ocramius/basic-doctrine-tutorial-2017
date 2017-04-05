<?php

namespace BlogTest\Repository;

use Authentication\Entity\User;
use Authentication\Repository\Users;
use Blog\Entity\BlogPost;
use Blog\Repository\OptimisedDoctrineBlogPosts;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\DBAL\Driver\PDOSqlite\Driver;
use Doctrine\DBAL\Logging\DebugStack;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Driver\XmlDriver;
use Doctrine\ORM\Proxy\ProxyFactory;
use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit\Framework\TestCase;

/**
 * @coversNothing
 */
final class OptimisedDoctrineBlogPostsTest extends TestCase
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var DebugStack
     */
    private $logger;

    /**
     * @var OptimisedDoctrineBlogPosts
     */
    private $repository;

    /**
     * @var string
     */
    private $id;

    protected function setUp() : void
    {
        parent::setUp();

        $config = new Configuration();

        $this->logger = new DebugStack();

        $config->setProxyDir(sys_get_temp_dir());
        $config->setProxyNamespace('TestProxies');
        $config->setAutoGenerateProxyClasses(ProxyFactory::AUTOGENERATE_EVAL);
        $config->setMetadataDriverImpl(new XmlDriver([__DIR__ . '/../../../mapping']));
        $config->setSQLLogger($this->logger);

        $this->entityManager = EntityManager::create(
            [
                'driverClass' => Driver::class,
                'memory'      => true,
            ],
            $config
        );

        (new SchemaTool($this->entityManager))
            ->createSchema($this->entityManager->getMetadataFactory()->getAllMetadata());

        $this->repository = new OptimisedDoctrineBlogPosts($this->entityManager);

        $this->id = uniqid('someId', true);

        (new ORMExecutor($this->entityManager, new ORMPurger($this->entityManager)))
            ->execute([
                new BlogPostWith3CommentsFromTheAuthor($this->id)
            ]);
    }

    public function testWillOnlyExecuteOneQueryEver() : void
    {
        $queryCount = count($this->logger->queries);

        $this->repository->get($this->id);

        self::assertLessThanOrEqual($queryCount + 1, count($this->logger->queries));
    }
}

final class BlogPostWith3CommentsFromTheAuthor implements FixtureInterface
{
    /**
     * @var string
     */
    private $blogPostId;

    public function __construct(string $blogPostId)
    {
        $this->blogPostId = $blogPostId;
    }

    public function load(ObjectManager $manager)
    {
        $user = User::register(
            'foo@example.com',
            'bar',
            'strtolower',
            new class implements Users {
                public function has(string $emailAddress) : bool {
                    return false;
                }
                public function get(string $emailAddress) : User {
                    // empty on purpose
                }
                public function store(User $user) : void {
                    // empty on purpose
                }
            }
        );

        $blogPost = BlogPost::publish($this->blogPostId, 'The BlogPost', 'Some garbage', $user);

        $blogPost->publishComment('foo', $user);
        $blogPost->publishComment('bar', $user);
        $blogPost->publishComment('baz', $user);

        $manager->persist($user);
        $manager->persist($blogPost);
        $manager->flush();
        $manager->clear();
    }
}