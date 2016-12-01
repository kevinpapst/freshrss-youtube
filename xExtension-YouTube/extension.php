<?php

class YouTubeExtension extends Minz_Extension
{
    public function init()
    {
        $this->registerHook(
            'entry_before_display',
            array('YouTubeExtension', 'embedYouTubeVideo')
        );
    }

    public static function embedYouTubeVideo(FreshRSS_Entry $entry)
    {
        $link = $entry->link();

        if (stripos('www.youtube.com/watch?v=') === false) {
            return $entry;
        }

        $id = str_replace('http://www.youtube.com/watch?v=', '', $link);
        $id = str_replace('https://www.youtube.com/watch?v=', '', $id);

        $entry->_content(
            '<iframe width="560" height="315" src="https://www.youtube.com/embed/' .
            $id .
            '" frameborder="0" allowfullscreen></iframe>' .
            $entry->content()
        );

        return $entry;
    }
}
