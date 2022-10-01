<?php
namespace Framework\Database;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Exception;
use PDO;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class DatabaseFactory
{
    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function __invoke(ContainerInterface $container, array $modules): ?EntityManager
    {
        $paths = [dirname(__DIR__)];
        $isDevMode = (bool)$container->get("doctrine.is_dev_mode");
        $dbParams = [
            "driver" => "pdo_mysql",
            "user" => $container->get("database.user"),
            'password' => $container->get("database.pass"),
            "dbname" => $container->get("database.dbname"),
            "driverOptions" => [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            ]
        ];
        $config = ORMSetup::createAnnotationMetadataConfiguration($paths, $isDevMode);
        try {
            $conn = DriverManager::getConnection($dbParams);
            return EntityManager::create($conn, $config);
        } catch (Exception $e) {
            echo "[ERREUR] Une erreur c'est produite 
                    lors de la connection a la base de données => ".$e->getMessage();
            die();
        }
    }
}
