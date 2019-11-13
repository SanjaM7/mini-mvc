<?php

namespace Application\Models;

class Song extends Model
{
    public $id;
    public $artist;
    public $track;
    public $link;

    public function __construct(){
        parent::__construct('songs');

    }


}
