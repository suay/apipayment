
<form name="form" action="<?php env('GBPAY')?>/v1/tokens/3d_secured" method="POST">
  publicKey: <input type="text" name="publicKey" value="" /><br>
  gbpReferenceNo: <input type="text" name="gbpReferenceNo" value="" />
  <button type="submit">Pay</button>
</form>
<!-- <script>
  window.onload=function(){
    document.forms["form"].submit();
  }
</script> -->