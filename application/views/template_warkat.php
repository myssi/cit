<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"[]>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
<head>
	<title>Cash Transit Online</title>
	<link rel="stylesheet" href="<?php echo base_url('css/style.css'); ?>" type="text/css" media="screen" />
    <script type="text/javascript" src="<?php echo base_url('js/jquery-1.7.1.min.js'); ?>"></script>
</head>
<body>
<div id="art-page-background-glare-wrapper">
    <div id="art-page-background-glare"></div>
</div>
<div id="art-main">
    <div class="cleared reset-box"></div>
    <div class="art-box art-sheet">
        <div class="art-box-body art-sheet-body">
            <div class="art-header">
                <div class="art-logo">
                    <h1 class="art-logo-name"><a href="#">Cash And Transit</a></h1>
                    <h2 class="art-logo-text">PT. SSI</h2>
                </div>
				<label>[<?php 
				$levelid= $this->session->userdata('leveltxt');
				echo isset($levelid) ? $levelid : ''; 
				?>]</label>
            </div>
<div class="cleared reset-box"></div>
<div class="art-bar art-nav"> <?php $this->load->view($navigation); ?></div>
<div class="cleared reset-box"></div>
<div class="art-layout-wrapper">
    <div class="art-content-layout">
        <div class="art-content-layout-row">                   
            <div class="art-layout-cell art-content">
<div class="art-box art-post">
    <div class="art-box-body art-post-body">
<div class="art-post-inner art-article">
	<div class="art-postheadericons art-metadata-icons">
		<span class="art-postdateicon"><?php echo isset($path) ? $path : ''; ?></span>
		<span class="cabang"><?php echo isset($cab) ? '[Cabang '.$cab.']' : ''; ?></span>
	</div><br/><br/>
	<div class="cleared"></div>
	<div class="art-postcontent"><?php $this->load->view($contain); ?></div>
</div>

		<div class="cleared"></div>
    </div>
</div>
<div class="art-box art-post">
    <div class="art-box-body art-post-body">
      <div class="cleared"></div>
    </div>
</div>

                          <div class="cleared"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="cleared"></div>
            <div class="art-footer">
                <div class="art-footer-body">
                   <div class="art-footer-text">
                    <p>Copyright@2013. Design By Unit IT (J).</p>
                   </div>
                    <div class="cleared"></div>
                </div>
            </div>
    		<div class="cleared"></div>
        </div>
    </div>
    
    <div class="cleared"></div>
</div>

</body>
</html>
<?php 
	$message= $this->session->userdata('message_error');
	$this->session->unset_userdata('message_error');
	
	if(!empty($message))
	{
		echo'<script type="text/javascript">';
		echo'alert("'.$message.'")';
		echo'</script>';
	}
?>