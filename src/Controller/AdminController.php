<?php

namespace App\Controller;

use App\Component\Form\BannerForm;
use App\Component\Form\BannerFormObserver;
use App\Entity\Banner;
use App\System\Upload;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminController extends AbstractController
{


    #[Route('/admin', name: 'banner_list')]
    public function listBanner(EntityManagerInterface $entityManager): Response
    {
        return $this->render('admin/list.html.twig', [
            'banners' => $entityManager->getRepository(Banner::class)->findAll()
        ]);
    }

    #[Route('/admin/edit/{id}', name: 'banner_edit')]
    public function editBanner(Request $request, BannerFormObserver $bannerFormObserver, ?int $id = null): Response
    {
        $banner = new Banner();

        if($id) {
            $banner = $bannerFormObserver->getBannerData($id);
        }

        $form = $this->createForm(BannerForm::class, $banner);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $bannerFormObserver->observe($form, $this->getParameter("banners_dir"));

            return $this->redirectToRoute('banner_edit', [
                'id' => $banner->getId()
            ]);
        }

        return $this->render('admin/edit.html.twig', [
            'form' => $form,
            'editId' => $id,
            'bannerName' => $banner->getFile() ?: ''
        ]);
    }

    #[Route('/admin/delete/{id}', 'banner_delete')]
    public function deleteBanner(int $id, EntityManagerInterface $entityManager, Upload $upload): RedirectResponse
    {
        $banner = $entityManager->getRepository(Banner::class)->find($id);

        if(!$banner) {
            return $this->redirectToRoute('banner_list');
        }

        $upload->removeFile($this->getParameter("banners_dir") . '/' . $banner->getFile());

        $entityManager->remove($banner);
        $entityManager->flush();

        return $this->redirectToRoute('banner_list');
    }
}
