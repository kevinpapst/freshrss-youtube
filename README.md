# FreshRSS - YouTube video extension

This FreshRSS extension allows you to directly watch YouTube/PeerTube videos from within subscribed channel feeds.

To use it, upload the ```xExtension-YouTube``` directory to the FreshRSS `./extensions` directory on your server and enable it on the extension panel in FreshRSS.

## Installation

The first step is to put the extension into your FreshRSS extension directory:
```
cd /var/www/FreshRSS/extensions/
wget https://github.com/kevinpapst/freshrss-youtube/archive/master.zip
unzip master.zip
mv freshrss-youtube-master/xExtension-YouTube .
rm -rf freshrss-youtube-master/
```

Then switch to your browser https://localhost/FreshRSS/p/i/?c=extension and activate it.

# Features

- Embeds Youtube videos directly in FreshRSS, instead of linking to the Youtube page
- Simplifies the subscription to channel URLs by automatically detecting the channels feed URL

You can simply add Youtube video subscriptions by pasting URLs like:
- `https://www.youtube.com/channel/UCwbjxO5qQTMkSZVueqKwxuw` 
- `https://www.youtube.com/user/AndrewTrials`

## Screenshots

With FreshRSS and an original Youtube Channel feed:
![screenshot before](https://github.com/kevinpapst/freshrss-youtube/blob/screenshot-readme/before.png?raw=true "Without this extension the video is not shown")

With activated Youtube extension:
![screenshot after](https://github.com/kevinpapst/freshrss-youtube/blob/screenshot-readme/after.png?raw=true "After activationg the extension you can enjoy your video directly in the FreshRSS stream")

## About FreshRSS

[FreshRSS](https://freshrss.org/) is a great self-hosted RSS Reader written in PHP, which is can also be found here at [GitHub](https://github.com/FreshRSS/FreshRSS).

More extensions can be found at [FreshRSS/Extensions](https://github.com/FreshRSS/Extensions).

## Changelog

0.10:
* Enhance feed content formatting when included.
* Enhance YouTube URL matching.

0.9:
* Set the extension level at "user" (**users must re-enable the extension**)
* Fix calls to unset configuration variables
* Register translations when extension is disabled

0.8:
* Automatically convert channel and username URLs to feed URLs

0.7:
* Support for PeerTube feed

0.6: 
* Support cookie-less domain www.youtube-nocookie.com for embedding 

0.5: 
* Opened "API" for external usage

0.4: 
* Added option to display original feed content (currently Youtube inserts a download icon link to the video file)
* Fixed config loading
    
0.3: 
* Added installation hints

0.2: 
* Fixed "Use of undefined constant FreshRSS_Context"
