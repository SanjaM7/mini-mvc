<?php

namespace Application\Models;

use Application\Libs\SessionHelper;

class Playlist extends Model
{
    public $id;
    public $name;
    public $user_id;
    public $duration;

    public function __construct(){
        parent::__construct('playlists');
    }

   public function validatePlaylistParams($hours, $minutes, $seconds)
    {
        $errors = array();
        if (empty($this->name)) {
            $errors[] = 'Enter Name';
        }
        if (!is_numeric($hours)) {
            $errors[] = 'Enter hours';
        }
        if (!is_numeric($minutes)) {
            $errors[] = 'Enter minutes';
        }
        if (!is_numeric($seconds)) {
            $errors[] = 'Enter seconds';
        }
        return $errors;
    }

    public function generatePlaylist()
    {
        $songs = $this->getSongs();
        $sameSongsIds = $this->getSameSongIds();
        $this->generateNoRepeatPlaylist($songs, $sameSongsIds);
    }

    private function getSongs()
    {
        $song = new Song();
        $songs = $song->getWhere('deleted', 0);
        return $songs;
    }

    private function getSameSongIds()
    {
        $lastTwoPlaylists = $this->getLastTwo('user_id', $this->user_id);
        if(count($lastTwoPlaylists) != 2){
            return array();
        }
        $playlistSong = new PlaylistSong();
        $lastPlaylist = $playlistSong->getWhere('playlist_id', $lastTwoPlaylists[0]->id);
        $secondToLastPlaylist = $playlistSong->getWhere('playlist_id', $lastTwoPlaylists[1]->id);
        $secondToLastPlaylistSongIds = array_column($secondToLastPlaylist, 'song_id');
        $lastPlaylistSongIds = array_column($lastPlaylist, 'song_id');
        $sameSongsIds = array_intersect($secondToLastPlaylistSongIds, $lastPlaylistSongIds);
        return $sameSongsIds;
    }

    private function generateNoRepeatPlaylist($songs, $sameSongsIds)
    {
        $filterFunc = function($song) use ($sameSongsIds){
            return !in_array($song->id, $sameSongsIds);
        };
        $filtered = array_filter($songs, $filterFunc);

        $this->generateRandomPlaylist($filtered);
    }

    private function generateRandomPlaylist($songs)
    {
        $this->save();
        $playlistDuration = 0;

        while(count($songs) > 0){
            $songs = array_values($songs);
            $randomSongIndex = rand(0,count($songs)-1);
            $song = $songs[$randomSongIndex];

            $playlistDuration += $song->duration;
            if($playlistDuration >= $this->duration){
                break;
            }
            $playlistSong = new PlaylistSong();
            $playlistSong->playlist_id = $this->id;
            $playlistSong->song_id = $song->id;


            $playlistSong->save();
            unset($songs[$randomSongIndex]);
        }
    }
}
