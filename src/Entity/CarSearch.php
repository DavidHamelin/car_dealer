<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class CarSearch
{

    /**
     * @var ArrayCollection
     */
    private $energyOption;

    /**
     * @var ArrayCollection
     */
    private $seat;

    
    /**
     * @var integer
     */
    private $km;



    public function __construct()
    {
        $this->energyOption = new ArrayCollection();
        $this->seat = new ArrayCollection();
    }

    /**
     * Get the value of energyOption
     *
     * @return ArrayCollection
     */
    public function getEnergyOption()
    {
        return $this->energyOption;
    }

    /**
     * Set the value of energyOption
     *
     * @param ArrayCollection $energyOption
     *
     * @return self
     */
    public function setEnergyOption(int $energyOption): ArrayCollection
    {
        $this->energyOption = $energyOption;
        return $this;
    }


    /**
     * Get the value of seat
     *
     * @return ArrayCollection
     */
    public function getSeat()
    {
        return $this->seat;
    }

    /**
     * Set the value of seat
     *
     * @param ArrayCollection $seat
     *
     * @return self
     */
    public function setSeat(int $seat): ArrayCollection
    {
        $this->seat = $seat;
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
}
