<?php

namespace App\Controller\Admin;

use App\Entity\Livre;
use App\Entity\Utilisateur;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use Symfony\Component\Validator\Constraints\File;
// // use EasyCorp\Bundle\EasyAdminBundle\Field\FileField;
// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
// use Vich\UploaderBundle\Storage\StorageInterface;
// use Vich\UploaderBundle\Storage\FileSystemStorage;
// use Vich\UploaderBundle\Storage\GaufretteStorage;



class LivreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Livre::class;
    }


    // public static function getEntityFqcn(): string
    // {
    //     return Utilisateur::class;
    // }

    // private $uploaderHelper;
    // public function __construct(GaufretteStorage $storage)
    // {
    //     $this->uploaderHelper = new UploaderHelper($storage);
    // }
    // private $uploaderHelper;
    // public function __construct()
    // {
    //     $filesystemStorage = new FileSystemStorage(
    //         // Pass any dependencies needed by FileSystemStorage, if applicable
    //     );
    //     $this->uploaderHelper = new UploaderHelper($filesystemStorage);
    // }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('titre'),
            TextField::new('genre'),
            TextField::new('auteur'),
            TextField::new('editeur'),
            'description_livre',
            'date_publication',
            ImageField::new('image_couverture')->setUploadDir('public/images'),

            'fichier',
            // ImageField::new('fichier')->setFormTypeOptions([
            //     'constraints' => [
            //         new \Symfony\Component\Validator\Constraints\File([
            //             'maxSize' => '10M', // Taille maximale du fichier (modifiable selon tes besoins)
            //             'mimeTypes' => [
            //                 'application/pdf', // Type MIME du fichier PDF
            //             ],
            //             'mimeTypesMessage' => 'Veuillez uploader un fichier PDF valide.',
            //         ]),
            //     ],
            // ])->setUploadDir('public/fichiers'),


            // Ajouter une contrainte de type de fichier pour accepter uniquement les fichiers PDF
            
            // 
            // FileField::new('fichier')->setBasePath('public/fichiers')->setFormTypeOptions(['required' => false])
            // TextField::new('fichier', 'Fichier PDF')->formatValue(function ($value, $entity) {
            //     if ($value) {
            //         $downloadLink = $this->uploaderHelper->asset($entity, 'fichier');
            //         return '<a href="'.$downloadLink.'" target="_blank">Télécharger</a>';
            //     }
            //     return '';
            // })  
            
        ];


    // $imageField = ImageField::new('file');

    // // Ajouter une contrainte de type de fichier pour accepter uniquement les fichiers PDF
    // $imageField->setFormTypeOptions([
    //     'constraints' => [
    //     new File([
    //     'maxSize' => '10M', // Taille maximale du fichier (modifiable selon tes besoins)
    //     'mimeTypes' => [
    //         'application/pdf', // Type MIME du fichier PDF
    //     ],
    //     'mimeTypesMessage' => 'Veuillez uploader un fichier PDF valide.',
    //     ]),
    //     ],
    // ]);

// Ajouter le champ dans EasyAdmin
    }
    
}
