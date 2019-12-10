<section class="bg-gradient-yellow h-50vh" id="home">
    <div class="home-table">
        <div class="home-table-center">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-white text-center">

                            <h1 class="header_title mx-auto mt-4 mb-0 font-weight-normal">Peta Persebaran</h1>
                            <p class="header_subtitle mx-auto pt-4 mb-0 pb-2 text-white"></p>
                            <!-- <div class="header_btn">
                                <a href="#" class="btn btn-custom mt-4">Get Started</a>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="h-100vh m-5">
    <div class="container" style="height:100%" id="map">

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

    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBnD9wUjrrYzaLQtfnWLoL_cHaKICYpZ5U&callback=initMap">
</script>