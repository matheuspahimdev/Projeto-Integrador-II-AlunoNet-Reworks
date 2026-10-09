<?php

global $title;

function setTitle(string $newTitle) {
    global $title;
    $title = $newTitle;
}

function getTitle() {
    global $title;
    return $title;
}