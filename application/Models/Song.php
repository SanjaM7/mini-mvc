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
        $errors = [];
        if (empty($this->artist) || strlen($this->artist) > 60) {
            $errors[] = 'Invalid Artist';
        }
        if (empty($this->track) || strlen($this->track) > 60) {
            $errors[] = 'Invalid track';
        }
        if (!is_numeric($minutes)) {
            $errors[] = 'Invalid minutes';
        }
        if (!is_numeric($seconds)) {
            $errors[] = 'Invalid seconds';
        }
        return $errors;
    }
}
