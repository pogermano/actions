<?php
$html = <<<HTML
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
<style type="text/css">
  .modal a.close-modal[class*="icon-"] {
    top: -10px;
    right: -10px;
    width: 20px;
    height: 20px;
    color: #fff;
    line-height: 1.25;
    text-align: center;
    text-decoration: none;
    text-indent: 0;
    background: #900;
    border: 2px solid #fff;
    -webkit-border-radius: 26px;
    -moz-border-radius: 26px;
    -o-border-radius: 26px;
    -ms-border-radius: 26px;
    -moz-box-shadow:    1px 1px 5px rgba(0,0,0,0.5);
    -webkit-box-shadow: 1px 1px 5px rgba(0,0,0,0.5);
    box-shadow:         1px 1px 5px rgba(0,0,0,0.5);
  }

</style>	
<div  id="login-form"  class = "modal">
<iframe id=login-form-iframe  style='allowfullscreen:true;border:0;width:100%'></iframe>
</div><script>

    $(document).ready(function() {
	    $('a[href="#login-form"]').click(function(event) {
         event.preventDefault();
         $(this).modal({
          escapeClose: false,
          clickClose: false,
          showClose: true,
            fadeDelay: 0.50
         });
    });	
	
	    $('#login-form-iframe').css('height',$(".modal").height()-40);
		
    });
function modalIframeSrc(src) {
  $('#login-form-iframe').attr('src',src);
}
function modalStyle(style) {
  $('#login-form').attr('style',style);	
  $('#login-form-iframe').css('height',$(".modal").height()-40);
}
</script>
HTML;
echo $html;
