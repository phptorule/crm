<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
  </head>
  <body style="background-color:#ffffff; font-weight:bold; color:#000000;">
    <div class="container">
        <div class="row">


        @foreach($data as $finances)
            <h3 style="text-align:center;">Faktura pro forma Nr {{$finances->finances_id}}</h1>

            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <p>Name firm: {{$team->teams_name}}</p>
                <p>Ulaca:</p>
                <ul>
                    <li>Kod: {{$team->teams_invoice_postcode}}</li>
                    <li>Province: {{$team->teams_invoice_province}}</li>
                    <li>Region: {{$team->teams_invoice_region}}</li>
                    <li>Street: {{$team->teams_invoice_street}}</li>
                    <li>Town: {{$team->teams_invoice_town}}</li>
                </ul>
                <p>Number NIP: {{$team->teams_nip}}</p>
                <p>Phone: {{$team->teams_phone}}</p>
            </div>

            
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <p>Name firm: {{$finances->finances_customer_name}}</p>
                <p>Ulaca:</p>
                <ul>
                    <li>Kod: {{$finances->finances_invoice_post_code}}</li>
                    <li>province: {{$finances->finances_invoice_province}}</li>
                    <li>region: {{$finances->finances_invoice_region}}</li>
                    <li>street: {{$finances->finances_invoice_street}}</li>
                    <li>town: {{$finances->finances_invoice_town}}</li>
                </ul>
                <p>NIP: {{$finances->finances_number}}</p>
            </div>

            <div class="clearfix"></div>
            <hr>

            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <p>Data wystawienia: {{$finances->finances_issue_date}}</p>
                <p>Termin platności: {{$finances->finances_payment_date }}</p>
            </div>

            <div class="clearfix"></div>


            <div class="table-responsive">
                <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="info">
                            <th>№</th>
                            <th>Nazva</th>
                            <th>Iiosc</th>
                            <th>Jm</th>
                            <th>Cena netto</th>
                            <th>Suma brutto</th>
                        </tr>
                    </thead>


                    <?php $i=1; ?>
                    @foreach($products as $product)
                    <tbody>
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$product->products_name}}</td>
                            <td>{{$product->products_amount}}</td>
                            <td></td>
                            <td>{{$product->products_vat_amount}}</td>
                            <td>{{$product->products_total_cost}}</td>
                        </tr>
                    </tbody>
                    <?php $i++; ?>
                    @endforeach
                    <tbody>
                        <tr>
                            <td>Razom do zaplatu: {{$finances->finances_total_amount}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>



        @endforeach

        </div>

    </div>

  </body>
</html>



