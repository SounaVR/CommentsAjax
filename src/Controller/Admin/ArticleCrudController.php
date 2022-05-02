<?php

namespace App\Controller\Admin;

use DateTime;
use App\Entity\Article;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('titre'),
            TextareaField::new('contenu'),
            TextField::new('imageFile')->setFormType(VichImageType::class)->hideOnIndex()->hideWhenUpdating()->hideOnDetail(),
            ImageField::new('image')->setBasePath('/images/products')->hideWhenCreating()->setUploadDir('public\images\products'),
            DateTimeField::new('date')->hideOnForm()
        ];
    }

    public function createEntity(string $entityFqcn)
    {
        $article = new Article();
        $article->setUser($this->getUser());
        $article->setDate(new DateTime());

        return $article;
    }
}
