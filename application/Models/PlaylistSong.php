<?php

namespace Application\Models;

class PlaylistSong extends Model
{
    public $id;
    public $playlist_id;
    public $song_id;

    public function __construct()
    {
        parent::__construct('playlist_song');
    }

    public function getLastThreePlaylists($user_id)
    {
        $sql = "SELECT lastThreePlaylists.playlist_id, name, lastThreePlaylists.user_id as user_id, lastThreePlaylists.playlist_duration,
                songs.id as song_id, artist, track, link, songs.user_id as song_owner_id, songs.duration as song_duration
                FROM 
                     (SELECT DISTINCT playlists.id as playlist_id, name, playlists.user_id, playlists.duration as playlist_duration
                      FROM playlists
                      INNER JOIN playlist_song
                      ON playlists.id = playlist_song.playlist_id 
                      WHERE user_id = :user_id
                      ORDER BY playlist_id DESC LIMIT 3) 
                as lastThreePlaylists
                    
                INNER JOIN playlist_song
                ON lastThreePlaylists.playlist_id = playlist_song.playlist_id
                INNER JOIN songs
                ON playlist_song.song_id = songs.id              
                ";

        $stmt = $this->db->prepare($sql);
        $params = array(
            ':user_id' => $user_id,
        );
        $stmt->execute($params);
        $result = $stmt->fetchAll();
        return $result;
    }
}
