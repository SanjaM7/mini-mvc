<?php /** @var  $params */ ?>
<?php if (isset($params['songs'])) : ?>
    <div class="container">
        <!-- add song form -->
        <h3>Add a song</h3>
        <div class="box">
            <form action="<?php echo URL; ?>song/addSong" method="POST">
                <label>Artist</label>
                <input type="text" name="artist" value="" required/>
                <label>Track</label>
                <input type="text" name="track" value="" required/>
                <label>Link</label>
                <input type="text" name="link" value=""/>
                <label>Duration</label>
                <input type="number" name="minutes" value="" style="width:60px" min="0" max="10" step="1" placeholder="min"/>
                <span> : </span>
                <input id="hourInput" type="number" name="seconds" min="1" max="59" step="1" onchange="if(parseInt(this.value,10)<10)this.value='0'+this.value;" value="" style="width:60px" placeholder="sec"/>
                <input type="submit" name="submit_add_song" value="Submit"/>
            </form>
        </div>
        <?php require ROOT . 'view/includes/errors.php'; ?>
        <!-- main content output -->
        <div class="box">
            <?php if (isset($params['count_of_songs'])) : ?>
                <?php $count_of_songs = $params['count_of_songs'] ?>
                <h3>Count of songs</h3>
                <div>
                    <?php echo $count_of_songs; ?>
                </div>
            <?php endif; ?>
            <?php $songs = $params['songs'] ?>
            <?php if (empty($songs)) : ?>
                <p>You don't have songs add a new one</p>
            <?php else : ?>
                <h3>List of songs</h3>
                <table>
                    <thead style="background-color: #ddd; font-weight: bold;">
                    <tr>
                        <td>Id</td>
                        <td>Artist</td>
                        <td>Track</td>
                        <td>Link</td>
                        <td>Duration</td>
                        <td>DELETE</td>
                        <td>EDIT</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($songs as $song) { ?>
                        <tr>
                            <td><?php if (isset($song->id)) echo htmlspecialchars($song->id, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php if (isset($song->artist)) echo htmlspecialchars($song->artist, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php if (isset($song->track)) echo htmlspecialchars($song->track, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <?php if (isset($song->link)) : ?>
                                    <a href="<?php echo htmlspecialchars($song->link, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($song->link, ENT_QUOTES, 'UTF-8'); ?></a>
                                <?php endif; ?>
                            </td>
                            <td><?php if (isset($song->duration)) echo htmlspecialchars((int)($song->duration/60) . ':' . ($song->duration%60), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <a href="<?php echo URL . 'song/' . htmlspecialchars($song->id, ENT_QUOTES, 'UTF-8') . '/deleteSong'; ?>">delete</a>
                            </td>
                            <td>
                                <a href="<?php echo URL . 'song/' . htmlspecialchars($song->id, ENT_QUOTES, 'UTF-8') . '/editSong'; ?>">edit</a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
