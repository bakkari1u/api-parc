<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JardinRepository")
 */
class Jardin
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nameParcGarden;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="integer")
     */
    private $zipCode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $state;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $typeGardenParc;

    /**
     * @ORM\Column(type="boolean" , nullable=true)
     */
    private $animauxAccept;

    /**
     * @ORM\Column(type="string", length=500 , nullable=true)
     */
    private $descriptive;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nameOwner;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $fax;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $emailAdress;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $area;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $dateTime;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $averageDurationVisit;

    /**
     * @ORM\Column(type="string", length=100000, nullable=true)
     */
    private $photo;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $webSite;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $facebook;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $remarkableLabel;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $disabilityAccessibility;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $typeVisit;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $Historical;

    /**
     * @ORM\Column(type="integer" )
     */
    private $note = 0;

    /**
     * @ORM\Column(type="float" ,  nullable=true)
     */
    private $latitude;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $longitude;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNameParcGarden()
    {
        return $this->nameParcGarden;
    }

    /**
     * @param mixed $nameParcGarden
     */
    public function setNameParcGarden($nameParcGarden): void
    {
        $this->nameParcGarden = $nameParcGarden;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address): void
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * @param mixed $zipCode
     */
    public function setZipCode($zipCode): void
    {
        $this->zipCode = $zipCode;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state): void
    {
        $this->state = $state;
    }

    /**
     * @return mixed
     */
    public function getTypeGardenParc()
    {
        return $this->typeGardenParc;
    }

    /**
     * @param mixed $typeGardenParc
     */
    public function setTypeGardenParc($typeGardenParc): void
    {
        $this->typeGardenParc = $typeGardenParc;
    }

    /**
     * @return mixed
     */
    public function getAnimauxAccept()
    {
        return $this->animauxAccept;
    }

    /**
     * @param mixed $animauxAccept
     */
    public function setAnimauxAccept($animauxAccept): void
    {
        $this->animauxAccept = $animauxAccept;
    }

    /**
     * @return mixed
     */
    public function getDescriptive()
    {
        return $this->descriptive;
    }

    /**
     * @param mixed $descriptive
     */
    public function setDescriptive($descriptive): void
    {
        $this->descriptive = $descriptive;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city): void
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getNameOwner()
    {
        return $this->nameOwner;
    }

    /**
     * @param mixed $nameOwner
     */
    public function setNameOwner($nameOwner): void
    {
        $this->nameOwner = $nameOwner;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * @param mixed $fax
     */
    public function setFax($fax): void
    {
        $this->fax = $fax;
    }

    /**
     * @return mixed
     */
    public function getEmailAdress()
    {
        return $this->emailAdress;
    }

    /**
     * @param mixed $emailAdress
     */
    public function setEmailAdress($emailAdress): void
    {
        $this->emailAdress = $emailAdress;
    }

    /**
     * @return mixed
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * @param mixed $area
     */
    public function setArea($area): void
    {
        $this->area = $area;
    }

    /**
     * @return mixed
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }

    /**
     * @param mixed $dateTime
     */
    public function setDateTime($dateTime): void
    {
        $this->dateTime = $dateTime;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getAverageDurationVisit()
    {
        return $this->averageDurationVisit;
    }

    /**
     * @param mixed $averageDurationVisit
     */
    public function setAverageDurationVisit($averageDurationVisit): void
    {
        $this->averageDurationVisit = $averageDurationVisit;
    }

    /**
     * @return mixed
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param mixed $photo
     */
    public function setPhoto($photo): void
    {
        $this->photo = $photo;
    }

    /**
     * @return mixed
     */
    public function getWebSite()
    {
        return $this->webSite;
    }

    /**
     * @param mixed $webSite
     */
    public function setWebSite($webSite): void
    {
        $this->webSite = $webSite;
    }

    /**
     * @return mixed
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * @param mixed $facebook
     */
    public function setFacebook($facebook): void
    {
        $this->facebook = $facebook;
    }

    /**
     * @return mixed
     */
    public function getRemarkableLabel()
    {
        return $this->remarkableLabel;
    }

    /**
     * @param mixed $remarkableLabel
     */
    public function setRemarkableLabel($remarkableLabel): void
    {
        $this->remarkableLabel = $remarkableLabel;
    }

    /**
     * @return mixed
     */
    public function getDisabilityAccessibility()
    {
        return $this->disabilityAccessibility;
    }

    /**
     * @param mixed $disabilityAccessibility
     */
    public function setDisabilityAccessibility($disabilityAccessibility): void
    {
        $this->disabilityAccessibility = $disabilityAccessibility;
    }

    /**
     * @return mixed
     */
    public function getTypeVisit()
    {
        return $this->typeVisit;
    }

    /**
     * @param mixed $typeVisit
     */
    public function setTypeVisit($typeVisit): void
    {
        $this->typeVisit = $typeVisit;
    }

    /**
     * @return mixed
     */
    public function getHistorical()
    {
        return $this->Historical;
    }

    /**
     * @param mixed $Historical
     */
    public function setHistorical($Historical): void
    {
        $this->Historical = $Historical;
    }

    /**
     * @return mixed
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param mixed $note
     */
    public function setNote($note): void
    {
        $this->note = $note;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(?string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(?string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }



}
