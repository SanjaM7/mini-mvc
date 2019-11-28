<?php

namespace Application\Controllers;

use Application\Libs\PageHelper;
use Application\Libs\SessionHelper;
use Application\Libs\PermissionHelper;
use Application\Models\Song;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Khill\Duration\Duration;

/**
 * Class SongController
 * This Controller handles working with songs: processing input data, executing logic and loading corresponding views
 * @package Application\Controllers
 */
class SongController extends Controller
{
    /**
     * @var object Song
     */
    public $model;

    /**
     * SongController constructor.
     */
    public function __construct()
    {
        $this->model = new Song();
    }

    /**
     * This method loads view with songs for logged user
     * @return void
     */
    public function index()
    {
        PermissionHelper::requireDj();
        $user_id = SessionHelper::getUserId();
        $songs = $this->model->getWhere('user_id', $user_id);
        foreach($songs as $song){
            $song_duration = $song->duration;
            $duration = new Duration($song_duration);
            $song->duration = $duration->formatted();
        }
        $count_of_songs = $this->model->count();
        $params = [
            'errors' => [],
            'songs' => $songs,
            'count_of_songs' => $count_of_songs,
        ];

        PageHelper::displayPage('songs/index.php', $params);
    }

    /**
     * This method is responsible for doing the search for song based on artist or track
     * @return RedirectResponse|void
     */
    public function searchSong()
    {
        $searchName = $_POST['searchName'];

        if (!isset($searchName)) {
            return PageHelper::redirectBack();
        }

        $searches = $this->model->search($searchName, 'artist', 'track');

        if (empty($searchName) && empty($searches)) {
            return PageHelper::redirectBack();
        }

        $params = [
            'errors' => [],
            'searches' => $searches,
            'searchName' => $searchName
        ];

        return PageHelper::displayPage('songs/search.php', $params);
    }

    /**
     * This method handles adding song
     * @return RedirectResponse
     */
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

            $duration = new Duration($minutes . ':' . $seconds);
            $this->model->duration = $duration->toSeconds();

            $this->model->save();
        }

        return PageHelper::redirect('song/index');
    }

    /**
     * This method handles soft deleting song
     * @param int|null $song_id
     *
     * @return RedirectResponse
     */
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

    /**
     * This method handles editing song
     * @param int $song_id
     *
     * @return RedirectResponse|void
     */
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
        $params = [
            'errors' => [],
            'song' => $song
        ];
        PageHelper::displayPage('songs/edit.php', $params);
    }

    /**
     * This method handles updating song
     * @return RedirectResponse
     */
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

            $errors = $this->model->validateSongParams($_POST['minutes'], $_POST['seconds']);

            if ($errors) {
                SessionHelper::setErrors($errors);
                return PageHelper::redirect('song/' . $this->model->id . '/editSong');
            }

            $duration = new Duration($_POST['minutes'] . ':' . $_POST['seconds']);
            $this->model->duration = $duration->toSeconds();

            $this->model->update();
        }

        return PageHelper::redirect('song/index');
    }
}
