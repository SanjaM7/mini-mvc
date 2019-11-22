<?php

namespace Application\Models;

class Playlist extends Model
{
    public $id;
    public $name;
    public $user_id;
    public $duration;

    public function __construct(){
        parent::__construct('playlists');
    }

    public function generateRandomPlaylist($songs, $playlist){

        $playlist_id = $playlist->id;

        $durationSum = 0;
        $song_duration = 0;

        while($durationSum < $playlist->duration){
            $randomSongId = rand(0,count($songs));
            $song = $songs[$randomSongId];
            $song_id = $song->id;

            $song_duration = $song->duration;
            $durationSum += $song_duration;

            var_dump($song_duration);
            if($durationSum < $playlist->duration){
                $this->storePlaylistSong($playlist_id, $song_id);
            }
        }
    }

    public function storePlaylistSong($playlist_id, $song_id){
        $sql = "INSERT INTO playlist_song (playlist_id, song_id) VALUES (:playlist_id, :song_id);";
        $stmt = $this->db->prepare($sql);
        $params = array (
            ":playlist_id" => $playlist_id,
            ":song_id" => $song_id
        );
        $stmt->execute($params);
    }
}
