<?php

namespace Application\Models;

class PlaylistViewModel
{
    public $id;
    public $name;
    public $user_id;
    public $duration;
    public $songs;

    public function __construct($playlistSongs)
    {
        $this->id = $playlistSongs[0]->playlist_id;
        $this->name = $playlistSongs[0]->name;
        $this->user_id = $playlistSongs[0]->user_id;
        $this->duration = $playlistSongs[0]->playlist_duration;
        $this->songs = $playlistSongs;
    }
}
