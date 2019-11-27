<?php

namespace Application\Models;

/**
 * Class PlaylistViewModel
 * This class is only for view playlist and its songs
 * @package Application\Models
 */
class PlaylistViewModel
{
    /**
     * @var int
     */
    public $id;
    /**
     * @var string
     */
    public $name;
    /**
     * @var int
     */
    public $user_id;
    /**
     * @var mixed
     */
    public $duration;
    /**
     * @var array
     */
    public $songs;

    /**
     * PlaylistViewModel constructor.
     *
     * @param array $playlistSongs
     */
    public function __construct($playlistSongs)
    {
        $this->id = $playlistSongs[0]->playlist_id;
        $this->name = $playlistSongs[0]->name;
        $this->user_id = $playlistSongs[0]->user_id;
        $this->duration = $playlistSongs[0]->playlist_duration;
        $this->songs = $playlistSongs;
    }
}
