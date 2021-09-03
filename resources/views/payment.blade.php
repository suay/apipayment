
<!-- <form id="checkoutForm" method="POST" action="/charge">
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
            <h5 class="card-header text-center">Payment Demo</h5>
            <div class="card-body">
                <!-- <form role="form" data-toggle="validator" action="{{ url('api/charge') }}" method="POST">

                     <div class="form-group">
                        <label>Amount</label>
                        <input type="text" class="form-control" maxlength="8" minlength="4" data-error="You must have amount." id="amount" name="amount" placeholder="00.00" pattern="^[0-9_..]*$" required>

                       
                        <div class="help-block with-errors"></div>
                    </div>

                    <div class="form-group">
                        <label>Card number</label>
                        <input type="text" class="form-control" maxlength="16" minlength="0" data-error="You must have a card number." id="cardnumber" name="cardnumber" placeholder="Card number" required>

                        
                        <div class="help-block with-errors"></div>
                    </div>

                    <div class="form-group">
                        <label>Card Name</label>
                        <input type="text" class="form-control" name="cardname" id="cardname" placeholder="Card Name" required>

                        
                        <div class="help-block with-errors"></div>
                    </div>

                    <div class="form-group">
                        <label>Expiration Date</label>
                        <input type="text" class="form-control" id="exdate" name="exdate" maxlength="5" minlength="5" placeholder="MM/YY" data-error="You must have format MM/YY" pattern="^[0-9_./]*$" required>

                        
                        <div class="help-block with-errors"></div>
                    </div>


                    <div class="form-group">
                        <label>Security code</label>
                        <div class="form-group">
                            <input type="password" minlength="3" maxlength="3" class="form-control" id="secode" name="secode" 
                                data-error="Have atleast 3 number" placeholder="CCV" required />

                            
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Country</label>
                        <div class="form-group">
                        <select id="country" name="country" class="form-control">
                          <option value="Afghanistan">Afghanistan</option>
                          <option value="Albania">Albania</option>
                          <option value="Algeria">Algeria</option>
                          <option value="Andorra">Andorra</option>
                          <option value="2">Angola</option>
                          <option value="3">Antigua and Barbuda</option>
                          <option value="1">Argentina</option>
                          <option value="2">Armenia</option>
                          <option value="3">Australia</option>
                          <option value="1">Austria</option>
                          <option value="2">Azerbaijan</option>
                          <option value="3">Bahamas</option>
                          <option value="1">Bahrain</option>
                          <option value="2">Bangladesh</option>
                          <option value="3">Barbados</option>
                          <option value="1">Belarus</option>
                          <option value="2">Belgium</option>
                          <option value="3">Belize</option>
                          <option value="1">Benin</option>
                          <option value="2">Bhutan</option>
                          <option value="3">Bolivia (Plurinational State of)</option>
                          <option value="1">Bolivia (Plurinational State of)</option>
                          <option value="2">Botswana</option>
                          <option value="3">Brazil</option>
                          <option value="1">Brunei Darussalam</option>
                          <option value="2">Bulgaria</option>
                          <option value="3">Burkina Faso</option>
                          <option value="1">Burundi</option>
                          <option value="2">Cabo Verde</option>
                          <option value="3">Cambodia</option>
                          <option value="1">Cameroon</option>
                          <option value="2">Canada</option>
                          <option value="3">Central African Republic</option>
                          <option value="1">Chad</option>
                          <option value="2">Chile</option>
                          <option value="3">China</option>
                          <option value="1">Colombia</option>
                          <option value="2">Comoros</option>
                          <option value="3">Congo</option>
                          <option value="1">Congo, Democratic Republic of the</option>
                          <option value="2">Costa Rica</option>
                          <option value="3">Côte d'Ivoire</option>
                          <option value="1">Croatia</option>
                          <option value="2">Cuba</option>
                          <option value="3">Cyprus</option>
                          <option value="1">Czechia</option>
                          <option value="2">Denmark</option>
                          <option value="3">Djibouti</option>
                          <option value="1">Dominica</option>
                          <option value="2">Dominican Republic</option>
                          <option value="3">Ecuador</option>
                          <option value="1">Egypt</option>
                          <option value="2">El Salvador</option>
                          <option value="3">Equatorial Guinea</option>
                          <option value="1">Eritrea</option>
                          <option value="2">Estonia</option>
                          <option value="3">Eswatini</option>
                          <option value="1">Ethiopia</option>
                          <option value="2">Fiji</option>
                          <option value="3">Finland</option>
                          <option value="1">France</option>
                          <option value="2">Gabon</option>
                          <option value="3">Gambia</option>
                          <option value="1">Georgia</option>
                          <option value="2">Germany</option>
                          <option value="3">Ghana</option>
                          <option value="1">Greece</option>
                          <option value="2">Grenada</option>
                          <option value="3">Guatemala</option>
                          <option value="1">Guinea</option>
                          <option value="2">Guinea-Bissau</option>
                          <option value="3">Guyana</option>
                          <option value="1">Haiti</option>
                          <option value="2">Honduras</option>
                          <option value="3">Hungary</option>
                          <option value="1">Iceland</option>
                          <option value="2">India</option>
                          <option value="3">Indonesia</option>
                          <option value="1">Iran (Islamic Republic of)</option>
                          <option value="2">Iraq</option>
                          <option value="3">Ireland</option>
                          <option value="1">Israel</option>
                          <option value="2">Italy</option>
                          <option value="3">Jamaica</option>
                          <option value="1">Japan</option>
                          <option value="2">Jordan</option>
                          <option value="3">Kazakhstan</option>
                          <option value="1">Kenya</option>
                          <option value="2">Kiribati</option>
                          <option value="3">Korea (Democratic People's Republic of)</option>
                          <option value="1">Korea, Republic of</option>
                          <option value="2">Kuwait</option>
                          <option value="3">Kyrgyzstan</option>
                          <option value="1">Lao People's Democratic Republic</option>
                          <option value="2">Latvia</option>
                          <option value="3">Lebanon</option>
                          <option value="1">Lesotho</option>
                          <option value="2">Liberia</option>
                          <option value="3">Libya</option>
                          <option value="1">Liechtenstein</option>
                          <option value="2">Lithuania</option>
                          <option value="3">Luxembourg</option>
                          <option value="1">Madagascar</option>
                          <option value="2">Malawi</option>
                          <option value="3">Malaysia</option>
                          <option value="1">Maldives</option>
                          <option value="2">Mali</option>
                          <option value="3">Malta</option>
                          <option value="1">Marshall Islands</option>
                          <option value="2">Mauritania</option>
                          <option value="3">Mauritius</option>
                          <option value="1">Mexico</option>
                          <option value="1">Micronesia (Federated States of)</option>
                          <option value="2">Moldova, Republic of</option>
                          <option value="3">Monaco</option>
                          <option value="1">Mongolia</option>
                          <option value="2">Montenegro</option>
                          <option value="3">Morocco</option>
                          <option value="1">Mozambique</option>
                          <option value="2">Myanmar</option>
                          <option value="3">Namibia</option>
                          <option value="1">Nauru</option>
                          <option value="2">Nepal</option>
                          <option value="3">Netherlands</option>
                          <option value="1">New Zealand</option>
                          <option value="2">Nicaragua</option>
                          <option value="3">Niger</option>
                          <option value="1">Nigeria</option>
                          <option value="2">North Macedonia</option>
                          <option value="3">Norway</option>
                          <option value="1">Oman</option>
                          <option value="2">Pakistan</option>
                          <option value="3">Palau</option>
                          <option value="1">Panama</option>
                          <option value="2">Papua New Guinea</option>
                          <option value="3">Paraguay</option>
                          <option value="1">Peru</option>
                          <option value="2">Philippines</option>
                          <option value="3">Poland</option>
                          <option value="1">Portugal</option>
                          <option value="2">Qatar</option>
                          <option value="3">Romania</option>
                          <option value="1">Russian Federation</option>
                          <option value="2">Rwanda</option>
                          <option value="3">Saint Kitts and Nevis</option>
                          <option value="1">Saint Lucia</option>
                          <option value="2">Saint Vincent and the Grenadines</option>
                          <option value="3">Samoa</option>
                          <option value="1">San Marino</option>
                          <option value="2">Sao Tome and Principe</option>
                          <option value="3">Saudi Arabia</option>
                          <option value="1">Senegal</option>
                          <option value="2">Ser</option>
                          <option value="3">Seychelles</option>
                          <option value="1">Sierra Leone</option>
                          <option value="2">Singapore</option>
                          <option value="3">Slovakia</option>
                          <option value="1">Slovenia</option>
                          <option value="2">Solomon Islands</option>
                          <option value="3">Somalia</option>
                          <option value="1">South Africa</option>
                          <option value="2">South Sudan</option>
                          <option value="3">Spain</option>
                          <option value="1">Sri Lanka</option>
                          <option value="2">Sudan</option>
                          <option value="3">Suriname</option>
                          <option value="1">Sweden</option>
                          <option value="2">Switzerland</option>
                          <option value="3">Syrian Arab Republic</option>
                          <option value="1">Tajikistan</option>
                          <option value="2">Tanzania, United Republic of</option>
                          <option value="Thailand" selected>Thailand</option>
                          <option value="1">Timor-Leste</option>
                          <option value="2">Togo</option>
                          <option value="3">Tonga</option>
                          <option value="1">Trinidad and Tobago</option>
                          <option value="2">Tunisia</option>
                          <option value="3">Turkey</option>
                          <option value="1">Turkmenistan</option>
                          <option value="2">Tuvalu</option>
                          <option value="3">Uganda</option>
                          <option value="1">Ukraine</option>
                          <option value="2">United Arab Emirates</option>
                          <option value="3">United Kingdom of Great Britain and Northern Ireland</option>
                          <option value="1">United States of America</option>
                          <option value="2">Uruguay</option>
                          <option value="3">Uzbekistan</option>
                          <option value="1">Vanuatu</option>
                          <option value="2">Venezuela (Bolivarian Republic of)</option>
                          <option value="3">Viet Nam</option>
                          <option value="1">Yemen</option>
                          <option value="2">Zambia</option>
                          <option value="3">Zimbabwe</option>
                        </select>
                    </div>
                    </div>


                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Payment</button>
                    </div>
                </form> -->
                <form id="myform" method="post" action="{{ secure_url('api/charge2c2p') }}">
                  <input type="hidden" name="version" value="8.5"/>
                  <input type="hidden" name="merchant_id" value="JT01"/>
                  <input type="hidden" name="currency" id="currency" value="764"/>
                  <input type="hidden" name="result_url_1" value="http://localhost:8000/happypay/public/responsepage"/>
                  <input type="hidden" name="enable_store_card" value="Y"/>
                  <input type="hidden" name="request_3ds" value="Y"/>
                  <input type="hidden" name="payment_option" value="CC"/>
                  <input type="hidden" name="hash_value" value=""/>
                  PRODUCT INFO : <input type="text" name="payment_description" id="payment_description" value="ทดสอบการชำระเงิน"  readonly/><br/>
                  ORDER NO : <input type="text" name="order_id" id="order_id" value="2021012800001" /><br/>
                  AMOUNT: <input type="text" name="amount" id="amount" value="20" /><br/>
                  <input type="submit" name="submit" value="Confirm" />
                </form>  
            </div>
        </div>
    </div>
</body>

</html>