<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use AppBundle\Entity\User;

class LoadUsers implements FixtureInterface, ContainerAwareInterface
{
    private $container;
    private $dataFixtures;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $companySlug = $this->container->getParameter('company_slug');
        $datafixtures = $this->container->getParameter('datafixtures.'.$companySlug.'.users');

        if (!is_null($datafixtures)) {
            $this->dataFixtures = $datafixtures;
        } else {
            throw new NotFoundHttpException(
                'No datafixtures parameters found for the company slug "'.$companySlug.'"'
            );
        }

        $encoderService = $this->container->get('security.password_encoder');

        foreach ($this->dataFixtures as $u) {
            $user = new User();
            $user->setUserName($u['name']);
            $user->setEmail($u['email']);
            $user->setPassword($encoderService->encodePassword($user, $u['password']));
            $manager->persist($user);
            $manager->flush();
        }
    }

}