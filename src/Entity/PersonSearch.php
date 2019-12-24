<?php

namespace App\Entity;

Class PersonSearch {
    /**
     * @var String | null
     */
    private $nom;
    /**
     * @var String | null
     */
    private $prenom;
    
    

    /**
     * Get | null
     *
     * @return  String
     */ 
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set | null
     *
     * @param  String  $prenom  | null
     *
     * @return  self
     */ 
    public function setPrenom(String $prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get | null
     *
     * @return  String
     */ 
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set | null
     *
     * @param  String  $nom  | null
     *
     * @return  self
     */ 
    public function setNom(String $nom)
    {
        $this->nom = $nom;

        return $this;
    }
}