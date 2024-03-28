<?php

namespace App\Component\Form;

use App\Entity\Banner;
use App\System\Upload;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;

class BannerFormObserver
{

    public function __construct(protected EntityManagerInterface $entityManager, protected Upload $upload) {}

    public function observe(FormInterface $form, string $directory, ?int $id = null): void
    {

        /** @var Banner $banner */
        $banner = $form->getData();
        $bannerFile = $form->get('file')->getData();

        if(!$id) {
            $banner->setDateUploaded(new \DateTime());
        }

        if($bannerFile) {
            $banner->setFile($this->upload->uploadFile($bannerFile, $directory));
        }

        $this->entityManager->persist($banner);
        $this->entityManager->flush();
    }

    public function getBannerData(int $id): ?Banner
    {
        return $this->entityManager->getRepository(Banner::class)->find($id);
    }
}