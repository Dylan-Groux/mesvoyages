<?php

namespace App\Entity;

use App\Repository\VisiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Naming\SmartUniqueNamer;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: VisiteRepository::class)]
#[Vich\Uploadable]
class Visite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    ///VICH
    #[Vich\UploadableField(mapping: 'visites', fileNameProperty: 'imageName', size: 'imageSize')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    private ?int $imageSize = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context) {
        $file = $this->getImageFile();
    
        // Vérification de la présence du fichier
        if ($file === null) {
            // Pas d'image fournie, donc ne rien faire (ou une autre action si nécessaire)
            return;
        }
    
        // Vérification de la taille du fichier
        $poids = @filesize($file);
        if ($poids !== false && $poids > 10485760) { // 10 Mo en octets
            $context->buildViolation("Cette image est trop lourde (10Mo max)")
                    ->atPath('imageFile')
                    ->addViolation();
            return; // Sortir de la méthode après avoir ajouté la violation
        }
    
        // Vérification si le fichier est une image
        $infosImage = @getimagesize($file);
        if ($infosImage === false) {
            $context->buildViolation("Ce fichier n'est pas une image !")
                    ->atPath('imageFile')
                    ->addViolation();
        }
    }
    



    #[ORM\Column(length: 50)]
    private ?string $ville = null;

    #[ORM\Column(length: 50)]
    private ?string $pays = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $datecreation = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Range(min: 0, max: 20)]
    private ?int $note = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $avis = null;

    #[ORM\Column(nullable: true)]
    private ?int $tempmin = null;

    #[ORM\Column(nullable: true)]
    #[Assert\GreaterThan(propertyPath:"tempmin")]
    private ?int $tempmax = null;

    /**
     * @var Collection<int, Environnement>
     */
    #[ORM\ManyToMany(targetEntity: Environnement::class)]
    private Collection $environnements;

    public function __construct()
    {
        $this->environnements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): static
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * @Assert\Date
     * @Assert\LessThanOrEqual("today", message="La date de création ne peut pas être dans le futur.")
     */
    public function setDatecreation(?\DateTimeInterface $datecreation): self
    {
        $now = new \DateTime('today');
        if ($datecreation > $now) {
            throw new \InvalidArgumentException("La date de creation ne peut pas être dans le futur.");
        }

        $this->datecreation = $datecreation;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(?int $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getAvis(): ?string
    {
        return $this->avis;
    }

    public function setAvis(?string $avis): static
    {
        $this->avis = $avis;

        return $this;
    }

    public function getTempmin(): ?int
    {
        return $this->tempmin;
    }

    public function setTempmin(?int $tempmin): static
    {
        $this->tempmin = $tempmin;

        return $this;
    }

    public function getTempmax(): ?int
    {
        return $this->tempmax;
    }

    public function setTempmax(?int $tempmax): static
    {
        $this->tempmax = $tempmax;

        return $this;
    }

    public function getDatecreationString() : string
    {
        if($this->datecreation == null) {
            return "";
        }
        else {
            return $this->datecreation->format("d/m/Y");
        }
    }

    public function setDatecreationFromString(string $datecreationString): static
    {
        // Supprime les espaces inutiles
        $datecreationString = trim($datecreationString);
        
        // Si la chaîne est déjà au format Y-m-d, on la transforme en d/m/Y
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $datecreationString)) {
            // Convertit la chaîne du format Y-m-d au format d/m/Y
            $datecreationString = \DateTime::createFromFormat('Y-m-d', $datecreationString)->format('d/m/Y');
        }
    
        // Tentative de création de la date à partir de la chaîne avec le format d/m/Y
        $date = \DateTime::createFromFormat("d/m/Y", $datecreationString);
    
        // Vérifie si la conversion a échoué
        if ($date === false) {
            // Vérifie les erreurs de format
            $errors = \DateTime::getLastErrors();
            
            // Lève une exception avec un message détaillant l'erreur
            throw new \InvalidArgumentException("Le format de la date est invalide. Erreurs: " . implode(", ", $errors['errors']));
        }
    
        // Assigne la valeur de la date si elle est valide
        $this->datecreation = $date;  
    
        return $this;
    }
    
    public function getDatecreation(): ?\DateTimeInterface
    {
        return $this->datecreation;
    }

    /**
     * @return Collection<int, Environnement>
     */
    public function getEnvironnements(): Collection
    {
        return $this->environnements;
    }

    public function addEnvironnement(Environnement $environnement): static
    {
        if (!$this->environnements->contains($environnement)) {
            $this->environnements->add($environnement);
        }

        return $this;
    }

    public function removeEnvironnement(Environnement $environnement): static
    {
        $this->environnements->removeElement($environnement);

        return $this;
    }


    ///VICH GET SET
     public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;
        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }


}

