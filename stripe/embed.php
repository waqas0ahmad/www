    <script src="https://js.stripe.com/v3/"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        div#card_number,div#card_expiry,div#card_cvc {
    display: block;
    width: 100%;
    padding: .375rem .75rem;
    font-size: 1rem;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: .25rem;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}
        </style>
    <?php
    // Include configuration file  
    require_once 'config.php';
    $itemName = $_GET["name"];
    $itemNumber = $_GET["number"];
    $itemPrice = $_GET["price"];
    $currency = $_GET["cur"];
    if(empty($currency)){
        $currency="EUR";
    }
    ?>
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">Pay <?php echo $currency .' '. $itemPrice; ?> with Card</h3>
        </div>
        <div class="panel-body">
            <!-- Display errors returned by createToken -->
            <div id="paymentResponse"></div>

            <!-- Payment form -->
            <form action="/stripe/payment.php" method="POST" id="paymentFrm">
            <div class="row">
                <div class="form-group col-12">
                    <label>CARD NUMBER</label>
                    <div id="card_number" class="field"></div>
                </div>
                </div>
                <div class="row">
                    <div class="col-12">
                    <div class="left">
                        <div class="form-group">
                            <label>EXPIRY DATE</label>
                            <div id="card_expiry" class="field"></div>
                        </div>
                    </div>
                    <div class="right">
                        <div class="form-group">
                            <label>CVC CODE</label>
                            <div id="card_cvc" class="field"></div>
                        </div>
                    </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success" id="payBtn">Submit Payment</button>
            </form>
        </div>
    </div>

    <script>
        // Create an instance of the Stripe object
        // Set your publishable API key
        var stripe = Stripe('<?php echo $STRIPE_PUBLISHABLE_KEY; ?>');

        // Create an instance of elements
        var elements = stripe.elements();

        var style = {
            base: {
                fontWeight: 400,
                fontFamily: 'Roboto, Open Sans, Segoe UI, sans-serif',
                fontSize: '16px',
                lineHeight: '1.4',
                color: '#555',
                backgroundColor: '#fff',
                '::placeholder': {
                    color: '#888',
                },
            },
            invalid: {
                color: '#eb1c26',
            }
        };

        var cardElement = elements.create('cardNumber', {
            style: style
        });
        cardElement.mount('#card_number');

        var exp = elements.create('cardExpiry', {
            'style': style
        });
        exp.mount('#card_expiry');

        var cvc = elements.create('cardCvc', {
            'style': style
        });
        cvc.mount('#card_cvc');

        // Validate input of the card elements
        var resultContainer = document.getElementById('paymentResponse');
        cardElement.addEventListener('change', function(event) {
            if (event.error) {
                resultContainer.innerHTML = '<p>' + event.error.message + '</p>';
            } else {
                resultContainer.innerHTML = '';
            }
        });

        // Get payment form element
        var form = document.getElementById('paymentFrm');

        // Create a token when the form is submitted.
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            createToken();
        });

        // Create single-use token to charge the user
        function createToken() {
            stripe.createToken(cardElement).then(function(result) {
                if (result.error) {
                    // Inform the user if there was an error
                    resultContainer.innerHTML = '<p>' + result.error.message + '</p>';
                } else {
                    // Send the token to your server
                    stripeTokenHandler(result.token);
                }
            });
        }

        // Callback to handle the response from stripe
        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            
            form.appendChild(hiddenInput);

            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'usertoken');
            hiddenInput.setAttribute('value', '<?php echo $_GET["u"];?>');
            
            form.appendChild(hiddenInput);

            // Submit the form
            form.submit();
        }
    </script>