<?php
$source = isset($_GET['source']) ? htmlspecialchars($_GET['source']) : 'default';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Playing: <?= $source ?> - SRTPFP</title>
    <link href="../static/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="../static/styles/player.css" rel="stylesheet">
</head>
<body>
    <div class="infop-menu" id="contextMenu">
        <div class="context-option">
            <i class="ri-information-line"></i>
            <span>SRTPFP v0.2.0</span>
        </div>
        <div class="context-option">
            <i class="ri-github-fill"></i>
            <a href="https://github.com/mooncast-live/SRTPFP" target="_blank" rel="nofollow">Get it on GitHub</a>
        </div>
        <div class="context-separator"></div>
        <div class="context-option" id="showStats">
            <i class="ri-bar-chart-box-line"></i>
            <span>Stats for nerds</span>
        </div>
    </div>
    <div class="player-master" id="videoData" data-source="<?= $source ?>">
        <video id="flv-player" autoplay class="video-player" width="100%" height="100%"></video>

        <div class="overlay"></div>

        <div class="controls">
            <div class="left-controls">
                <button id="play-pause" class="control-button">
                    <span class="tooltip">Play/Pause</span>
                    <i class="ri-pause-fill"></i>
                </button>
                <div class="volume-container">
                    <button id="volume" class="control-button">
                        <span class="tooltip">Toggle Mute</span>
                        <i class="ri-volume-up-fill"></i>
                    </button>
                    <input id="volume-control" type="range" min="0" max="1" step="0.01" value="1" class="volume-slider">
                </div>
                <div class="live-badge">
                    <span class="live-dot"></span>
                    LIVE
                </div>
            </div>
            <div class="right-controls">
                <button id="clip" class="control-button">
                    <span class="tooltip">Create Clip</span>
                    <i class="ri-clapperboard-fill"></i>
                </button>
                <button id="settings" class="control-button">
                    <span class="tooltip">Settings</span>
                    <i class="ri-settings-3-fill"></i>
                </button>
                <div class="settings-menu" id="settingsMenu">
                    <div class="settings-option" id="qualityOption">
                        Quality: <span class="quality-text">Source</span>
                    </div>
                    <div class="settings-option" id="pipOption">
                        Picture in Picture <i class="ri-picture-in-picture-2-line"></i>
                    </div>
                </div>
                <button id="fullscreen" class="control-button">
                    <span class="tooltip">Fullscreen</span>
                    <i class="ri-fullscreen-fill"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="clip-modal" id="clipModal">
        <div class="clip-modal-content">
            <h3>Create Clip</h3>
            <p>Share your clip with the world!</p>
            <div class="clip-form">
                <input type="text" id="clipName" placeholder="Clip name" class="clip-input">
                <div class="clip-buttons">
                    <button id="cancelClip" class="clip-button cancel">Cancel</button>
                    <button id="saveClip" class="clip-button save">Save Clip</button>
                </div>
            </div>
        </div>
    </div>

    <div class="stats-overlay" id="statsOverlay">
        <div class="stats-header">
            <h3>Stats for nerds</h3>
            <button class="stats-close" id="closeStats">
                <i class="ri-close-line"></i>
            </button>
        </div>
        <div class="stats-content">
            <div class="stats-row">
                <span class="stats-label">Video ID</span>
                <span class="stats-value" id="statsVideoId"><?= $source ?></span>
            </div>
            <div class="stats-row">
                <span class="stats-label">Resolution</span>
                <span class="stats-value" id="statsResolution">-</span>
            </div>
            <div class="stats-row">
                <span class="stats-label">Current / Optimal Res</span>
                <span class="stats-value" id="statsCurrentRes">-</span>
            </div>
            <div class="stats-row">
                <span class="stats-label">Viewport / Frames</span>
                <span class="stats-value" id="statsViewport">-</span>
            </div>
            <div class="stats-row">
                <span class="stats-label">Volume / Normalized</span>
                <span class="stats-value" id="statsVolume">-</span>
            </div>
            <div class="stats-row">
                <span class="stats-label">Connection Speed</span>
                <span class="stats-value" id="statsConnection">-</span>
            </div>
            <div class="stats-row">
                <span class="stats-label">Network Activity</span>
                <span class="stats-value" id="statsNetwork">-</span>
            </div>
            <div class="stats-row">
                <span class="stats-label">Buffer Health</span>
                <span class="stats-value" id="statsBuffer">-</span>
            </div>
        </div>
    </div>

    <script src="../static/vendor/flvjs/flv.min.js"></script>
    <script src="../static/scripts/player.js"></script>
</body>
</html>