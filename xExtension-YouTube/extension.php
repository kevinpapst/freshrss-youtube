<?php

/**
 * Class YouTubeExtension
 *
 * Latest version can be found at https://github.com/kevinpapst/freshrss-youtube
 *
 * @author Kevin Papst
 */
class YouTubeExtension extends Minz_Extension
{
    /**
     * Video player width
     * @var int
     */
    public static $width = 560;
    /**
     * Video player height
     * @var int
     */
    public static $height = 315;

    /**
     * Initialize this extension
     */
    public function init()
    {
        $this->registerHook('entry_before_display', array($this, 'embedYouTubeVideo'));
        $this->registerTranslates();
    }

    /**
     * Initializes the extension configuration, if the user context is available.
     */
    protected function loadConfigValues()
    {
        if (null === FreshRSS_Context || null === FreshRSS_Context::$user_conf) {
            return;
        }

        if (FreshRSS_Context::$user_conf->yt_player_width != '') {
            self::$width = FreshRSS_Context::$user_conf->yt_player_width;
        }
        if (FreshRSS_Context::$user_conf->yt_player_height != '') {
            self::$height = FreshRSS_Context::$user_conf->yt_player_height;
        }
    }

    /**
     * Inserts the YouTube video iframe into the content of an entry, if the entries link points to a YouTube watch URL.
     *
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

        $url = str_replace('//www.youtube.com/watch?v=', '//www.youtube.com/embed/', $link);
        $url = str_replace('http://', 'https://', $url);

        $entry->_content(
            '<iframe width="' . self::$width . '" height="' . self::$height . '" src="' . $url .
            '" frameborder="0" allowfullscreen></iframe>' .
            $entry->content()
        );

        return $entry;
    }

    /**
     * Saves the user settings for this extension.
     */
    public function handleConfigureAction()
    {
        $this->loadConfigValues();

        if (Minz_Request::isPost()) {
            FreshRSS_Context::$user_conf->yt_player_height = (int)Minz_Request::param('yt_height', '');
            FreshRSS_Context::$user_conf->yt_player_width = (int)Minz_Request::param('yt_width', '');
            FreshRSS_Context::$user_conf->save();
        }
    }
}
