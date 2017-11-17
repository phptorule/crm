<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.3.min.js"></script>
    <script type="text/javascript">
        window.close();
    </script>
  </head>

  <body style="background-color:#ffffff; font-weight:bold; color:#000000;">
    <style>
       .title{
            text-align: center;
       }
       .left_block{
            float: left;
            width: 50%;
        }
        .right_block{
            width: 50%;
            float: right;
        }
        .clearfix{
            clear: both;
        }
        .table{
            width: 100%;
        }
        .table tr, th, td{
            border: 1px #000000 solid;
        }
        .info{
            background-color: #d4d4d4;
        }
  </style>


<div id="pdf">
    <div class="container" id="container">
        <div class="row">



        @foreach($data as $finances)
            <h3 class="title">Faktura pro forma Nr {{$finances->finances_id}}</h3>

            <div class="left_block" class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
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


            <div class="right_block" class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
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
                <p>Termin platnosci: {{$finances->finances_payment_date }}</p>
            </div>

            <div class="clearfix"></div>


            <div class="table-responsive">
                <table id="dataTableExample1" class="table table-bordered table-striped table-hover">

                        <tr class="info">
                            <th>Number</th>
                            <th>Nazva</th>
                            <th>Iiosc</th>
                            <th>Jm</th>
                            <th>Cena netto</th>
                            <th>Suma brutto</th>
                        </tr>


                    <?php $i=1; ?>
                    @foreach($products as $product)

                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$product->products_name}}</td>
                            <td>{{$product->products_amount}}</td>
                            <td>{{$product->products_discount_amount}}</td>
                            <td>{{$product->products_vat_amount}}</td>
                            <td>{{$product->products_total_cost}}</td>
                        </tr>

                    <?php $i++; ?>
                    @endforeach

                        <tr>
                            <td>Razom do zaplatu: {{$finances->finances_total_amount}}</td>
                        </tr>

                </table>
            </div>



        @endforeach

        </div>

    </div>
</div>


  </body>
</html>



