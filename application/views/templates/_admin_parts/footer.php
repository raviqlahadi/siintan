 <!-- Jquery Core Js -->
 <script src="<?php echo base_url('assets/') ?>vendor/jquery/jquery.min.js"></script>

 <!-- Bootstrap Core Js -->
 <script src="<?php echo base_url('assets/') ?>vendor/bootstrap/js/bootstrap.js"></script>

 <!-- Select Plugin Js -->
 <script src="<?php echo base_url('assets/') ?>vendor/bootstrap-select/js/bootstrap-select.js"></script>

 <!-- Slimscroll Plugin Js -->
 <script src="<?php echo base_url('assets/') ?>vendor/jquery-slimscroll/jquery.slimscroll.js"></script>

 <!-- Waves Effect Plugin Js -->
 <script src="<?php echo base_url('assets/') ?>vendor/node-waves/waves.js"></script>

 <?php
    if (isset($plugin)) {
        $plugin_arr = [
            'light-gallery' => '<script src="' . base_url('assets/') . 'vendor/light-gallery/js/lightgallery-all.js"></script>',
            'dropzone' => '<script src="' . base_url('assets/') . 'vendor/dropzone/dropzone.js"></script>',
            'ckeditor' => '<script src="' . base_url('assets/') . 'vendor/ckeditor/ckeditor.js"></script>'
        ];
        foreach ($plugin as $key => $value) {
            echo $plugin_arr[$value];
        }

        if (array_search('light-gallery', $plugin) !== false) {

            echo "<script>
                $(function() {
                    $('#aniimated-thumbnials').lightGallery({
                        thumbnail: true,
                        selector: 'a#galImg'
                    });
                });
            </script>";
        }
        if (array_search('dropzone', $plugin) !== false) {

            echo "<script>
                $(function() {
                    Dropzone.options.frmFileUpload = {
                        acceptedFiles: 'image/*',
                        maxFilesize: 3 // MB
                    };
                });
            </script>";
        }
    }
    ?>
 <script>
     CKEDITOR.replace('description');
 </script>
 <!-- Custom Js -->
 <script src="<?php echo base_url('assets/') ?>js/admin/admin.js"></script>

 <!-- Demo Js -->
 <script src="<?php echo base_url('assets/') ?>js/admin/demo.js"></script>

 </body>