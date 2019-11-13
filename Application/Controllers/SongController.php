<?php

namespace Application\Controllers;

use Application\Models\Song;

class SongController
{
    public $model;

    public function __construct()
    {
        //$songModelClassName = "Application\\Models\\Song";
        //$this->song = new $songModelClassName();
        //require APP . 'Models/Song.php';
        $this->model = new Song();
    }

    public function index()
    {
        $songs = $this->model->getAll();
        $amount_of_songs = $this->model->count();
        require APP . 'view/_templates/header.php';
        require APP . 'view/songs/index.php';
        require APP . 'view/_templates/footer.php';
    }

    public function deleteSong($song_id)
    {
        if (isset($song_id)) {
            $this->model->delete($song_id);
        }

        header('location: ' . URL . 'song/index');
    }

    public function addSong()
    {
        if (isset($_POST["submit_add_song"])) {
            $song = new Song();
            $song->artist = $_POST["artist"];
            $song->track = $_POST["track"];
            $song->link = $_POST["link"];
            $this->model->add($song);
        }

        header('location: ' . URL . 'song/index');
    }

    public function editSong($song_id)
    {
        if (isset($song_id)) {
            $song = $this->model->getSong($song_id);

            require APP . 'view/_templates/header.php';
            require APP . 'view/songs/edit.php';
            require APP . 'view/_templates/footer.php';
        } else {
            header('location: ' . URL . 'song/index');
        }
    }

    public function updateSong()
    {
        if (isset($_POST["submit_update_song"])) {
            $this->repository->updateSong($_POST["artist"], $_POST["track"],  $_POST["link"], $_POST['song_id']);
        }

        header('location: ' . URL . 'song/index');
    }

    public function ajaxGetStats()
    {
        $amount_of_songs = $this->repository->getAmountOfSongs();

        // simply echo out something. A supersimple API would be possible by echoing JSON here
        echo $amount_of_songs;
    }


}
