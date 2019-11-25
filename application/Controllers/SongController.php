<?php

namespace Application\Controllers;

use Application\Libs\PageHelper;
use Application\Libs\SessionHelper;
use Application\Libs\PermissionHelper;
use Application\Models\Song;
use Illuminate\Routing\Controller;
use Khill\Duration\Duration;

class SongController extends Controller
{
    public $model;

    public function __construct()
    {
        $this->model = new Song();
    }

    public function index()
    {
        PermissionHelper::requireDj();
        $user_id = SessionHelper::getUserId();
        $songs = $this->model->getWhere('user_id', $user_id);
        foreach($songs as $song){
            $song_duration = $song->duration;
            $duration = new Duration("$song_duration");
            $song->duration = $duration->formatted();
        }
        $count_of_songs = $this->model->count();
        $params = array(
            'errors' => array(),
            'songs' => $songs,
            'count_of_songs' => $count_of_songs,
        );

        PageHelper::displayPage('songs/index.php', $params);
    }

    public function searchSong()
    {
        if (!isset($_POST['searchName'])) {
            return PageHelper::redirectBack();
        }

        $searchName = $_POST['searchName'];
        $searches = $this->model->search($searchName, 'artist', 'track');

        if (empty($searchName) && empty($searches)) {
            return PageHelper::redirectBack();
        }

        $params = array(
            'errors' => array(),
            'searches' => $searches,
            'searchName' => $searchName
        );

        return PageHelper::displayPage('songs/search.php', $params);
    }

    public function addSong()
    {
        PermissionHelper::requireDj();
        if (isset($_POST['submit_add_song'])) {
            $user_id = SessionHelper::getUserId();
            $this->model->artist = $_POST['artist'];
            $this->model->track = $_POST['track'];
            $this->model->link = $_POST['link'];
            $this->model->user_id = $user_id;

            $minutes = $_POST['minutes'];
            $seconds = $_POST['seconds'];

            $errors = $this->model->validateSongParams($minutes, $seconds);

            if ($errors) {
                SessionHelper::setErrors($errors);
                return PageHelper::redirect('song/index');
            }

            $duration = new Duration("$minutes:$seconds");
            $this->model->duration = $duration->toSeconds();

            $this->model->save();
        }

        return PageHelper::redirect('song/index');
    }

    public function softDeleteSong($song_id)
    {
        PermissionHelper::requireDj();
        if (isset($song_id)) {
            $user_id = SessionHelper::getUserId();
            $song = $this->model->get($song_id);
            if($song->user_id == $user_id) {
                $this->model->softDelete($song_id);
            }
        }

        return PageHelper::redirect('song/index');
    }

    public function editSong($song_id)
    {
        PermissionHelper::requireDj();
        if (!isset($song_id)) {
            return PageHelper::redirect('song/index');
        }

        $song = $this->model->get($song_id);
        $user_id = SessionHelper::getUserId();

        if ($song->user_id != $user_id) {
            return PageHelper::redirect('song/index');
        }
        $params = array(
            'errors' => array(),
            'song' => $song
        );
        PageHelper::displayPage('songs/edit.php', $params);

    }

    public function updateSong()
    {
        PermissionHelper::requireDj();
        if (isset($_POST['submit_update_song'])) {
            $user_id = SessionHelper::getUserId();
            $this->model->id = $_POST['song_id'];
            $this->model->artist = $_POST['artist'];
            $this->model->track = $_POST['track'];
            $this->model->link = $_POST['link'];
            $this->model->user_id = $user_id;
            $minutes = $_POST['minutes'];
            $seconds = $_POST['seconds'];

            $errors = $this->model->validateSongParams($minutes, $seconds);

            if ($errors) {
                SessionHelper::setErrors($errors);
                return PageHelper::redirect('song/' . $this->model->id . '/editSong');
            }

            $duration = new Duration("$minutes:$seconds");
            $this->model->duration = $duration->toSeconds();

            $this->model->update();
        }

        return PageHelper::redirect('song/index');
    }
}
