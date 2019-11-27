<?php

namespace Application\Models;

/**
 * Class PlaylistSong
 * This class extends model and represents model for playlist_song pivot table
 * @package Application\Models
 */
class PlaylistSong extends Model
{
    /**
     * @var int
     */
    public $playlist_id;
    /**
     * @var int
     */
    public $song_id;

    /**
     * PlaylistSong constructor.
     */
    public function __construct()
    {
        parent::__construct('playlist_song');
    }

    /**
     *
     * Returns playlist and songs data for last three playlists
     * @param $user_id
     *
     * @return array
     */
    public function getLastThreePlaylists($user_id)
    {
        $sql = "SELECT lastThreePlaylists.playlist_id, name, lastThreePlaylists.user_id as user_id, lastThreePlaylists.playlist_duration,
                songs.id as song_id, artist, track, link, songs.user_id as song_owner_id, songs.duration as song_duration
                FROM 
                     (SELECT DISTINCT playlists.id as playlist_id, name, playlists.user_id, playlists.duration as playlist_duration
                      FROM playlists
                      WHERE user_id = :user_id
                      ORDER BY playlist_id DESC LIMIT 3) 
                as lastThreePlaylists
                    
                INNER JOIN playlist_song
                ON lastThreePlaylists.playlist_id = playlist_song.playlist_id
                INNER JOIN songs
                ON playlist_song.song_id = songs.id              
                ";

        $stmt = $this->db->prepare($sql);
        $params = [
            ':user_id' => $user_id,
        ];
        $stmt->execute($params);
        $result = $stmt->fetchAll();
        return $result;
    }
}
