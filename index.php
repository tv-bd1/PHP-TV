<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Home - RoarZone | CodeCrafter</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <style>
        body { font-family: "Montserrat", sans-serif; background-color: black; color: white; }
        .card { color: #fff; border-radius: 1rem; background-color: #202020; text-align:center; border:2px solid transparent; transition:0.3s; cursor: pointer; }
        .card:hover { background-color: rgba(165,42,42,0.5); border-color:white; transform: scale(1.05); }
        .tvimage { border-radius: 15px; width: 100%; height: 100px; object-fit: contain; padding: 10px; }
        .search-container { background: #1a1a1a; padding: 20px; border-radius: 10px; margin-bottom: 30px; }
    </style>
</head>
<body>

<nav class="navbar border-bottom border-secondary mb-4">
  <div class="container text-center">
    <h3 class="mx-auto text-danger fw-bold">ROAR<span class="text-white">ZONE</span></h3>
  </div>
</nav>

<div class="container">
    <div class="search-container">
        <div class="input-group">
            <input type="text" class="form-control bg-dark text-white border-secondary" placeholder="চ্যানেলের নাম লিখুন..." id="inpSearchTV">
            <button class="btn btn-danger" type="button" id="btnInitTVSearch"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
    </div>

    <div id="tvsGrid" class="row">
        <div class="text-center mt-5">
            <div class="spinner-border text-danger" role="status"></div>
            <p class="mt-2">চ্যানেল লোড হচ্ছে, অপেক্ষা করুন...</p>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
    loadTVlist();
});

function loadTVlist(){
    $.ajax({
        url: "service.php",
        type: "POST",
        data: { action: "getChannels" },
        success: function(data){
            renderGrid(data.data.list);
        }
    });
}

function renderGrid(channels){
    let html = '';
    channels.forEach(v => {
        // Base64 encode the URL for safe transport
        let safeUrl = btoa(v.url);
        html += `
        <div class="col-lg-2 col-md-4 col-6 mb-4" onclick="playTV('${safeUrl}', '${v.title}')">
            <div class="card h-100">
                <img src="${v.logo}" class="tvimage" onerror="this.src='https://via.placeholder.com/150?text=TV'">
                <div class="card-body p-2">
                    <small class="fw-bold">${v.title}</small>
                </div>
            </div>
        </div>`;
    });
    $("#tvsGrid").html(html);
}

function playTV(url, name) {
    window.location = "player.php?url=" + url + "&name=" + encodeURIComponent(name);
}

$("#btnInitTVSearch").on("click", function() {
    let q = $("#inpSearchTV").val().toLowerCase();
    $(".col-lg-2").each(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(q) > -1);
    });
});
</script>
</body>
</html>
