<?php /** @var  $params */ ?>
<div class="container">
    <!-- add playlist form -->
    <h3>Generate random playlist</h3>
    <form action="<?php echo URL; ?>playlist/addPlaylist" method="POST">
        <label>Playlist name: </label>
        <input type="text" name="name" value="" required/>
        <label>Duration: </label>
        <input type="number" name="hours" value="" min="0" max="23" step="1" placeholder="hours" required/>
        <span> : </span>
        <input type="number" name="minutes" value="" style="width:60px" min="0" max="59" step="1" placeholder="min" required/>
        <span> : </span>
        <input type="number" name="seconds" value="" style="width:60px" min="0" max="59" step="1" placeholder="sec"
               onchange="if(parseInt(this.value,10)<10)this.value='0'+this.value;"/>
        <input type="submit" name="submit_generate_playlist" value="Submit" required/>
    </form>
    <?php require ROOT . 'view/includes/errors.php'; ?>
    <!-- main content output -->
    <?php $playlists = $params['playlists'] ?>
    <?php if (!empty($playlists)) : ?>
        <div class="box">
            <h3>Last three playlists</h3>
            <?php foreach ($playlists as $playlist) : ?>
                <table class="table table-dark m-0">
                    <tr>
                        <th><b>Playlist Id: </b>
                            <?php if (isset($playlist->id)) echo htmlspecialchars($playlist->id, ENT_QUOTES, 'UTF-8'); ?>
                        </th>
                        <th><b>Playlist Name: </b>
                            <?php if (isset($playlist->name)) echo htmlspecialchars($playlist->name, ENT_QUOTES, 'UTF-8'); ?>
                        </th>
                        <th><b>Playlist User Id: </b>
                            <?php if (isset($playlist->user_id)) echo htmlspecialchars($playlist->user_id, ENT_QUOTES, 'UTF-8'); ?>
                        </th>
                        <th><b>Playlist Duration: </b>
                            <?php if (isset($playlist->duration)) echo htmlspecialchars($playlist->duration, ENT_QUOTES, 'UTF-8'); ?>
                        </th>
                    </tr>
                </table>
                <table class="table table-hover mt-0">
                    <thead style="background-color: #ddd; font-weight: bold;">
                    <tr>
                        <td>Song Id</td>
                        <td>Artist</td>
                        <td>Track</td>
                        <td>Link</td>
                        <td>Song Owner Id</td>
                        <td>Song Duration</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($playlist->songs as $playlist->song) : ?>
                        <tr>
                            <td><?php if (isset($playlist->song->song_id)) echo htmlspecialchars($playlist->song->song_id, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php if (isset($playlist->song->artist)) echo htmlspecialchars($playlist->song->artist, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php if (isset($playlist->song->track)) echo htmlspecialchars($playlist->song->track, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php if (isset($playlist->song->link)) echo htmlspecialchars($playlist->song->link, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php if (isset($playlist->song->song_owner_id)) echo htmlspecialchars($playlist->song->song_owner_id, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php if (isset($playlist->song->song_duration)) echo htmlspecialchars($playlist->song->song_duration, ENT_QUOTES, 'UTF-8'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>


