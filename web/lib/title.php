<?php

global $title;

function setTitle($newTitle) {
    global $title;
    $title = $newTitle;
}

function getTitle() {
    global $title;
    return $title;
}