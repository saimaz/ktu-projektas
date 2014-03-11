<?php
function getPath()
{
    return implode(DIRECTORY_SEPARATOR, func_get_args());
}

function getFullPath()
{
    $parts = array_merge([ dirname(__DIR__)], func_get_args());

    return implode(DIRECTORY_SEPARATOR, $parts);
}