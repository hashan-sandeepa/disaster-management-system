var updateMap = null;
var curLat = 6.843276;
var curLng = 80.003183;
var userMaps = [];
var userLocations = [];

function initMap() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            curLat = position.coords.latitude;
            curLng = position.coords.longitude;
        });
    }
    $('#longitude').val(curLng);
    $('#latitude').val(curLat);

    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 8,
        center: new google.maps.LatLng(curLat, curLng)
    });

    var marker, i;

    $.ajax({
        url: "php/getRegionData.php",
        type: "get",
        async: false,
        success: function (data) {
            var locations = JSON.parse(data);
            for (i = 0; i < locations.length; i++) {
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(Number(locations[i].latitude), Number(locations[i].longitude)),
                    animation: google.maps.Animation.DROP,
                    map: map
                });

                var infowindow = new google.maps.InfoWindow({
                    content: locations[i].title,
                    maxWidth: 160,
                });
                infowindow.open(map, marker);
            }
        },
        error: function () {
            connectionError();
        }
    });

    $.ajax({
        url: "php/getUserRegion.php",
        type: "get",
        async: false,
        success: function (data) {
            var region_data = JSON.parse(data);
            for (i = 0; i < region_data.length; i++) {
                var status=region_data[i].status;
                var alertClass;
                var statusAttr;
                var actionBtnAttr="";
                console.log(region_data[i].isAdmin);
                if(status==1){
                    alertClass="alert-success";
                    statusAttr="<p class='status-label resolve_label'>RESOLVED</p>";
                }else if(status==2){
                    alertClass="alert-danger";
                    statusAttr="<p class='status-label open_label'>OPENED</p>";
                    if(region_data[i].isAdmin==true){
                        actionBtnAttr='<a class="actionBtn resolveBtn" href="php/resolveRegion.php?id='+region_data[i].id+'">RESOLVE</a>';
                    }
                }else {
                    alertClass="alert-warning";
                    statusAttr="<p class='status-label pending_label'>PENDING</p>";
                    if(region_data[i].isAdmin==true){
                        actionBtnAttr='<a class="actionBtn approveBtn" href="php/approveRegion.php?id='+region_data[i].id+'">APPROVE</a>';
                    }
                }

                console.log(actionBtnAttr);

                $('#user_maps').append('<div class="alert '+alertClass+'">'+statusAttr+'<div class="container"><div class="row"><div class="user_map col-sm-4" id="map' + i + '"></div>' +
                    '<div class="col-sm-4" style="padding: 10px">'+region_data[i].description+'</div><div class="col-sm-4" style="padding: 10px;margin-top:10px;margin-left: 85px">'+actionBtnAttr+'</div></div></div></div></div><br>');

                var lat = Number(region_data[i].latitude);
                var lng = Number(region_data[i].longitude);

                var updateMap1 = new google.maps.Map(document.getElementById("map" + i), {
                    zoom: 9,
                    center: new google.maps.LatLng(lat, lng),
                });

                var currentMarker1 = new google.maps.Marker({
                    position: new google.maps.LatLng(lat, lng),
                    draggable: true,
                    animation: google.maps.Animation.DROP,
                    map: updateMap1
                });

                var infowindow1 = new google.maps.InfoWindow({
                    content: region_data[i].title,
                    maxWidth: 160,
                });

                infowindow1.open(updateMap1, currentMarker1);

                userMaps.push(updateMap1);
                userLocations.push({lat: lat, lng: lng});
            }

            if(region_data.length==0){
                $('#user_maps').append('<div>No region found!</div>');
            }

        },
        error: function () {
            connectionError();
        }
    });

    updateMap = new google.maps.Map(document.getElementById("map-canvas"), {
        zoom: 8,
        center: new google.maps.LatLng(curLat, curLng),
    });

    var currentMarker = new google.maps.Marker({
        position: new google.maps.LatLng(curLat, curLng),
        draggable: true,
        animation: google.maps.Animation.DROP,
        map: updateMap
    });

    google.maps.event.addListener(currentMarker, 'dragend', function (event) {
        $('#longitude').val(event.latLng.lng());
        $('#latitude').val(event.latLng.lat());
    });
}

$('#updateModal').on('shown.bs.modal', function () {
    google.maps.event.trigger(updateMap, 'resize');
    updateMap.setCenter({lat: curLat, lng: curLng});
});

$('#regionModal').on('shown.bs.modal', function () {
    for (var i = 0; i < userMaps.length; i++) {
        var lat = Number(userLocations[i].lat);
        var lng = Number(userLocations[i].lng);
        google.maps.event.trigger(userMaps[i], 'resize');
        userMaps[i].setCenter({lat: lat, lng: lng});
    }
});

function resolveDisaster(id) {
    $.ajax({
        url: "php/approveRegion.php",
        type: "get",
        success: function (data) {
            var locations = JSON.parse(data);
            for (i = 0; i < locations.length; i++) {
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(Number(locations[i].latitude), Number(locations[i].longitude)),
                    animation: google.maps.Animation.DROP,
                    map: map
                });

                var infowindow = new google.maps.InfoWindow({
                    content: locations[i].title,
                    maxWidth: 160,
                });
                infowindow.open(map, marker);
            }
        },
        error: function () {
            connectionError();
        }
    });
}

function approveDisaster(id) {

}



