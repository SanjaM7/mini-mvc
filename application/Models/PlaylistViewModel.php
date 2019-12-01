<?php

namespace Application\Models;

use Khill\Duration\Duration;

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
        $this->setPlaylistDurationFormatted($playlistSongs[0]->playlist_duration);
        $this->setPlaylistSongDurationFormatted($playlistSongs);
        $this->songs = $playlistSongs;
    }

    public function setPlaylistDurationFormatted($playlist_duration)
    {
        $duration = new Duration($playlist_duration);
        $this->duration = $duration->formatted();
    }

    public function setPlaylistSongDurationFormatted($playlistSongs)
    {
        foreach($playlistSongs as $playlistSong){
            $duration = new Duration($playlistSong->song_duration);
            $playlistSong->song_duration = $duration->formatted();
        }
    }
}
