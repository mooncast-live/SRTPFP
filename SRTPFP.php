<?php
$source = isset($_GET['source']) ? htmlspecialchars($_GET['source']) : 'default';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SRTPFP</title>
    <link href="../static/vendor/fontawesome/css/all.min.css" rel="stylesheet">
    <link href="../static/styles/player.css" rel="stylesheet">
</head>
<body>    
	<div id="videoData" data-source="<?= $source ?>"></div>
    <div class="custom-context-menu" id="contextMenu">
        <h3>SRTPFP</h3>
        <p>v0.1.0 Pre-Release</p>
		<p><a href="https://github.com/mooncast-live/SRTPFP" style="color: white!important;" rel="nofollow">Get it here</a></p>
    </div>
    <div class="player-container">
        <video id="flv-player" autoplay class="video-player" width="100%" height="100%"></video>

        <div class="overlay"></div>

        <div class="controls">
            <div class="left-controls">
                <button id="play-pause" class="control-button">
                    <i class="fas fa-pause"></i>
                </button>
				<b style="color: white;"><i class="fa-solid fa-sm fa-circle" style="color: red!important;"></i> LIVE</b>
                <input id="volume-control" type="range" min="0" max="1" step="0.01" value="1" class="volume-slider">
				
            </div>
            <div class="right-controls">
                <button id="fullscreen" class="control-button">
                    <i class="fas fa-expand"></i>
                </button>
            </div>
        </div>
    </div>

    <script src="../static/vendor/flvjs/flv.min.js"></script>
    <script>
     const contextMenu = document.getElementById('contextMenu');

        document.addEventListener('contextmenu', (event) => {
            event.preventDefault();
            const { clientX: mouseX, clientY: mouseY } = event;

            contextMenu.style.left = `${mouseX}px`;
            contextMenu.style.top = `${mouseY}px`;
            contextMenu.style.display = 'block';
        });

        document.addEventListener('click', () => {
            contextMenu.style.display = 'none';
        });

        if (flvjs.isSupported()) {
			const source = document.getElementById('videoData').getAttribute('data-source');
            const videoUrl = `https://YOUR_SERVER_URL/YOUR_KEY/${source}.flv`;
            const player = flvjs.createPlayer({
                type: 'flv',
                url: videoUrl,
            });

            const videoElement = document.getElementById('flv-player');
            player.attachMediaElement(videoElement);
            player.load();

            const playPauseButton = document.getElementById('play-pause');
            playPauseButton.addEventListener('click', function () {
                if (videoElement.paused) {
                    videoElement.play();
                    playPauseButton.innerHTML = '<i class="fas fa-pause"></i>';
                } else {
                    videoElement.pause();
                    playPauseButton.innerHTML = '<i class="fas fa-play"></i>';
                }
            });

            const volumeControl = document.getElementById('volume-control');
            volumeControl.addEventListener('input', function () {
                videoElement.volume = volumeControl.value;
            });

            const fullscreenButton = document.getElementById('fullscreen');
            fullscreenButton.addEventListener('click', function () {
                if (videoElement.requestFullscreen) {
                    videoElement.requestFullscreen();
                } else if (videoElement.mozRequestFullScreen) {
                    videoElement.mozRequestFullScreen();
                } else if (videoElement.webkitRequestFullscreen) {
                    videoElement.webkitRequestFullscreen();
                }
            });
			window.addEventListener('load', () => {
				const video = document.getElementById('flv-player');
				video.muted = true;
				video.play().catch((error) => {
				  console.error('SRTPFP Err:', error);
				});
			});
            player.on('error', function () {
                const playerContainer = document.querySelector('.player-container');
                playerContainer.style.backgroundImage = 'url("../static/media/offline.png")';
                playerContainer.style.backgroundSize = 'cover';
                playerContainer.style.backgroundPosition = 'center';
                document.querySelector('.controls').style.display = 'none'; 
				document.querySelector('.overlay').style.display = 'none'; 
            });
        }
    </script>
</body>
</html>
