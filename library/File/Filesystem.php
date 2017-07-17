<?php

namespace Guild\File;


class Filesystem
{
    /**
     * Scan dir for files
     *
     * @param $directory
     * @return array
     */
    public function getDirContent($directory)
    {
        return array_diff(scandir(getcwd().$directory), array('..', '.'));
    }
}