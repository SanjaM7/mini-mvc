<?php

namespace Application\Controllers;

use Application\Libs\PageHelper;
use Application\Libs\SessionHelper;
use Application\Libs\PermissionHelper;
use Application\Models\Playlist;
use Application\Models\PlaylistSong;
use Application\Models\PlaylistViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;

/**
 * Class PlaylistController
 * This Controller handles working with playlists: processing input data, executing logic and loading corresponding views
 * @package Application\Controllers
 */
class PlaylistController extends Controller
{
    /**
     * @var object Playlist
     */
    public $model;

    /**
     * PlaylistController constructor.
     * Creates a new playlist instance
     * @param Playlist $playlist
     */
    public function __construct(Playlist $playlist)
    {
        $this->model = $playlist;
        PermissionHelper::requireAuthorized();
    }

    /**
     * This method shows last three playlists for logged user
     * @param PlaylistSong $playlistSong
     * @return void
     */
    public function index(PlaylistSong $playlistSong)
    {
        $user_id = SessionHelper::getUserId();
        $lastThreePlaylists = $playlistSong->getLastThreePlaylists($user_id);
        $playlistViewModels = $this->mapToPlaylistViewModel($lastThreePlaylists);
        $params = [
            'playlists' => $playlistViewModels,
            'errors' => []
        ];

        PageHelper::displayPage('playlists/index.php', $params);
    }

    /**
     * This method generates playlist and saves it
     * @return RedirectResponse
     */
    public function addPlaylist()
    {
        if(isset($_POST['submit_generate_playlist'])){
            $this->model->name = $_POST['name'];
            $user_id = SessionHelper::getUserId();
            $this->model->user_id = $user_id;

            $errors = $this->model->validatePlaylistParams($_POST['hours'], $_POST['minutes'], $_POST['seconds']);
            if ($errors) {
                SessionHelper::setErrors($errors);
                return PageHelper::redirect('playlist/index');
            }

            $this->model->setDurationToSeconds($_POST['hours'], $_POST['minutes'], $_POST['seconds']);
            $this->model->generatePlaylist();
        }

        return PageHelper::redirect('playlist/index');
    }

    /**
     * This method maps PlaylistViewModel
     * @param array $playlists
     *
     * @return playlistViewModel[]
     */
    private function mapToPlaylistViewModel($playlists)
    {
        $playlistIds = array_column($playlists, "playlist_id");
        $uniquePlaylistIds = array_unique($playlistIds);
        $playlistViewModels = [];
        foreach ($uniquePlaylistIds as $uniquePlaylistId){
            /**
             * @param object
             * @return bool
             */
            $filterFunc = function($playlistSong) use($uniquePlaylistId){
                return $playlistSong->playlist_id === $uniquePlaylistId;
            };

            $playlistSongs = array_values(array_filter($playlists, $filterFunc));

            $playlistViewModel = new PlaylistViewModel($playlistSongs);
            $playlistViewModels[] = $playlistViewModel;
        }

        return $playlistViewModels;
    }
}
