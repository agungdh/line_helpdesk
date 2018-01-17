<!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo $data['pengaduan_belum']; ?></h3>

              <p>Pengaduan Belum Terselesaikan</p>
            </div>
            <div class="icon">
              <i class="ion ion-social-usd"></i>
            </div>
            <a href="<?php echo base_url('pengaduan') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo $data['pengaduan_selesai']; ?></h3>

              <p>Pengaduan Terselesaikan</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-pie"></i>
            </div>
            <a href="<?php echo base_url('pengaduan') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo $data['pengaduan_total']; ?></h3>

              <p>Jumlah Pengaduan</p>
            </div>
            <div class="icon">
              <i class="ion ion-document-text"></i>
            </div>
            <a href="<?php echo base_url('pengaduan') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->

 <div id="myCarousel" class="carousel slide" data-ride="carousel">
    
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">

      <div class="item active">
        <img src="<?php echo base_url("assets/dist/img/photo1.jpg"); ?>" alt="Photo1" width="100%">
      </div>

      <div class="item">
        <img src="<?php echo base_url("assets/dist/img/photo2.jpg"); ?>" alt="Photo2" width="100%">
      </div>

      <div class="item">
        <img src="<?php echo base_url("assets/dist/img/photo3.jpg"); ?>" alt="Photo3" width="100%">
      </div>

    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
	</div>