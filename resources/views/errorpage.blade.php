<!-- 
<form id="checkoutForm" method="POST" action="/charge">
  <script type="text/javascript" src="https://cdn.omise.co/omise.js"
          data-key="pkey_test_5m2qg4h7ln9k4g0nd9v"
          data-amount="12345"
          data-currency="THB"
          data-default-payment-method="credit_card">
  </script>
</form> -->
<html class="no-js" lang="en">
<head>
    <title> Payment</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"></link>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>

    <style>
        body {
            background: #EECDA3;
            background: -webkit-linear-gradient(to top, #EF629F, #EECDA3);
            background: linear-gradient(to top, #EF629F, #EECDA3);
        }

        .container {
            max-width: 550px;
        }

        .has-error label,
        .has-error input,
        .has-error textarea {
            color: red;
            border-color: red;
        }

        .list-unstyled li {
            font-size: 13px;
            padding: 4px 0 0;
            color: red;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="card">
            <!-- <h5 class="card-header text-center">Payment Response</h5> -->
            <div class="card-body">
             
                <div align="text-center">{{ $dataerr['message'] }}</div>
                <div><a href="{{ url('/') }}">Back Home</a></div>
            </div>
        </div>
    </div>
</body>

</html>