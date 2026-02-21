<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watch Live - RoarZone</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/clappr@latest/dist/clappr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/clappr-level-selector@latest/dist/level-selector.min.js"></script>
    <style>
        body { background: #000; color: #fff; margin: 0; overflow: hidden; }
        #player { height: 100vh; width: 100vw; }
        .back-btn { position: absolute; top: 20px; left: 20px; z-index: 999; }
    </style>
</head>
<body>

<a href="index.php" class="btn btn-sm btn-danger back-btn"><i class="fa-solid fa-arrow-left"></i> Home</a>
<div id="player"></div>

<script>
    const urlParams = new URLSearchParams(window.location.search);
    const streamUrl = atob(urlParams.get('url'));
    const channelName = urlParams.get('name');

    var player = new Clappr.Player({
        source: streamUrl,
        parentId: "#player",
        plugins: [LevelSelector],
        width: '100%',
        height: '100%',
        autoPlay: true,
        levelSelectorConfig: {
            title: 'Quality',
            labels: { 2: 'High', 1: 'Medium', 0: 'Low' },
        },
        hlsjsConfig: {
            enableWorker: true
        }
    });
</script>
</body>
</html>
