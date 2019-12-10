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
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="body">
                        <h2 class="card-inside-title">Kordinat</h2>
                        <div class="row clearfix">
                            <?php
                            if ($plot == null || $edit) { ?>
                                <?php echo form_open($form_action) ?>
                                <div class="col-sm-12 text-right">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea rows="4" id="cordPlaceholder" name="cordinat" class="form-control no-resize" placeholder="Please type what you want..."></textarea>
                                        </div>
                                    </div>
                                    <input type="reset" class="btn btn-warning">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                                <?php echo form_close() ?>
                            <?php
                            } else {
                                ?>
                                <div class="col-sm-12 text-right">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea rows="4" id="cordPlaceholder" name="cordinat" class="form-control no-resize" placeholder="" readonly><?php echo str_replace("[","(",str_replace("]",")",$plot)); ?></textarea>
                                        </div>
                                    </div>
                                    <a href="<?php echo $edit_url ?>" type="button" class="btn btn-primary">Edit</a>
                                </div>
                            <?php
                            }
                            ?>

                        </div>

                    </div>
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
                <?php if ($plot != null) :
                    $plot_arr = json_decode($plot);
                    $kor =  $plot[0];
                    $kor = explode(",", $plot);
                    $lat = str_replace("[", "", $kor[0]);
                    $lng = str_replace("]", "", $kor[1]);
                    ?>
                    lat: <?php echo $lat ?>,
                    lng: <?php echo $lng ?>
                <?php else : ?>
                    lat: -3.9870736,
                    lng: 122.5114034
                <?php endif; ?>

            },
            zoom: 15
        });


        <?php
        if ($plot != null && $edit == false) {
            ?>
            var plotCord = [
                <?php echo $plot; ?>
            ];
            var points = [];
            for (var i = 0; i < plotCord.length; i++) {
                points.push({
                    lat: plotCord[i][0],
                    lng: plotCord[i][1]
                });
            }
            // Construct the polygon.
            var plotArea = new google.maps.Polygon({
                paths: points,
                strokeColor: '#FF0000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#FF0000',
                fillOpacity: 0.35
            });
            plotArea.setMap(map);
        <?php
        } else {
            ?>
            google.maps.event.addListener(map, 'click', function(event) {
                placeMarker(event.latLng);
                addCord(event.latLng);
            });

            function placeMarker(location) {
                var marker = new google.maps.Marker({
                    position: location,
                    map: map
                });
            }

            function addCord(location) {
                const placeholder = document.getElementById('cordPlaceholder');
                if (!String.prototype.trim) {
                    String.prototype.trim = function() {
                        return this.replace(/^\s+|\s+$/, '');
                    };
                }
                if (placeholder.innerHTML.trim() == "") {
                    placeholder.innerHTML = location;
                } else {
                    placeholder.innerHTML = placeholder.innerHTML + ',' + location;
                }

            }
        <?php
        }
        ?>
    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBnD9wUjrrYzaLQtfnWLoL_cHaKICYpZ5U&callback=initMap">
</script>