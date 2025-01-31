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
    const videoUrl = `https://YOUR_SERVER_URL/${source}.flv`;
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
            playPauseButton.innerHTML = '<span class="tooltip">Play/Pause</span><i class="ri-pause-fill"></i>';
        } else {
            videoElement.pause();
            playPauseButton.innerHTML = '<span class="tooltip">Play/Pause</span><i class="ri-play-fill"></i>';
        }
    });

    const volumeButton = document.getElementById('volume');
    const volumeControl = document.getElementById('volume-control');
    const volumeContainer = document.querySelector('.volume-container');

    volumeControl.addEventListener('input', function () {
        videoElement.volume = volumeControl.value;
        updateVolumeIcon(volumeControl.value);
    });

    volumeContainer.addEventListener('wheel', function(e) {
        e.preventDefault();
        
        const currentVolume = parseFloat(volumeControl.value);
        let newVolume = currentVolume;
        
        if (e.deltaY < 0) {
            newVolume = Math.min(1, currentVolume + 0.05);
        } else {
            newVolume = Math.max(0, currentVolume - 0.05);
        }
        
        volumeControl.value = newVolume;
        videoElement.volume = newVolume;
        updateVolumeIcon(newVolume);
    });

    volumeButton.addEventListener('click', function() {
        if (videoElement.volume > 0) {
            videoElement.volume = 0;
            volumeControl.value = 0;
            updateVolumeIcon(0);
        } else {
            videoElement.volume = 1;
            volumeControl.value = 1;
            updateVolumeIcon(1);
        }
    });

    function updateVolumeIcon(value) {
        if (value === 0) {
            volumeButton.innerHTML = '<span class="tooltip">Toggle Mute</span><i class="ri-volume-mute-fill"></i>';
        } else if (value < 0.5) {
            volumeButton.innerHTML = '<span class="tooltip">Toggle Mute</span><i class="ri-volume-down-fill"></i>';
        } else {
            volumeButton.innerHTML = '<span class="tooltip">Toggle Mute</span><i class="ri-volume-up-fill"></i>';
        }
    }

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
        const playerContainer = document.querySelector('.player-master');
        playerContainer.style.backgroundImage = 'url("../static/media/offline.png")';
        playerContainer.style.backgroundSize = 'cover';
        playerContainer.style.backgroundPosition = 'center';
        document.querySelector('.controls').style.display = 'none'; 
        document.querySelector('.overlay').style.display = 'none'; 
    });

    const settingsButton = document.getElementById('settings');
    const settingsMenu = document.getElementById('settingsMenu');
    const pipOption = document.getElementById('pipOption');
    const qualityOption = document.getElementById('qualityOption').querySelector('.quality-text');

    settingsButton.addEventListener('click', function(e) {
        e.stopPropagation();
        settingsMenu.classList.toggle('active');
    });

    document.addEventListener('click', function(e) {
        if (!settingsMenu.contains(e.target) && e.target !== settingsButton) {
            settingsMenu.classList.remove('active');
        }
    });

    videoElement.addEventListener('loadedmetadata', function() {
        const height = videoElement.videoHeight;
        qualityOption.textContent = `${height}p`;
        startRecording();
    });

    pipOption.addEventListener('click', async function() {
        try {
            if (document.pictureInPictureElement) {
                await document.exitPictureInPicture();
            } else {
                await videoElement.requestPictureInPicture();
            }
        } catch (error) {
            console.error('Error:', error);
        }
    });

    videoElement.addEventListener('enterpictureinpicture', function() {
        pipOption.innerHTML = 'Exit Picture in Picture <i class="ri-picture-in-picture-exit-line"></i>';
    });

    videoElement.addEventListener('leavepictureinpicture', function() {
        pipOption.innerHTML = 'Picture in Picture <i class="ri-picture-in-picture-2-line"></i>';
    });

    const clipButton = document.getElementById('clip');
    const clipModal = document.getElementById('clipModal');
    const cancelClipButton = document.getElementById('cancelClip');
    const saveClipButton = document.getElementById('saveClip');
    const clipNameInput = document.getElementById('clipName');

    let mediaRecorder;
    let recordedChunks = [];
    let isRecording = false;

    function startRecording() {
        const stream = videoElement.captureStream();
        mediaRecorder = new MediaRecorder(stream, {
            mimeType: 'video/webm;codecs=vp8,opus'
        });

        mediaRecorder.addEventListener('dataavailable', function(e) {
            recordedChunks.push(e.data);
            if (recordedChunks.length > 30) {
                recordedChunks.shift();
            }
        });

        mediaRecorder.start(1000);
        isRecording = true;
    }

    clipButton.addEventListener('click', function() {
        clipModal.classList.add('active');
        clipNameInput.focus();
    });

    cancelClipButton.addEventListener('click', function() {
        clipModal.classList.remove('active');
        clipNameInput.value = '';
    });

    saveClipButton.addEventListener('click', async function() {
        const clipName = clipNameInput.value.trim() || 'clip';
        const blob = new Blob(recordedChunks, {
            type: 'video/webm'
        });

        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.style.display = 'none';
        a.href = url;
        a.download = `${clipName}.webm`;
        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(url);
        document.body.removeChild(a);
        clipModal.classList.remove('active');
        clipNameInput.value = '';
    });

    clipModal.addEventListener('click', function(e) {
        if (e.target === clipModal) {
            clipModal.classList.remove('active');
            clipNameInput.value = '';
        }
    });

    const statsOverlay = document.getElementById('statsOverlay');
    const showStats = document.getElementById('showStats');
    const closeStats = document.getElementById('closeStats');
    const statsResolution = document.getElementById('statsResolution');
    const statsCurrentRes = document.getElementById('statsCurrentRes');
    const statsViewport = document.getElementById('statsViewport');
    const statsVolume = document.getElementById('statsVolume');
    const statsConnection = document.getElementById('statsConnection');
    const statsNetwork = document.getElementById('statsNetwork');
    const statsBuffer = document.getElementById('statsBuffer');

    showStats.addEventListener('click', function() {
        statsOverlay.classList.add('active');
        contextMenu.style.display = 'none';
        updateStats();
    });

    closeStats.addEventListener('click', function() {
        statsOverlay.classList.remove('active');
    });

    function updateStats() {
        if (!statsOverlay.classList.contains('active')) return;

        statsResolution.textContent = `${videoElement.videoWidth}x${videoElement.videoHeight}`;
        statsCurrentRes.textContent = `${videoElement.width}x${videoElement.height} / ${videoElement.videoWidth}x${videoElement.videoHeight}`;
        statsViewport.textContent = `${window.innerWidth}x${window.innerHeight} @ ${Math.round(videoElement.getVideoPlaybackQuality().totalVideoFrames / videoElement.currentTime)}fps`;
        statsVolume.textContent = `${Math.round(videoElement.volume * 100)}% / ${videoElement.volume.toFixed(2)}`;
        
        if (player.statistics && player.statistics.speed) {
            statsConnection.textContent = `${(player.statistics.speed / 1024 / 1024).toFixed(2)} Mbps`;
            statsNetwork.textContent = `${(player.statistics.totalBytes / 1024 / 1024).toFixed(2)}MB`;
            statsBuffer.textContent = `${(player.statistics.bufferSize / 1024 / 1024).toFixed(2)}MB`;
        }

        requestAnimationFrame(updateStats);
    }
}