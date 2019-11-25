<?php /** @var  $params */ ?>
<?php if (isset($params['songs'])) : ?>
    <div class="container">
        <!-- add song form -->
        <h3>Add a song</h3>
        <form action="<?php echo URL; ?>song/addSong" method="POST">
            <label>Artist</label>
            <input type="text" name="artist" value="" required/>
            <label>Track</label>
            <input type="text" name="track" value="" required/>
            <label>Link</label>
            <input type="text" name="link" value=""/>
            <label>Duration</label>
            <input type="number" name="minutes" value="" style="width:60px" min="0" max="10" step="1"
                   placeholder="min" required/>
            <span> : </span>
            <input id="hourInput" type="number" name="seconds" min="0" max="59" step="1"
                   onchange="if(parseInt(this.value,10)<10)this.value='0'+this.value;" value="" style="width:60px"
                   placeholder="sec" required/>
            <input type="submit" name="submit_add_song" value="Submit"/>
        </form>
        <?php require ROOT . 'view/includes/errors.php'; ?>
        <!-- main content output -->
        <div class="box">
            <h3>Count of songs:
                <?php if (isset($params['count_of_songs'])) : ?>
                    <?php $count_of_songs = $params['count_of_songs'] ?>
                    <span>
                    <?php echo $count_of_songs; ?>
                </span>
                <?php endif; ?>
            </h3>
        </div>
        <div class="box">
            <?php $songs = $params['songs'] ?>
            <?php if (empty($songs)) : ?>
                <p>You don't have songs add a new one</p>
            <?php else : ?>
                <h3>List of songs</h3>
                <table class="table table-hover">
                    <thead style="background-color: #ddd; font-weight: bold;">
                    <tr>
                        <td>Id</td>
                        <td>Artist</td>
                        <td>Track</td>
                        <td>Link</td>
                        <td>Duration</td>
                        <td>Deleted</td>
                        <td>SOFT DELETE</td>
                        <td>EDIT</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($songs as $song) : ?>
                        <tr>
                            <td><?php if (isset($song->id)) echo htmlspecialchars($song->id, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php if (isset($song->artist)) echo htmlspecialchars($song->artist, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php if (isset($song->track)) echo htmlspecialchars($song->track, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <?php if (isset($song->link)) : ?>
                                    <a href="<?php echo htmlspecialchars($song->link, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($song->link, ENT_QUOTES, 'UTF-8'); ?></a>
                                <?php endif; ?>
                            </td>
                            <td><?php if (isset($song->duration)) echo htmlspecialchars($song->duration, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php if (isset($song->deleted)) echo htmlspecialchars($song->deleted, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <a href="<?php echo URL . 'song/' . htmlspecialchars($song->id, ENT_QUOTES, 'UTF-8') . '/softDeleteSong'; ?>">soft delete</a>
                            </td>
                            <td>
                                <a href="<?php echo URL . 'song/' . htmlspecialchars($song->id, ENT_QUOTES, 'UTF-8') . '/editSong'; ?>">edit</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
