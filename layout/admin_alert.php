<?php
if (isset($_SESSION['message'])) {
?>
<div class="alert alert-warning alert-dismissible fade show text-center" role="alert" style="margin-top:20px;">
	<button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>


	<?php echo $_SESSION['message']; ?>
</div>
<?php
	unset($_SESSION['message']);
}
?>