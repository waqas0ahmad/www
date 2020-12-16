
<?php $url="http://www.jkcall.fr/test/";?>

        
<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
    <input type='hidden' name='business' value='sb-rcc5u3398491@business.example.com'> 
    <input type='hidden' name='item_name' value='<? echo $_GET["name"];?>'> 
    <input type='hidden' name='item_number' value="<? echo $_GET["admin_username"];?>"> 
    <input type='hidden' name='amount' value='<? echo $_GET["amt"];?>'> 
    <input type='hidden' name='no_shipping' value='1'> 
    <input type='hidden' name='currency_code' value='<? echo $_GET["cur"];?>'> 
    <input type='hidden' name='notify_url' value='<?php echo $url;?>notify.php'>
    <input type='hidden' name='cancel_return' value='<?php echo $url;?>cancel.php'>
    <input type='hidden' name='return' value='<?php echo $url;?>return.php'>
    <input type="hidden" name="cmd" value="_xclick">
    <button type="submit" name="pay_now" id="pay_now">Paypal 
        <span class="txt-price"> <? echo $_GET["amt"];?> <? echo $_GET["cur"];?></span>
    </button>
</form>
        