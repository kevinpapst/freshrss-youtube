# FreshRSS - YouTube video extension

This FreshRSS extension allows you to directly watch YouTube videos from within subscribed channel feeds.

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

# Screenshots

With FreshRSS and an original Youtube Channel feed:
![screenshot before](https://github.com/kevinpapst/freshrss-youtube/blob/screenshot-readme/before.png?raw=true "Without this extension the video is not shown")

With activated Youtube extension:
![screenshot after](https://github.com/kevinpapst/freshrss-youtube/blob/screenshot-readme/after.png?raw=true "After activationg the extension you can enjoy your video directly in the FreshRSS stream")

## About FreshRSS
[FreshRSS](https://freshrss.org/) is a great self-hosted RSS Reader written in PHP, which is can also be found here at [GitHub](https://github.com/FreshRSS/FreshRSS).

More extensions can be found at [FreshRSS/Extensions](https://github.com/FreshRSS/Extensions).

## Changelog

0.4: 
* Added option to display original feed content (currently Youtube inserts a download icon link to the video file)
* Fixed config loading
    
0.3: 
* Added installation hints

0.2: 
* Fixed "Use of undefined constant FreshRSS_Context"
