<?php $this->load->view("block/html_header"); ?>
<body>
<div id="container" class="container container_12">
<div class="grid_12 boxed headerwide rowhide">
<?php $this->load->view("block/header");
$this->load->view("block/login");
?>
</div>
<?php $this->load->view("block/sidebar"); ?>
<div class="content_main">
<div id="main" class="grid_8 boxed content_main ">
<?php $this->load->view("block/content_main"); ?>
</div>
</div>
<?php $this->load->view("block/footer"); ?>
</div>
<?php $this->load->view("block/html_footer"); ?>