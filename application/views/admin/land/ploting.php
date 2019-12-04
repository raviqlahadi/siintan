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
                        <h2 class="card-inside-title">Cordinat</h2>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <textarea rows="4" id="cordPlaceholder" class="form-control no-resize" placeholder="Please type what you want..."></textarea>
                                    </div>
                                </div>
                                <button class="btn">Clear</button>
                                <button class="btn">Submit</button>
                            </div>

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
                lat: -3.9870736,
                lng: 122.5114034
            },
            zoom: 13
        });
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
                placeholder.innerHTML = placeholder.innerHTML + ';' + location;
            }

        }
    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBnD9wUjrrYzaLQtfnWLoL_cHaKICYpZ5U&callback=initMap">
</script>