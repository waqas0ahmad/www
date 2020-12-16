<html>
  <head>
    <script src="https://js.stripe.com/v3/"></script>
    <style>
    #checkout-button{
      background-color: #FCFEE5;
    border-style: solid;
    border-color: #6D6049;
    border-width: 1px;
    font-size: 11px;
    font-weight: normal;
    font-family: Tahoma,Arial,Helvetica;
    text-decoration: none;
    padding-left: 2px;
    padding-right: 2px;
    height: 60px;
    width: 300px;
    cursor: pointer;
    }
    </style>
  </head>
  <body>
    <button id="checkout-button"><?php echo $_GET["amt"];?> EUR <br> Using card</button>

    <script type="text/javascript">
      // Create an instance of the Stripe object with your publishable API key


      ////live
      // var stripe = Stripe('pk_live_51HmGckEUkqw9oAulS3envXJ7g5WJqT8ohRo6BBNFW5tvrk5wsspAGoevGUMBqJz4KdYgvtqpG7eh5LLkbVCm3SAK00yyuv3J1x');

      //local
      var stripe = Stripe('pk_test_51HJds8HonZAuahLJfC3eYsfbLP9pcTqJt5dnlJG13bXi2Kbl1pfamuA3NO9jUJyK3UCCH2jPl1tbB0PSIo51TKyh00nwWbtNYe');
      var checkoutButton = document.getElementById('checkout-button');

      checkoutButton.addEventListener('click', function() {
        // Create a new Checkout Session using the server-side endpoint you
        // created in step 3.
        var url ="/stripe/session.php?u=<?php echo $_GET["u"];?>&amount=<?php echo $_GET["amt"];?>";
        fetch(url, {
          method: 'GET'
        })
        .then(function(response) {
          return response.json();
        })
        .then(function(session) {
          return stripe.redirectToCheckout({ sessionId: session.id });
        })
        .then(function(result) {
          // If `redirectToCheckout` fails due to a browser or network
          // error, you should display the localized error message to your
          // customer using `error.message`.
          if (result.error) {
            alert(result.error.message);
          }
        })
        .catch(function(error) {
          console.error('Error:', error);
        });
      });
    </script>
  </body>
</html>