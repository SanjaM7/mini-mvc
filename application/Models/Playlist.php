<?php

namespace Application\Models;

use Application\Libs\SessionHelper;
use Khill\Duration\Duration;

/**
 * Class Playlist
 * This class extends model and represents playlist record from database
 * @package Application\Models
 */
class Playlist extends Model
{
    /**
     * @var string
     */
    public $name;
    /**
     * @var int
     */
    public $user_id;
    /**
     * @var int
     */
    public $duration;

    /**
     * Playlist constructor.
     */
    public function __construct(){
        parent::__construct('playlists');
    }

    /**
     * Validates playlist parameters
     * @param int $hours
     * @param int $minutes
     * @param int $seconds
     *
     * @return string[]
     */
    public function validatePlaylistParams($hours, $minutes, $seconds)
    {
        $errors = [];
        if (empty($this->name) || strlen($this->name) > 20) {
            $errors[] = 'Invalid Name';
        }
        if (!is_numeric($hours)) {
            $errors[] = 'Invalid hours';
        }
        if (!is_numeric($minutes)) {
            $errors[] = 'Invalid minutes';
        }
        if (!is_numeric($seconds)) {
            $errors[] = 'Invalid seconds';
        }
        return $errors;
    }

    public function setDurationToSeconds($hours, $minutes, $seconds)
    {
        $duration = new Duration($hours . ':' . $minutes . ':' . $seconds);
        $this->duration = $duration->toSeconds();
    }

    /**
     * Generate playlist
     * @return void
     */
    public function generatePlaylist()
    {
        $songs = $this->getSongs();
        $sameSongsIds = $this->getSameSongIds();
        $this->generateNoRepeatPlaylist($songs, $sameSongsIds);
    }

    /**
     * Returns all songs which haven't been deleted
     * @return Song[]
     */
    private function getSongs()
    {
        $song = new Song();
        $songs = $song->getWhere('deleted', 0);
        return $songs;
    }

    /**
     * Returns array of same song ids from last two playlists
     * @return int[]
     */
    private function getSameSongIds()
    {
        $lastTwoPlaylists = $this->getLastTwo('user_id', $this->user_id);
        if(count($lastTwoPlaylists) != 2){
            return [];
        }
        $playlistSong = new PlaylistSong();
        $lastPlaylist = $playlistSong->getWhere('playlist_id', $lastTwoPlaylists[0]->id);
        $secondToLastPlaylist = $playlistSong->getWhere('playlist_id', $lastTwoPlaylists[1]->id);
        $secondToLastPlaylistSongIds = array_column($secondToLastPlaylist, 'song_id');
        $lastPlaylistSongIds = array_column($lastPlaylist, 'song_id');
        $sameSongsIds = array_intersect($secondToLastPlaylistSongIds, $lastPlaylistSongIds);
        return $sameSongsIds;
    }

    /**
     * Removes songs with same id's and passes filtered array
     * @param Song[] $songs
     * @param int[] $sameSongsIds
     * @return void
     */
    private function generateNoRepeatPlaylist($songs, $sameSongsIds)
    {
        $filterFunc = function($song) use ($sameSongsIds){
            return !in_array($song->id, $sameSongsIds);
        };
        $filtered = array_filter($songs, $filterFunc);

        $this->generateRandomPlaylist($filtered);
    }

    /**
     * Saves the playlist and picks a random song and saves it
     * @param Song[] $songs
     @return void
     */
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
