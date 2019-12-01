<?php

namespace Application\Models;

use Khill\Duration\Duration;

/**
 * Class Song
 * This class extends model and represents song record from database
 * @package Application\Models
 */
class Song extends Model
{
    /**
     * @var string
     */
    public $artist;
    /**
     * @var string
     */
    public $track;
    /**
     * @var string
     */
    public $link;
    /**
     * @var int id
     */
    public $user_id;
    /**
     * @var mixed
     */
    public $duration;

    /**
     * Song constructor.
     */
    public function __construct(){
        parent::__construct('songs');
    }

    /**
     * Validates song parameters
     * @param int $minutes
     * @param int $seconds
     *
     * @return string[]
     */
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

    public function setDurationFormatted()
    {
        $duration = new Duration($this->duration);
        $this->duration = $duration->formatted();
    }

    public function setDurationToSeconds($minutes, $seconds)
    {
        $duration = new Duration($minutes . ':' . $seconds);
        $this->duration = $duration->toSeconds();
    }
}
