<?php

class YouTubeExtension extends Minz_Extension
{
    public static $width = 560;
    public static $height = 315;

    public function init()
    {
        $this->registerHook(
            'entry_before_display',
            array($this, 'embedYouTubeVideo')
        );
        $this->loadConfigValues();
    }

    protected function loadConfigValues()
    {
        if (FreshRSS_Context::$user_conf->yt_player_width != '') {
            self::$width = FreshRSS_Context::$user_conf->yt_player_width;
        }
        if (FreshRSS_Context::$user_conf->yt_player_height != '') {
            self::$height = FreshRSS_Context::$user_conf->yt_player_height;
        }
    }

    /**
     * @param FreshRSS_Entry $entry
     * @return mixed
     */
    public function embedYouTubeVideo($entry)
    {
        $this->loadConfigValues();
        $link = $entry->link();

        if (stripos($link, 'www.youtube.com/watch?v=') === false) {
            return $entry;
        }

        $id = str_replace('http://www.youtube.com/watch?v=', '', $link);
        $id = str_replace('https://www.youtube.com/watch?v=', '', $id);

        $entry->_content(
            '<iframe width="'.self::$width.'" height="'.self::$height.'" src="https://www.youtube.com/embed/' .
            $id .
            '" frameborder="0" allowfullscreen></iframe>' .
            $entry->content()
        );

        return $entry;
    }

    public function handleConfigureAction()
    {
        $this->loadConfigValues();
        $this->registerTranslates();

        if (Minz_Request::isPost()) {
            FreshRSS_Context::$user_conf->yt_player_height = (int)Minz_Request::param('yt_height', '');
            FreshRSS_Context::$user_conf->yt_player_width = (int)Minz_Request::param('yt_width', '');
            FreshRSS_Context::$user_conf->save();
        }
    }
}
