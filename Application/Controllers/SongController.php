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
        if(!$this->model->get()){
            die();
        }
        $songs = $this->model->result;
        $amount_of_songs = $this->model->count;
        require APP . 'view/_templates/header.php';
        require APP . 'view/songs/index.php';
        require APP . 'view/_templates/footer.php';
    }
    /*
    public function deleteSong($song_id)
    {
        if (isset($song_id)) {
            $this->model->delete($song_id);
        }

        header('location: ' . URL . 'song/index');
    }
    */

    public function deleteSong($song_id)
    {
        if (isset($song_id)) {
            $this->model->delete(array('id', '=', $song_id));
        }

        header('location: ' . URL . 'song/index');
    }

    public function addSong()
    {
        if (isset($_POST["submit_add_song"])) {
            $params = array (
                "artist" => $_POST["artist"],
                "track" => $_POST["track"],
                "link" => $_POST["link"]
            );
            $this->model->create($params);
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
