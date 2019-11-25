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

    public function validateSongParams($minutes, $seconds)
    {
        $errors = array();
        if (empty($this->artist)) {
            $errors[] = 'Enter Artist';
        }
        if (empty($this->track)) {
            $errors[] = 'Enter track';
        }
        if (!is_numeric($minutes)) {
            $errors[] = 'Enter minutes';
        }
        if (!is_numeric($seconds)) {
            $errors[] = 'Enter seconds';
        }
        return $errors;
    }
}
