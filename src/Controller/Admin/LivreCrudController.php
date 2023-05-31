<?php

namespace App\Controller\Admin;

use App\Entity\Livre;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
// use EasyCorp\Bundle\EasyAdminBundle\Field\FileField;


class LivreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Livre::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('titre'),
            TextField::new('genre'),
            TextField::new('auteur'),
            TextField::new('editeur'),
            TextEditorField::new('description_livre'),
            DateTimeField::new('date_publication'),
            ImageField::new('image_couverture')->setUploadDir('public/images'),
            'fichier'
            // FileField::new('fichier')->setBasePath('public/fichiers')->setFormTypeOptions(['required' => false])
            
            
            
            
            
            
        ];
    }
    
}
