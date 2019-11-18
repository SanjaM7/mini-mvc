<?php /** @var  $params */ ?>
<?php if (isset($params['searches'])) : ?>
    <?php if (empty($params['searches']) && empty($params['searchName'])) : ?>
        <p>Enter something to search</p>
    <?php else : ?>
        <?php $songs = $params['searches'] ?>
        <div class="container">
        <?php if (isset($params['searchName'])) : ?>
            <span><b>You have search for: </b></span>
            <?= $params['searchName']; ?>
        <?php endif; ?>
            <?php if(empty($songs)) : ?>
                <p>No result match your search</p>
            <?php else : ?>
            <h3>List of songs</h3>
            <table>
                <thead style="background-color: #ddd; font-weight: bold;">
                <tr>
                    <td>Id</td>
                    <td>Artist</td>
                    <td>Track</td>
                    <td>Link</td>
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
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>
