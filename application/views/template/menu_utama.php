			<li class="header">MENU UTAMA</li>

			<li><a href="<?php echo base_url(); ?>"><i class="fa fa-home text-aqua"></i><span>Beranda</span></a></li>
	        <li class="active treeview menu-open">
	          <a href="#">
	            <i class="fa fa-dashboard"></i> <span>Pelayanan</span>
	            <span class="pull-right-container">
	              <i class="fa fa-angle-left pull-right"></i>
	            </span>
	          </a>
	          <ul class="treeview-menu">
				<?php
				if ($this->session->level == 2) {
					foreach ($this->m_api->ambil_data_layanan() as $item) {
						?>
						<li><a href="<?php echo base_url('pelayanan/nomor/'.$item->id); ?>"><i class="fa fa-circle-o text-aqua"></i><span><?php echo $item->layanan; ?></span></a></li>
						<?php
					}
				} else {
					foreach ($this->m_api->ambil_data_layanan_user($this->session->id) as $item) {
						$data_layanan = $this->m_api->ambil_data_layanan_id($item->id_layanan);
						?>
						<li><a href="<?php echo base_url('pelayanan/nomor/'.$data_layanan->id); ?>"><i class="fa fa-circle-o text-aqua"></i><span><?php echo $data_layanan->layanan; ?></span></a></li>
						<?php
					}
				}
				?>
	          </ul>
	        </li>