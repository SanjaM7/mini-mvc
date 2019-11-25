<?php /** @var  $params */ ?>
<?php if (isset($params['song'])) : ?>
    <?php $song = $params['song'] ?>
    <div class="container">
        <!-- add song form -->
        <h3>Edit a song</h3>
        <div class="box">
            <form action="<?php echo URL; ?>song/updateSong" method="POST">
                <label>Artist</label>
                <input autofocus type="text" name="artist"
                       value="<?php echo htmlspecialchars($song->artist, ENT_QUOTES, 'UTF-8'); ?>" required/>
                <label>Track</label>
                <input type="text" name="track"
                       value="<?php echo htmlspecialchars($song->track, ENT_QUOTES, 'UTF-8'); ?>" required/>
                <label>Link</label>
                <input type="text" name="link"
                       value="<?php echo htmlspecialchars($song->link, ENT_QUOTES, 'UTF-8'); ?>"/>
                <input type="hidden" name="song_id"
                       value="<?php echo htmlspecialchars($song->id, ENT_QUOTES, 'UTF-8'); ?>"/>
                <label>Duration</label>
                <input type="number" name="minutes" style="width:60px" min="0" max="10" step="1"
                       placeholder="min" value="<?php echo htmlspecialchars((int)($song->duration/60) , ENT_QUOTES, 'UTF-8'); ?>" required/>
                <span> : </span>
                <input id="hourInput" type="number" name="seconds" min="0" max="59" step="1"
                       onchange="if(parseInt(this.value,10)<10)this.value='0'+this.value;" style="width:60px"
                       placeholder="sec"/ value="<?php echo htmlspecialchars($song->duration%60, ENT_QUOTES, 'UTF-8'); ?>" required/ >
                <input type="submit" name="submit_update_song" value="Update"/>
            </form>
            <?php require ROOT . 'view/includes/errors.php'; ?>
        </div>
    </div>
<?php endif; ?>
