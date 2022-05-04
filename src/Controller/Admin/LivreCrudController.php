<?php
namespace App\Controller\Admin;

use DateTime;
use App\Entity\Livre;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

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
            TextareaField::new('synopsis'),
            TextField::new('imageFile')->setFormType(VichImageType::class)->hideOnIndex()->hideWhenUpdating()->hideOnDetail(),
            ImageField::new('image')->setBasePath('/images/livres')->hideWhenCreating()->setUploadDir('public\images\products'),
            DateTimeField::new('date')->hideOnForm()
        ];
    }

    public function createEntity(string $entityFqcn)
    {
        $livre = new Livre();
        $livre->setUser($this->getUser());
        $livre->setDate(new DateTime());

        return $livre;
    }
}
