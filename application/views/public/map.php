<div id="loader"></div>
<section id="mapAset" style="height: 100%;margin-top:50px">
    <div id="bg" style="display:none"></div>
    <div class="container-fluid animated fadeIn" id="myDiv" style="display:none">
        <div class="row row-full">
            <div class="col-md-8 col-xs-12 order-md-1 order-2 left-side">
                <div class="row map">
                    <div class="col box col-xs-12 map-content ">
                        <div id="map">

                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-4 col-xs-12 order-md-2 order-1 right-side">
                <div class="row aset">
                    <div class="col box" id="listData">
                        <div class="row banner">
                            <div class="col">
                                <h3>Filter</h3>

                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Pilih Kawasan</label>
                                    <select class="form-control" id="region" onchange="changeFilter()">
                                        <option value="">Semua</option>
                                        <?php
                                        $now = $this->input->get('filter');
                                        //var_dump($now);
                                        foreach ($region as $key => $value) {
                                            $active = ($now == $value->id) ? 'selected' : '';
                                            echo "<option value='$value->id' $active>$value->name</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3 search">
                            <div class="col-12">
                                <input type="text" class="form-control" v-model="search" placeholder="Mulai mengetik untuk mencari lahan" onclick="showList()">
                            </div>
                        </div>
                        <div class="row map-data animated slideInLeft" id="showData">
                            <div class="col table-responsive">

                                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                    <div class="carousel-inner" id="carouselContainner">
                                        <!-- <div class="carousel-item active">
                                            <img src="https://dummyimage.com/300x200/e6e6e6/666.png" class=" d-block w-100" alt="...">
                                        </div> -->
                                    </div>
                                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                                <h5 class="mt-5">Tanah Milik <span id="land_owner">Nama Aset</span></h4>
                                    <table class="table table-bordered" style="margin-top:20px">
                                        <tr>
                                            <td>Kawasan</td>
                                            <td>:</td>
                                            <td id="region_name"></td>
                                        </tr>
                                        <tr>
                                            <td>Instansi</td>
                                            <td>:</td>
                                            <td id="instance"></td>
                                        </tr>
                                        <tr>
                                            <td>Status</td>
                                            <td>:</td>
                                            <td id="land_status"></td>
                                        </tr>

                                        <tr>
                                            <td>Keterangan</td>
                                            <td>:</td>
                                            <td id="description"></td>
                                        </tr>
                                        <tr>
                                            <td>Dokumen</td>
                                            <td>:</td>
                                            <td> <a href="" id="document" target="_blank"></a></td>
                                        </tr>

                                    </table>
                                    <b class="mt-3">Kompensasi</b>
                                    <table id="compTbl" class="table table-bordered" style="margin-top:20px">
                                        <thead>
                                            <tr>
                                                <th>Tipe</th>
                                                <th>Luas</th>
                                                <th>Harga</th>
                                                <th>Total</td>
                                            </tr>

                                        </thead>
                                        <tbody id="compBody">

                                        </tbody>

                                    </table>
                                    <b>Total: Rp.<span id="totalComp"></spam></b><br>
                                    <button type="button" name="button" class="btn back-button" onclick="showList()">Kembali</button>
                            </div>

                        </div>
                        <div class="row result animated slideInRight" id="result">
                            <div class="list" id="listData">
                                <div class="row" v-for="(aset, index) in filteredList">
                                    <!-- <div class="thumbnail col-4" v-bind:id='index' onclick="showData(this.id)">
                                        <span style="display:none" id="index">{{index}}</span>
                                        <div v-if="aset.foto !== null">
                                            <img v-bind:src="'http://simsetgis.kendarikota.go.id/upload/kib_gedung/foto/'+ aset.foto[0]" alt="">
                                        </div>
                                        <div v-if="aset.foto === null">
                                            <img src="https://dummyimage.com/300x200/e6e6e6/666.png" />
                                        </div>

                                    </div> -->
                                    <div class="text col-12 p-2" v-bind:id='index' onclick="showData(this.id)">
                                        <div class="">
                                            <p class="nama">{{aset.land_owner}}</h3>
                                                <p class="kecamatan">{{aset.region_name}}</p>

                                        </div>

                                    </div>
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
    let url = '<?php echo site_url('home/map_data/' . $filter) ?>';
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            localStorage.clear();
            localStorage.mapData = this.responseText;
            //console.log(localStorage.mapData);
        }
    };
    xhttp.open("GET", url, true);
    xhttp.send();
</script>

<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script>
    var currentData = JSON.parse(localStorage.mapData);
    var map;
    console.log(currentData);
    var listData = new Vue({
        el: '#listData',
        data: {
            search: '',
            asets: currentData
        },
        computed: {
            filteredList() {
                return this.asets.filter(post => {
                    return post.land_owner.toLowerCase().includes(this.search.toLowerCase())
                })
            }
        }
    });



    function initMap() {
        //  console.log(localStorage.mapData);


        mapData = JSON.parse(localStorage.mapData);

        var kendari = {
            lat: -3.9773101,
            lng: 122.5153881
        };
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 12,
            center: kendari
        });


        for (let index = 0; index < mapData.length; index++) {
            let item = mapData[index];

            let points = [];
            if (item.cordinat != null) {
                var cord = JSON.parse("[" + item.cordinat + "]");
                for (var i = 0; i < cord.length; i++) {
                    points.push({
                        lat: cord[i][0],
                        lng: cord[i][1]
                    });
                }
                //console.log(points);
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
                google.maps.event.addListener(plotArea, 'click', function(event) {

                    zoomCenter(event.latLng);
                    showData(index);
                });
            }

        }



        //showData(j);

        function clearBounce(j) {
            for (var k = 0; k < i; k++) {
                var ClearName = 'marker_' + k;
                if (k != j) {
                    window[ClearName].setAnimation(null)
                }
            }

        }
        showPage();
    }

    function zoomCenter(c, z = 19) {

        map.panTo(c);
        map.setZoom(z);
    }

    function showList() {
        var showData = document.getElementById('showData');
        var result = document.getElementById('result');
        var center = {
            lat: -3.9773101,
            lng: 122.5153881
        };
        zoomCenter(center, 12);
        //showData.innerHTML = JSON.stringify(curentData[j]);
        showData.classList.add("slideOutLeft");
        result.classList.remove("slideOutRight");
        setTimeout(function() {
            showData.style.display = 'none';
            result.style.display = 'flex';
        }, 600);
        fore

    }

    function showData(j) {
        var arrVar = [
            'instance',
            'region_name',
            'land_owner',
            'land_status',
            'description',
            'image',
            'document'
        ]
        var showEl = document.getElementById('showData');
        var result = document.getElementById('result');
        var asetData = mapData[j];
        //showData.innerHTML = JSON.stringify(mapData[j]);
        console.log(mapData[j]);
        if (asetData['cordinat'] != null) {
            let kor = JSON.parse("[" + asetData['cordinat'] + "]");
            var center = {
                lat: kor[0][0],
                lng: kor[0][1]
            };
            zoomCenter(center);
        }

        for (var k = 0; k < arrVar.length; k++) {
            var target = document.getElementById(arrVar[k]);
            // console.log(arrVar[k]);
            // console.log(target);

            var obPr = arrVar[k];
            if (arrVar[k] == 'image') {
                let img = JSON.parse(asetData[obPr]);
                // console.log(img);
                const imgCont = document.getElementById('carouselContainner');
                if (img.length > 0) {
                    for (let index = 0; index < img.length; index++) {
                        var div = document.createElement("div");

                        if (index === 0) {
                            div.className = "carousel-item active";
                        } else {
                            div.className = "carousel-item";
                        }
                        var imgSrc = document.createElement("img");
                        imgSrc.src = '<?php echo base_url("uploads/image/")
                                        ?>' + img[index];
                        imgSrc.className = 'd-block w-100';
                        div.appendChild(imgSrc);
                        imgCont.appendChild(div);
                    }
                }

            } else if (arrVar[k] == 'document') {
                target.innerHTML = asetData[obPr];
                target.href = '<?php echo base_url("uploads/")
                                ?>' +
                    asetData[obPr];
            } else {
                target.innerHTML = asetData[obPr];
            }
        }

        if (asetData['comp_type'] != null) {
            var arD = [];
            if (asetData['comp_type'].split(',').length > 0) {
                arD['comp_type'] = asetData['comp_type'].split(',');
                arD['comp_area'] = asetData['comp_area'].split(',');
                arD['comp_price'] = asetData['comp_price'].split(',');
                arD['total_price'] = asetData['total_price'].split(',');
            } else {
                arD['comp_type'] = [asetData['comp_type']];
                arD['comp_area'] = [asetData['comp_area']];
                arD['comp_price'] = a[setData['comp_price']];
                arD['total_price'] = as[etData['total_price']];
            }




            var arrComp = [
                'comp_type',
                'comp_area',
                'comp_price',
                'total_price'
            ];
            const body = document.getElementById('compBody');
            let total = 0;
            for (let i = 0; i < arD['comp_type'].length; i++) {
                var tr = document.createElement("tr");
                for (let index = 0; index < arrComp.length; index++) {
                    var td = document.createElement("td");
                    td.innerHTML = arD[arrComp[index]][i];
                    tr.appendChild(td);
                }
                total = total + parseInt(arD['total_price'][i]);
                body.appendChild(tr);
            }
            const totalComp = document.getElementById('totalComp');
            totalComp.innerHTML = total;


        }

        showEl.classList.remove("slideOutLeft");
        result.classList.add("slideOutRight");
        setTimeout(function() {
            showEl.style.display = 'flex';
            result.style.display = 'none';
        }, 600);

    }

    function showPage() {

        document.getElementById("loader").style.display = "none";
        document.getElementById("myDiv").style.display = "block";
        document.getElementById("bg").style.display = "block";
    }

    function changeFilter() {
        var region = document.getElementById('region');
        if (region.value == '') {
            location.replace('<?php echo site_url('home/map') ?>');
        } else {
            location.replace('<?php echo site_url('home/map?filter=') ?>' + region.value);
        }
    }
</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBnD9wUjrrYzaLQtfnWLoL_cHaKICYpZ5U&callback=initMap">
</script>