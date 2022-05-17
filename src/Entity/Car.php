<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use App\Repository\CarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Entity(repositoryClass=CarRepository::class)
 * @Vich\Uploadable
 */
class Car
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="The field ""brand"" should not be blank !")
     * @Assert\Regex(
     *     pattern="/\w/",
     *     match=true,
     *     message="Please enter a valid brand"
     * )
     */
    private $brand;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex(
     *     pattern="/\w/",
     *     match=true,
     *     message="Please enter a valid model"
     * )
     */
    private $model;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Regex("/^[0-9]{4}$/")
     */
    private $year;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex(
     * pattern="/\w/",
     * match=true,
     * message="Please enter a valid engine"
     * )
     */
    private $engine;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $color;

    /**
     * @ORM\ManyToMany(targetEntity=EnergyOption::class, inversedBy="car")
     */
    private $energyOptions;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $km;

    /**
     * @ORM\ManyToOne(targetEntity=Seat::class, inversedBy="cars")
     */
    private $seat;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="cars", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    private $last_update_at;

    /**
     * @ORM\ManyToOne(targetEntity=TypeOfSale::class, inversedBy="cars")
     */
    private $typeOfSale;

    
    public function __construct()
    {
        $this->energyOptions = new ArrayCollection();
    }


    public function getSlug(): string
    {
        return (new Slugify())->slugify($this->brand . " " . $this->model);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(?string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(?string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getEngine(): ?string
    {
        return $this->engine;
    }

    public function setEngine(string $engine): self
    {
        $this->engine = $engine;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return Collection<int, EnergyOption>
     */
    public function getEnergyOptions(): Collection
    {
        return $this->energyOptions;
    }

    public function addEnergyOption(EnergyOption $energyOption): self
    {
        if (!$this->energyOptions->contains($energyOption)) {
            $this->energyOptions[] = $energyOption;
            $energyOption->addCar($this);
        }

        return $this;
    }

    public function removeEnergyOption(EnergyOption $energyOption): self
    {
        if ($this->energyOptions->removeElement($energyOption)) {
            $energyOption->removeCar($this);
        }

        return $this;
    }

    public function getKm(): ?int
    {
        return $this->km;
    }

    public function setKm(?int $km): self
    {
        $this->km = $km;

        return $this;
    }


    public function getSeat(): ?Seat
    {
        return $this->seat;
    }

    public function setSeat(?Seat $seat): self
    {
        $this->seat = $seat;

        return $this;
    }



    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->last_update_at = new \DateTime('now');
        }
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getLastUpdateAt(): ?\DateTimeInterface
    {
        return $this->last_update_at;
    }

    public function setLastUpdateAt(?\DateTimeInterface $last_update_at): self
    {
        $this->last_update_at = $last_update_at;

        return $this;
    }

    public function getTypeOfSale(): ?TypeOfSale
    {
        return $this->typeOfSale;
    }

    public function setTypeOfSale(?TypeOfSale $typeOfSale): self
    {
        $this->typeOfSale = $typeOfSale;

        return $this;
    }
}
