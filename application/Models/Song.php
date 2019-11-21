<?php

namespace Application\Models;

class Song extends Model
{
    public $id;
    public $artist;
    public $track;
    public $link;
    public $user_id;
    public $duration;

    public function __construct(){
        parent::__construct('songs');

    }
}
