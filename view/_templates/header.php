<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>MINI</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- JS -->
    <!-- please note: The JavaScript files are loaded in the footer to speed up page construction -->
    <!-- See more here: http://stackoverflow.com/q/2105327/1114320 -->

    <!-- CSS -->
    <link href="<?php echo URL; ?>css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootswatch/4.3.1/sandstone/bootstrap.min.css">
</head>
<body>
<div id="page-container">
    <div id="content-wrap">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="#">Mini-mvc</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01"
            aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor01">
        <ul class="navbar-nav mr-auto">
            <?php /** @var  $isLoggedIn */ ?>
            <li><a class="btn btn-secondary my-2 my-sm-0 mr-sm-2" href="<?php echo URL; ?>">home</a></li>
            <?php if ($isLoggedIn) : ?>
                <li>
                    <a class="btn btn-secondary my-2 my-sm-0 mr-sm-2"
                       href="<?php echo URL; ?>home/exampleone">subpage</a>
                </li>
                <li>
                    <a class="btn btn-secondary my-2 my-sm-0 mr-sm-2" href="<?php echo URL; ?>home/exampletwo">subpage
                        2</a>
                </li>
                <?php /** @var  $isDj */ ?>
                <?php if ($isDj) : ?>
                    <li>
                        <a class="btn btn-secondary my-2 my-sm-0 mr-sm-2" href="<?php echo URL; ?>song">songs</a>
                    </li>
                <?php endif; ?>
                <?php /** @var  $isAdmin */ ?>
                <?php if ($isAdmin) : ?>
                    <li>
                        <a class="btn btn-secondary my-2 my-sm-0 mr-sm-2" href="<?php echo URL; ?>user/index">users</a>
                    </li>
                    <li>
                        <a class="btn btn-secondary my-2 my-sm-0 mr-sm-2" href="<?php echo URL; ?>role/index">roles</a>
                    </li>
                <?php endif; ?>
            <?php endif; ?>
        </ul>
        <form action="<?php echo URL; ?>song/searchSong" method="POST" class="form-inline my-2 my-lg-0">
            <div style="width:300px;" class="mr-sm-2">
                <input type="text" name="searchName" class="form-control" placeholder="Search song" style="width:100%;">
            </div>
            <button class="btn btn-secondary my-2 my-sm-0 mr-sm-2" type="submit_search_songs">Search</button>
        </form>
        <?php if (!$isLoggedIn) : ?>
            <a href="<?php echo URL; ?>user/register" class="btn btn-secondary my-2 my-sm-0 mr-sm-2"
               type="submit">Register</a>
            <a href="<?php echo URL; ?>user/logIn" class="btn btn-secondary my-2 my-sm-0 mr-sm-2" type="submit">Log
                In</a>
        <?php else : ?>
            <form action="<?php echo URL; ?>user/postLogOut" method="POST">
                <button class="btn btn-danger my-2 my-sm-0" name="submit_log_out" type="submit">Log Out</button>
            </form>
        <?php endif; ?>
    </div>
</nav>



