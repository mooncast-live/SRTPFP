<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/static/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="/static/styles/info.css">
    <title>SRTPFP - Simple Real-Time Progressive FLV Player</title>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>SRTPFP</h1>
            <p class="subtitle">Simple Real-Time Progressive FLV Player</p>
        </div>

        <div class="info-card">
            <div class="server-info">
                <h2><i class="ri-server-line"></i> Server Information</h2>
                <div class="info-row">
                    <span>Version</span>
                    <span class="highlight">v0.2.0 Stable</span>
                </div>
                <div class="info-row">
                    <span>Status</span>
                    <span class="status-badge">
                        <span class="status-dot"></span>
                        Online
                    </span>
                </div>
                <div class="info-row">
                    <span>Server Time</span>
                    <span class="highlight"><?php echo date('Y-m-d H:i:s'); ?></span>
                </div>
            </div>
        </div>

        <div class="actions">
            <a href="https://github.com/mooncast-live/SRTPFP" class="action-button" target="_blank">
                <i class="ri-github-fill"></i>
                Get it on GitHub
            </a>
            <a href="https://github.com/mooncast-live/SRTPFP/blob/main/Setup.md" class="action-button secondary" target="_blank">
                <i class="ri-book-2-fill"></i>
                Documentation
            </a>
        </div>

        <div class="features">
            <div class="feature-card">
                <i class="ri-speed-fill"></i>
                <h3>Low Latency</h3>
                <p>Optimized for real-time streaming with minimal delay</p>
            </div>
            <div class="feature-card">
                <i class="ri-tools-fill"></i>
                <h3>Easy Setup</h3>
                <p>Simple configuration and deployment process</p>
            </div>
            <div class="feature-card">
                <i class="ri-code-box-fill"></i>
                <h3>Open Source</h3>
                <p>Free and open source under MIT license</p>
            </div>
        </div>
    </div>
</body>
</html>
