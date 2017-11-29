<?php

namespace FeedGroupaliaBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use FeedGroupaliaBundle\Entity\MapeoGoogleCategoryWithGroupalia;
use FeedGroupaliaBundle\Entity\User;

class LoadMapeoGoogleCategoryWithGroupalia implements FixtureInterface, ContainerAwareInterface {

    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null) {
        ini_set('max_execution_time', 1800);
        $this->container = $container;
    }

    public function load(ObjectManager $manager) {
        $connection = $manager->getConnection();
        $connection->executeQuery($this->getQueryGoogleCategories($this->container));
        $MapeoGoogleCategoryWithGroupalia = new MapeoGoogleCategoryWithGroupalia();
        $MapeoGoogleCategoryWithGroupalia->setIdGroupalia(137);
        $MapeoGoogleCategoryWithGroupalia->setLineaCategoryGoogleMerchant($manager->getRepository("FeedGroupaliaBundle:LineaCategoryGoogleMerchant")->findOneBy(array('idGoogle' => 469)));
        $manager->persist($MapeoGoogleCategoryWithGroupalia);
        $manager->flush();
        $MapeoGoogleCategoryWithGroupalia = new MapeoGoogleCategoryWithGroupalia();
        $MapeoGoogleCategoryWithGroupalia->setIdGroupalia(2);
        $MapeoGoogleCategoryWithGroupalia->setLineaCategoryGoogleMerchant($manager->getRepository("FeedGroupaliaBundle:LineaCategoryGoogleMerchant")->findOneBy(array('idGoogle' => 8)));
        $manager->persist($MapeoGoogleCategoryWithGroupalia);
        $manager->flush();
        $MapeoGoogleCategoryWithGroupalia = new MapeoGoogleCategoryWithGroupalia();
        $MapeoGoogleCategoryWithGroupalia->setIdGroupalia(273);
        $MapeoGoogleCategoryWithGroupalia->setLineaCategoryGoogleMerchant($manager->getRepository("FeedGroupaliaBundle:LineaCategoryGoogleMerchant")->findOneBy(array('idGoogle' => 135)));
        $manager->persist($MapeoGoogleCategoryWithGroupalia);
        $manager->flush();
        $MapeoGoogleCategoryWithGroupalia = new MapeoGoogleCategoryWithGroupalia();
        $MapeoGoogleCategoryWithGroupalia->setIdGroupalia(81);
        $MapeoGoogleCategoryWithGroupalia->setLineaCategoryGoogleMerchant($manager->getRepository("FeedGroupaliaBundle:LineaCategoryGoogleMerchant")->findOneBy(array('idGoogle' => 111)));
        $manager->persist($MapeoGoogleCategoryWithGroupalia);
        $manager->flush();
        $MapeoGoogleCategoryWithGroupalia = new MapeoGoogleCategoryWithGroupalia();
        $MapeoGoogleCategoryWithGroupalia->setIdGroupalia(339);
        $MapeoGoogleCategoryWithGroupalia->setLineaCategoryGoogleMerchant($manager->getRepository("FeedGroupaliaBundle:LineaCategoryGoogleMerchant")->findOneBy(array('idGoogle' => 1475)));
        $manager->persist($MapeoGoogleCategoryWithGroupalia);
        $manager->flush();
    }

    private function getQueryGoogleCategories() {
        $kernel = $this->container->get("Kernel");
        $sqlPathFile = $kernel->locateResource('@FeedGroupaliaBundle/Resources/SqlFixtures/google_categories.sql');
        $sql = file_get_contents($sqlPathFile);
        return $sql;
    }

}
