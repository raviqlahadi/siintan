<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-md-6">
                    <h2><?php echo ucwords($block_header) ?></h2>
                </div>
                <div class="col-md-6 text-right">
                    <?php echo $breadcrumb; ?>
                </div>
            </div>

        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div id="map" style="height: 60vh"></div>
                </div>
            </div>
        </div>

    </div>

    </div>
</section>
<script>
    var map;

    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {

                lat: -3.9870736,
                lng: 122.5114034


            },
            zoom: 15
        });



        <?php
        $i = 1;
        foreach ($map_data as $key => $value) { ?>
            var plotCord<?php echo $i ?> = [
                <?php echo $value->cordinat; ?>
            ];
            var points = [];
            for (var i = 0; i < plotCord<?php echo $i ?>.length; i++) {
                points.push({
                    lat: plotCord<?php echo $i ?>[i][0],
                    lng: plotCord<?php echo $i ?>[i][1]
                });
            }
            // Construct the polygon.
            var plotArea<?php echo $i ?> = new google.maps.Polygon({
                paths: points,
                strokeColor: '#FF0000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#FF0000',
                fillOpacity: 0.35
            });
            plotArea<?php echo $i ?>.setMap(map);
        <?php $i++;
        } ?>



    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBnD9wUjrrYzaLQtfnWLoL_cHaKICYpZ5U&callback=initMap">
</script>