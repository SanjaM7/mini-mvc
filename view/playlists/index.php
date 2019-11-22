<?php /** @var  $params */ ?>
<?php /*if (isset($params['playlists'])) : */?>
    <div class="container">
        <!-- add playlist form -->
        <h3>Generate random playlist</h3>
        <div class="box">
            <form action="<?php echo URL; ?>playlist/addPlaylist" method="POST">
                <label>Playlist name</label>
                <input type="text" name="name" value="" required/>
                <label>Duration</label>
                <input type="number" name="hours" value="" style="width:60px" min="0" max="23" step="1" placeholder="hour"/>
                <input type="number" name="minutes" value="" style="width:60px" min="0" max="59" step="1" placeholder="min"/>
                <span> : </span>
                <input id="hourInput" type="number" name="seconds" min="0" max="59" step="1"
                       onchange="if(parseInt(this.value,10)<10)this.value='0'+this.value;"
                       value="" style="width:60px" placeholder="sec"/>
                <input type="submit" name="submit_generate_playlist" value="Submit"/>
            </form>
        </div>
    </div>
<?php /*endif; */?>
