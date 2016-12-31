<!-- footer 開始 -->
<div class="footer_boxmain">
<p>BELLEZA Professional Tattoo Quipment 美麗紋有限公司</p>
<?php if($route != 'index') { ?>
<p>TEL 專線: +886 2 89819714  FAX 傳真: +886 2 29839728</p>  
<p>1F., No.20, Aly. 28, Ln. 210, Dingkan St., Sanchong City, Taipei County 241, Taiwan (R.O.C.)  241新北市三重區頂崁街210巷28弄20號1樓</p> 
<p>E-mail:<a href="mailto:howandping@gmail.com">howandping@gmail.com</a></p>
<?php } ?>
</div>

<!-- footer 結束 -->

</body>
</html>

<?php echo $google_analytics; ?>
<?php 
if($online_service == 1)
{
?>
<!--Start of Zopim Live Chat Script-->
<script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
$.src="//v2.zopim.com/?4FC1zJzOkjwRMRXM85Yj6g4uZTMEbHOJ";z.t=+new Date;$.
type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
</script>
<!--End of Zopim Live Chat Script-->
<?php
}
?>
