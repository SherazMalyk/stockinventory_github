<?php include_once 'links/head.php' ?>
<?php 
	session_start();
	session_destroy();
	header('refresh:2;url=login.php'); 
?>
<?php include_once 'links/head.php' ?>
<script>
	var Toast = Swal.mixin({
	    toast: true,
	    position: 'top-end',
	    showConfirmButton: false,
	    timer: 2000
	});
	Toast.fire({
          icon: data.sts,
          title: data.msg
    })

</script>