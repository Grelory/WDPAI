<?php

class Project {

    public $title;
    public $description;
    public $photoUrl;

    public function __construct() {
    }

    public function getTitle() : string {
        return $this->title;
    }

    public function getDescription() : string {
        return $this->description;
    }

    public function getPhotoUrl() : string {
        return $this->photoUrl;
    }
}