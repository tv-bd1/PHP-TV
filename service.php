<?php
header('Content-Type: application/json');

$m3uUrl = "https://raw.githubusercontent.com/tvbd/m3uplayer/refs/heads/main/m3u/nexgen.m3u";

if ($_POST['action'] == 'getChannels') {
    // ক্যাচিং সিস্টেম (বারবার লোড হওয়া কমাতে)
    $cacheFile = 'channels.json';
    if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < 3600)) {
        $data = file_get_contents($cacheFile);
    } else {
        $content = file_get_contents($m3uUrl);
        $lines = explode("\n", $content);
        $channels = [];
        
        for ($i = 0; $i < count($lines); $i++) {
            if (strpos($lines[$i], '#EXTINF') !== false) {
                preg_match('/tvg-logo="(.*?)"/', $lines[$i], $logo);
                $nameParts = explode(',', $lines[$i]);
                $name = end($nameParts);
                $streamUrl = trim($lines[$i + 1]);

                if (!empty($streamUrl) && strpos($streamUrl, 'http') === 0) {
                    $channels[] = [
                        "title" => trim($name),
                        "logo" => $logo[1] ?? 'https://via.placeholder.com/150',
                        "url" => $streamUrl
                    ];
                }
            }
        }
        $data = json_encode(["status" => "success", "data" => ["list" => $channels]]);
        file_put_contents($cacheFile, $data);
    }
    echo $data;
}
?>
