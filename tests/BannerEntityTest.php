<?php

namespace App\Tests;

use App\Entity\Banner;
use Doctrine\DBAL\Exception\NotNullConstraintViolationException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BannerEntityTest extends KernelTestCase
{

    private EntityManager $entityManager;

    protected function setUp(): void
    {
        parent::setUp();

        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
    }

    public function testBannerCreateValid(): void
    {
        $banner = new Banner();
        $banner->setFile("TEST.jpg");
        $banner->setPublished(true);
        $banner->setShowDuration(10);
        $banner->setDateUploaded(new \DateTime());

        $this->entityManager->persist($banner);
        $this->entityManager->flush();

        $this->assertNotEmpty($banner->getId());
    }

    public function testBannerNotCreateInvalid(): void
    {
        $this->expectException(NotNullConstraintViolationException::class);

        $banner = new Banner();
        $banner->setFile("TEST.jpg");
        $banner->setPublished(true);
        $banner->setShowDuration(10);

        $this->entityManager->persist($banner);
        $this->entityManager->flush();
    }

    public function testRemoveAllBanners(): void
    {
        $banners = $this->entityManager->getRepository(Banner::class)->findAll();

        foreach($banners as $banner) {
            $this->entityManager->remove($banner);
        }

        $this->entityManager->flush();

        $this->assertEmpty($this->entityManager->getRepository(Banner::class)->findAll());
    }
}