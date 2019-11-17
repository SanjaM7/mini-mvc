<?php

namespace Application\Controllers;

use Application\Libs\PageHelper;
use Application\Libs\SessionHelper;
use Application\Libs\PermissionHelper;
use Application\Models\Song;

class SongController
{
    public $model;

    public function __construct()
    {
        $this->model = new Song();
        PermissionHelper::requireDj();
    }

    public function index()
    {
        $user_id = SessionHelper::getUserId();
        $songs = $this->model->getWhere('user_id', $user_id);

        $count_of_songs = $this->model->count();
        $params = array(
            'songs' => $songs,
            'count_of_songs' => $count_of_songs
        );
        PageHelper::displayPage('songs/index.php', $params);
    }

    public function addSong()
    {
        $user_id = SessionHelper::getUserId();
        if (isset($_POST['submit_add_song'])) {
            $this->model->artist = $_POST['artist'];
            $this->model->track = $_POST['track'];
            $this->model->link = $_POST['link'];
            $this->model->user_id = $user_id;
            $this->model->save();
        }

        PageHelper::redirect('song/index');
    }

    public function deleteSong($song_id)
    {
        if (isset($song_id)) {
            $song = $this->model->get($song_id);
            $user_id = SessionHelper::getUserId();
            if($song->user_id == $user_id){
                $this->model->delete($song_id);
            } else {
                PageHelper::redirect('song/index');
            }
        }

        PageHelper::redirect('song/index');
    }

    public function editSong($song_id)
    {
        if (isset($song_id)) {
            $song = $this->model->get($song_id);

            $user_id = SessionHelper::getUserId();
            if($song->user_id == $user_id){
                PageHelper::displayPage('songs/edit.php', $params = array('song' => $song));
            } else {
                PageHelper::redirect('song/index');
            }
        } else {
            PageHelper::redirect('song/index');
        }
    }

    public function updateSong()
    {
        $user_id = SessionHelper::getUserId();
        if (isset($_POST['submit_update_song'])) {
            $this->model->id = $_POST['song_id'];
            $this->model->artist = $_POST['artist'];
            $this->model->track = $_POST['track'];
            $this->model->link = $_POST['link'];
            $this->model->user_id = $user_id;
            $this->model->update();
        }

        PageHelper::redirect('song/index');
    }



}
