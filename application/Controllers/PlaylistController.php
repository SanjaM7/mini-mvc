<?php

namespace Application\Controllers;

use Application\Libs\PageHelper;
use Application\Libs\SessionHelper;
use Application\Libs\PermissionHelper;
use Application\Models\Playlist;
use Application\Models\PlaylistSong;
use Application\Models\PlaylistViewModel;
use Application\Models\Song;
use Illuminate\Routing\Controller;
use Khill\Duration\Duration;

class PlaylistController extends Controller
{
    public $model;

    public function __construct()
    {
        $this->model = new Playlist();
        PermissionHelper::requireAuthorized();
    }

    public function index()
    {
        $user_id = SessionHelper::getUserId();
        $playlistSong = new PlaylistSong();
        $lastThreePlaylists = $playlistSong->getLastThreePlaylists($user_id);
        $playlistViewModels = $this->mapToPlaylistView($lastThreePlaylists);
        $params = array(
            'playlists' => $playlistViewModels,
            'errors' => array()
        );

        PageHelper::displayPage('playlists/index.php', $params);
    }

    public function addPlaylist()
    {
        if(isset($_POST['submit_generate_playlist'])){
            $this->model->name = $_POST['name'];
            $user_id = SessionHelper::getUserId();
            $this->model->user_id = $user_id;
            $hours = $_POST['hours'];
            $minutes = $_POST['minutes'];
            $seconds = $_POST['seconds'];

            $errors = $this->model->validatePlaylistParams($hours, $minutes, $seconds);
            if ($errors) {
                SessionHelper::setErrors($errors);
                return PageHelper::redirect('playlist/index');
            }

            $duration = new Duration("$hours:$minutes:$seconds");
            $duration = $duration->toSeconds();
            $this->model->duration = $duration;

            $this->model->generatePlaylist();
        }

        return PageHelper::redirect('playlist/index');
    }

    private function mapToPlaylistView($playlists)
    {
        $playlistIds = array_column($playlists, "playlist_id");
        $uniquePlaylistIds = array_unique($playlistIds);
        $playlistViewModels = array();
        foreach ($uniquePlaylistIds as $uniquePlaylistId){
            $playlistViewModel = new PlaylistViewModel();

            $filterFunc = function($playlistSong) use($uniquePlaylistId){
                return $playlistSong->playlist_id === $uniquePlaylistId;
            };

            $playlistSongs = array_values(array_filter($playlists, $filterFunc));

            $playlistViewModel->id = $playlistSongs[0]->playlist_id;
            $playlistViewModel->name = $playlistSongs[0]->name;
            $playlistViewModel->user_id = $playlistSongs[0]->user_id;

            $playlist_duration = $playlistSongs[0]->playlist_duration;
            $duration = new Duration("$playlist_duration");
            $playlistViewModel->duration = $duration->formatted();

            $playlistViewModel->songs = $playlistSongs;
            foreach($playlistViewModel->songs as $playlistViewModel->song){
                $song_duration = $playlistViewModel->song->song_duration;
                $duration = new Duration("$song_duration");
                $playlistViewModel->song->song_duration = $duration->formatted();
            }

            $playlistViewModels[] = $playlistViewModel;
        }

        return $playlistViewModels;
    }
}
