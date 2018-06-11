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
    protected $width = 560;
    /**
     * Video player height
     * @var int
     */
    protected $height = 315;
    /**
     * Whether we display the original feed content
     * @var bool
     */
    protected $showContent = false;
    /**
     * Switch to enable the Youtube No-Cookie domain
     * @var bool
     */
    protected $useNoCookie = false;

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
     * Do not call that in your extensions init() method, it can't be used there.
     */
    public function loadConfigValues()
    {
        if (!class_exists('FreshRSS_Context', false) || null === FreshRSS_Context::$user_conf) {
            return;
        }

        if (FreshRSS_Context::$user_conf->yt_player_width != '') {
            $this->width = FreshRSS_Context::$user_conf->yt_player_width;
        }
        if (FreshRSS_Context::$user_conf->yt_player_height != '') {
            $this->height = FreshRSS_Context::$user_conf->yt_player_height;
        }
        if (FreshRSS_Context::$user_conf->yt_show_content != '') {
            $this->showContent = (bool)FreshRSS_Context::$user_conf->yt_show_content;
        }
        if (FreshRSS_Context::$user_conf->yt_nocookie != '') {
            $this->useNoCookie = (bool)FreshRSS_Context::$user_conf->yt_nocookie;
        }
    }

    /**
     * Returns the width in pixel for the youtube player iframe.
     * You have to call loadConfigValues() before this one, otherwise you get default values.
     *
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Returns the height in pixel for the youtube player iframe.
     * You have to call loadConfigValues() before this one, otherwise you get default values.
     *
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Returns whether this extensions displays the content of the youtube feed.
     * You have to call loadConfigValues() before this one, otherwise you get default values.
     *
     * @return bool
     */
    public function isShowContent()
    {
        return $this->showContent;
    }

    /**
     * Inserts the YouTube video iframe into the content of an entry, if the entries link points to a YouTube watch URL.
     *
     * @param FreshRSS_Entry $entry
     * @return mixed
     */
    public function embedYouTubeVideo($entry)
    {
        $link = $entry->link();

        if (stripos($link, 'www.youtube.com/watch?v=') === false and stripos($link, 'videos/watch/') === false) {
            return $entry;
        }

        $this->loadConfigValues();

        if (stripos($entry->content(), '<iframe class="youtube-plugin-video"') !== false) {
            return $entry;
        }
        if (stripos($link, 'www.youtube.com/watch?v=') !== false) {
            $html = $this->getIFrameForLink($link);
        }
        else{ //peertube
            $html = $this->getPeerTubeIFrameForLink($link);
        }
        if ($this->showContent) {
            $html .= $entry->content();
        }

        $entry->_content($html);

        return $entry;
    }

    /**
     * Returns an HTML <iframe> for a given Youtube watch URL (www.youtube.com/watch?v=)
     *
     * @param string $link
     * @return string
     */
    public function getIFrameForLink($link)
    {
        $domain = 'www.youtube.com';
        if ($this->useNoCookie) {
            $domain = 'www.youtube-nocookie.com';
        }
        $url = str_replace('//www.youtube.com/watch?v=', '//'.$domain.'/embed/', $link);
        $url = str_replace('http://', 'https://', $url);

        $html = $this->getIFrameHtml($url);

        return $html;
    }

    /**
    * Returns an HTML <iframe> for a given PeerTube watch URL
    *
    * @param string $link
    * @return string
    */
    public function getPeerTubeIFrameForLink($link)
    {
        $url = str_replace('/watch', '/embed', $link);
        $html = $this->getIFrameHtml($url);
        
        return $html;
    }

    /**
     * Returns an HTML <iframe> for a given URL for the configured width and height.
     *
     * @param string $url
     * @return string
     */
    public function getIFrameHtml($url)
    {
        return '<iframe class="youtube-plugin-video"
                style="height: ' . $this->height . 'px; width: ' . $this->width . 'px;" 
                width="' . $this->width . '" 
                height="' . $this->height . '" 
                src="' . $url . '" 
                frameborder="0" 
                allowfullscreen></iframe>';
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
            FreshRSS_Context::$user_conf->yt_show_content = (int)Minz_Request::param('yt_show_content', 0);
            FreshRSS_Context::$user_conf->yt_nocookie = (int)Minz_Request::param('yt_nocookie', 0);
            FreshRSS_Context::$user_conf->save();
        }
    }
}
