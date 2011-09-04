<div id="list-playlist" class="list-playlist">
<?php
if ($query->result()) { 
?>
<p><?php echo $this->lang->line('ilts_yourplaylist');?></p>
<div id="loved_playlist">
<?php 
$data = array();
$data["query"] = $query;
$this->load->view("block/loved_playlist", $data);
?>

</div>
<div id="loved_result">
<?php 
$this->load->view("block/loved_result");

?>
</div>
<?php 
} else {
?>
<p><?php echo $this->lang->line('ilts_yourplaylist_empty');?></p>
<?php 
}
?>

</div>