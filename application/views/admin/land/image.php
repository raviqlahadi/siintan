<section class="content">
    <div class="container-fluild">
        <div class="block-header">
            <div class="row">
                <div class="col-md-6">
                    <h2><?php echo ucwords($block_header) ?>.</h2>
                </div>
                <div class="col-md-6 text-right">
                    <?php echo $breadcrumb ?>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            IMAGE UPLOAD
                            <small> DRAG &amp; DROP OR WITH CLICK &amp; CHOOSE</small>
                        </h2>
                    </div>
                    <div class="body">
                        <form action="<?php echo $form_action ?>" id="frmFileUpload" class="dropzone dz-clickable" method="post" enctype="multipart/form-data">
                            <div class="dz-message">
                                <div class="drag-icon-cph">
                                    <i class="material-icons">touch_app</i>
                                </div>
                                <h3>Drop files here or click to upload.</h3>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header" style="margin-bottom: 30px">
                        <div class="row clearfix">
                            <div class="col-lg-8">
                                <h2>
                                    GALLERY
                                    <small>Klik pada gambar untuk melihat lebih jelas</small>
                                </h2>
                            </div>
                            <div class="col-lg-4 text-right">
                                <a href="<?php echo site_url($current_page); ?>" type="button" class="btn btn-warning btn-md m-l-15 waves-effect"><i class="material-icons">refresh</i></a>
                            </div>
                        </div>

                  

                    </div>
                    <div class="body">
                        <div id="aniimated-thumbnials" class="list-unstyled row clearfix">
                            <?php
                            foreach ($gallery as $key => $value) : ?>
                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 text-center">
                                    <a  id='galImg' href="<?php echo site_url('uploads/image/' . $value->image) ?>" data-sub-html="Demo Description">
                                        <img class="img-responsive thumbnail" src="<?php echo site_url('uploads/thumb/' .  $value->thumb) ?>">
                                    </a>
                                    <a href="<?php echo site_url('admin/land/delete_image/'. $value->id.'?land_id='.$id)?>" class="btn btn-danger btn-sm">X</a>
                                </div>
                            <?php
                            endforeach;
                            ?>


                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>