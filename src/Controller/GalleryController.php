<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Gallery;
use App\Entity\GalleryItem;
use App\Form\CommentType;
use App\Form\GalleryItemType;
use App\Form\GalleryType;
use App\Repository\CommentRepository;
use App\Repository\GalleryItemRepository;
use App\Repository\GalleryRepository;
use App\Repository\UserRepository;
use App\Service\FileUploader;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GalleryController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/gallery", name="app_gallery")
     */
    public function index(
        GalleryRepository $galleryRepository
    ): Response
    {
        $galleries = $galleryRepository->listOfGalleries();
        return $this->render('gallery/index.html.twig', [
            'galleries' => $galleries
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/gallery/add", name="app_gallery_add")
     */
    public function addGallery(
        Request $request,
        GalleryRepository $galleryRepository,
        UserRepository $userRepository,
        FileUploader $fileUploader
    ): Response
    {
        $Gallery = new Gallery();
        $Gallery->setUser($userRepository->find($this->getUser()));
        $form = $this->createForm(GalleryType::class, $Gallery);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $galleryRepository->add($Gallery);

            $file = $form['image']->getData();
            if($file){
                $fileName = $fileUploader->upload($file);
                $Gallery->setImage($fileName);
                $galleryRepository->add($Gallery);
            }

            $this->addFlash('success', 'Votre galerie a bien été créée');
            return $this->redirectToRoute('app_gallery');
        }

        return $this->render('gallery/add_gallery.html.twig', [
            'id' => $Gallery->getId(),
            'AddGalleryForm' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/gallery/{id}/edit", name="app_gallery_edit")
     */
    public function editGallery(
        Gallery $Gallery,
        Request $request,
        GalleryRepository $galleryRepository,
        FileUploader $fileUploader
    ): Response
    {
        $form = $this->createForm(GalleryType::class, $Gallery);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $galleryRepository->add($Gallery);

            $file = $form['image']->getData();
            if($file){
                $fileName = $fileUploader->upload($file);
                $Gallery->setImage($fileName);
                $galleryRepository->add($Gallery);
            }

            $this->addFlash('success', 'Votre galerie a bien été modifiée');
            return $this->redirectToRoute('app_gallery');
        }

        return $this->render('gallery/edit_gallery.html.twig', [
            'EditGalleryForm' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/gallery/{id}/delete", name="app_gallery_delete", requirements={"id"="\d+"})
     */
    public function deleteGallery(
        int $id,
        GalleryRepository $galleryRepository
    ): Response
    {
        $gallery = $galleryRepository->find($id);
        $galleryRepository->remove($gallery);

        return $this->render('gallery/delete_gallery.html.twig',[
            'gallery' => $gallery
        ]);
    }

    /**
     * @Route("/gallery/{gallery_id}", name="app_gallery_show", requirements={"id"="\d+"})
     * @ParamConverter("gallery", options={"mapping": {"gallery_id": "id"}})
     */
    public function showGallery(
        GalleryItemRepository $galleryItemRepository,
        GalleryItem $galleryItem,
        GalleryRepository $galleryRepository,
        Gallery $gallery,
        CommentRepository $commentRepository,
        Comment $comment,
        ManagerRegistry $registry,
        Request $request
    ): Response
    {
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $comment->setComment($form->get('comment')->getData());
            $comment->setGalleryItemId($galleryItem);

            dd($comment);
        }

        /*if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            $comment = $data['comment'];
            $setGalleryItemID = $galleryItemRepository->find($gallery->getId());
            $
            dd($comment);
            $galleryItemRepository->add($comment);
            $registry->getManager()->flush();
            $this->addFlash('success', 'Votre commentaire a bien été ajouté');
        } else {
            $this->addFlash('error', 'Erreur lors de l\'ajout du commentaire');
        }*/

        $listOfArts = $galleryItemRepository->listOfGalleryItems();

        return $this->render('gallery/gallery_art/index.html.twig',[
            'listOfArts' => $listOfArts,
            'gallery' => $gallery,
            'commentForm' => $form->createView()
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/gallery/{id}/art/add", name="app_gallery_add_art")
     * @ParamConverter("gallery", options={"mapping": {"id": "id"}})
     */
    public function addArt(
        Gallery $gallery,
        Request $request,
        GalleryItemRepository $galleryItemRepository,
        FileUploader $fileUploader
    ): Response
    {
        $galleryItem = new GalleryItem();
        $galleryItem->setGallery($gallery);
        $form = $this->createForm(GalleryItemType::class, $galleryItem);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $galleryItemRepository->add($galleryItem);

            $file = $form['image']->getData();
            if($file){
                $fileName = $fileUploader->upload($file);
                $galleryItem->setImage($fileName);
                $galleryItemRepository->add($galleryItem);
            }

            $this->addFlash('success', 'Votre oeuvre a bien été ajoutée');
            return $this->redirectToRoute('app_gallery_show', ['id' => $gallery->getId()]);
        }

        return $this->render('/gallery/gallery_art/add_art.html.twig', [
            'AddArtForm' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/gallery/{gallery_id}/art/{galleryItem_id}/edit") name="app_gallery_edit_art")
     * @ParamConverter("gallery", options={"mapping": {"gallery_id": "id"}})
     * @ParamConverter("galleryItem", options={"mapping": {"galleryItem_id": "id"}})
     */
    public function editArt(
        int $galleryItem_id ,
        Request $request,
        GalleryItemRepository $galleryItemRepository,
        FileUploader $fileUploader,
        Gallery $gallery
    ): Response
    {
        $galleryItem = $galleryItemRepository->find($galleryItem_id);
        $form = $this->createForm(GalleryItemType::class, $galleryItem);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $galleryItemRepository->add($galleryItem);

            $file = $form['image']->getData();
            if($file){
                $fileName = $fileUploader->upload($file);
                $galleryItem->setImage($fileName);
                $galleryItemRepository->add($galleryItem);
            }

            $this->addFlash('success', 'Votre oeuvre a bien été modifiée');
            return $this->redirectToRoute('app_gallery_show', ['id' => $gallery->getId()]);
        }

        return $this->render('/gallery/gallery_art/edit_art.html.twig', [
            'EditArtForm' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/gallery/{gallery_id}/art/{galleryItem_id}/delete", name="app_gallery_delete_art")
     * @ParamConverter("gallery", options={"mapping": {"gallery_id": "id"}})
     * @ParamConverter("galleryItem", options={"mapping": {"galleryItem_id": "id"}})
     */
    public function deleteArt(
        GalleryItem $galleryItem,
        GalleryItemRepository $galleryItemRepository,
        Gallery $gallery
    ): Response
    {
        $galleryItemRepository->remove($galleryItem);

        return $this->render('/gallery/gallery_art/delete_art.html.twig',[
            'galleryItem' => $galleryItem,
            'gallery' => $gallery
        ]);
    }
}
