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
            <h3 class="title">Faktura pro forma Nr {{$finances->finances_number}}</h3>

            <div class="left_block" class="col-xs-6">
                <p>Spzedawca: {{$team->teams_name}}</p>
                <p>Adres: {{$team->teams_invoice_street}}, {{$team->teams_invoice_postcode}}, <br /> {{$team->teams_invoice_town}}</p>
                <p>NIP: {{$team->teams_nip}}</p>
                <p>Phone: {{$team->teams_phone}}</p>
            </div>


            <div class="right_block" class="col-xs-6">
                <p>Nabywca: {{$finances->finances_customer_name}}</p>
                <p>Adres: {{$finances->finances_invoice_street}}, {{$finances->finances_invoice_post_code}}, <br /> {{$finances->finances_invoice_town}}</p>
                <p>NIP: {{$finances->finances_nip}}</p>
            </div>

            <div class="clearfix"></div>
            <hr>

            <div class="col-xs-6">
                <p>Data wystawienia: {{$finances->finances_issue_date}}</p>
                <p>Termin platnosci: {{$finances->finances_payment_date }}</p>
            </div>

            <div class="clearfix"></div>


            <div class="table-responsive">
                <table id="dataTableExample1" class="table table-bordered table-striped table-hover">

                        <tr class="info">
                            <th>Lp.</th>
                            <th>Nazwa</th>
                            <th>Iłość</th>
                            <th>J.m.</th>
                            <th>Cena netto</th>
                            <th>Wartość netto</th>
                            <th>Rabat, %</th>
                            <th>Wartość po rabacie</th>
                            <th>Stawka VAT, %</th>
                            <th>Kwota VAT</th>
                            <th>Wartość brutto</th>
                        </tr>


                    <?php $i=1; ?>
                    @foreach($products as $product)

                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$product->products_name}}</td>
                            <td>{{$product->products_amount}}</td>
                            <td>{{$product->products_dimension}}</td>
                            <td>{{$product->products_cost}}</td>
                            <td>{{$product->products_cost}}</td>
                            <td>{{$product->products_discount_percent}}</td>
                            <td>{{$product->products_discount_amount}}</td>
                            <td>{{$product->products_vat_percent}}</td>
                            <td>{{$product->products_vat_amount}}</td>
                            <td>{{$product->products_total_cost}}</td>
                        </tr>

                    <?php $i++; ?>
                    @endforeach

                        <tr>
                            <td>Razem do zapłąty: {{$finances->finances_total_amount}}</td>
                        </tr>

                </table>
            </div>



        @endforeach

        </div>

    </div>
</div>


  </body>
</html>



