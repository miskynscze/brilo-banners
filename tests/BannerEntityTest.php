<?php

namespace App\Tests;

use App\Entity\Banner;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BannerEntityTest extends KernelTestCase
{

    public function testBannerCreateValid(): void
    {
        self::bootKernel();

        $container = self::getContainer();

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $container->get(EntityManagerInterface::class);

        $banner = new Banner();
        $banner->setFile("TEST.jpg");
        $banner->setPublished(true);
        $banner->setShowDuration(10);

        $entityManager->persist($banner);
        $entityManager->flush();

        $this->assertNotEmpty($banner->getId());
    }
}