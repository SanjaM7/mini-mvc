<?php

namespace Application\Controllers;

use Application\Libs\PageHelper;
use Application\Libs\SessionHelper;
use Application\Libs\PermissionHelper;
use Application\Models\Playlist;
use Application\Models\Song;
use Illuminate\Routing\Controller;

class PlaylistController extends Controller
{
    public $model;

    public function __construct()
    {
        $this->model = new Playlist();
    }

    public function index()
    {
        $user_id = SessionHelper::getUserId();

        $lastTwoPlaylists = $this->model->getLastTwo('user_id', $user_id);

        PageHelper::displayPage('playlists/index.php');
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
            $duration = $hours*3600 + $minutes*60 + $seconds;
            $this->model->duration = $duration;

            $this->model->save();

            $song = new Song();
            $songs = $song->getAll();

            $this->model->generateRandomPlaylist($songs, $this->model);
        }

        return PageHelper::redirect('playlist/index');
    }
}
