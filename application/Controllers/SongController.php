<?php

namespace Application\Controllers;

use Application\Libs\PageHelper;
use Application\Models\Song;

class SongController
{
    public $model;

    public function __construct()
    {
        $this->model = new Song();
    }

    public function index()
    {
        $songs = $this->model->getAll();
        $amount_of_songs = $this->model->count();
        $params = array(
            'songs' => $songs,
            'amount_of_songs' => $amount_of_songs
        );
        PageHelper::displayPage("songs/index.php", $params);
    }

    public function addSong()
    {
        if (isset($_POST["submit_add_song"])) {
            $this->model->artist = $_POST["artist"];
            $this->model->track = $_POST["track"];
            $this->model->link = $_POST["link"];
            $this->model->save();
        }

        header('location: ' . URL . 'song/index');
    }

    public function deleteSong($song_id)
    {
        if (isset($song_id)) {
            $this->model->delete($song_id);
        }

        header('location: ' . URL . 'song/index');
    }

    public function updateSong()
    {
        if (isset($_POST["submit_update_song"])) {
            $this->model->id = $_POST['song_id'];
            $this->model->artist = $_POST["artist"];
            $this->model->track = $_POST['track'];
            $this->model->link = $_POST['link'];
            $this->model->update();
        }

        header('location: ' . URL . 'song/index');
    }

    public function editSong($song_id)
    {
        if (isset($song_id)) {
            $song = $this->model->get($song_id);
            PageHelper::displayPage("songs/edit.php", $params = array('song' => $song));
        } else {
            header('location: ' . URL . 'song/index');
        }
    }
/*
    public function ajaxGetStats()
    {
        $amount_of_songs = $this->model->getAmountOfSongs();

        // simply echo out something. A supersimple API would be possible by echoing JSON here
        echo $amount_of_songs;
    }
*/
}
