<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Music Viewer</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link href="viewer.css" type="text/css" rel="stylesheet" />
</head>
<body>
<?php

$playlist = (isset($_REQUEST["playlist"]))?$_REQUEST["playlist"]:NULL;

$shuffle = (isset($_REQUEST["shuffle"]))?$_REQUEST["shuffle"]:NULL;

function songSize($musicSize) {
    if($musicSize > 0 && $musicSize < 1024){
        return $musicSize . " b";
    }
    elseif ($musicSize > 1023 && $musicSize < 1048576){
        return round($musicSize/1024, 2) . " kb";
    }
    elseif ($musicSize > 1048577) {
        return round($musicSize/1048576, 2) . " mb";
    }
}

?>
<div id="header">

    <p><a href="music.php">Main Page</a>    <a href="music.php?shuffle=on">Shuffle</a></p>


    <h1>190M Music Playlist Viewer</h1>
    <h2>Search Through Your Playlists and Music</h2>
</div>


<div id="listarea">
    <ul id="musiclist">

        <?php
        if($playlist)
        {
            $tracks = file("songs/$playlist", FILE_IGNORE_NEW_LINES);
        }
        else if($shuffle)
        {
            $tracks = glob("songs/*.mp3");
            shuffle($tracks);
        }
        else
        {
            $tracks = glob("songs/*.mp3");
        }

        foreach ($tracks as $track) {
            if(strstr($track, ".mp3")){
                ?>
                <li class="mp3item" ><a href="<?= 'songs/'.basename($track)?> "> <?= basename($track) ?></a> (<?= songSize(musicSize("songs/". basename($track))) ?>)</li>
            <?php } }

        $use = glob("songs/*.m3u");
        if(!($playlist))
        {
            foreach ($use as $track) {
                ?>
                <li class="playlistitem" ><a href="music.php?playlist=<?= basename($track)?>"> <?= basename($track) ?>   </a> </li>
            <?php  } ?>
        <?php} ?>
    </ul>
</div>
</body>
</html>