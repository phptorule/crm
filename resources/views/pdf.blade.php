<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link href="/css/app.css" rel="stylesheet" type="text/css"/>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
        <script src="https://code.jquery.com/jquery-1.12.3.min.js"></script>
        <style>
            #container{ font-family: DejaVu Sans, sans-serif; font-size: 12px;}
            .customers_table td {
                padding: 5px;
                vertical-align: top;
                text-transform: uppercase;
                font-weight: 400;
            }
        </style>
    </head>

    <body>
        <div id="pdf">
            <div class="container" id="container">
                <h2 class="title text-center mb-30"><b>Faktura pro forma Nr {{$finances->finances_number}}</b></h2>

                <div class="row">
                    <table class="col-xs-6 customers_table">
                        <tr>
                            <td class="text-right">Spzedawca:</td>
                            <td>{{$team['teams_name']}}</td>
                        </tr>

                        <tr>
                            <td class="text-right pdf_adress">Adres:</td>
                            <td>{{$team['teams_invoice_street']}}, {{$team['teams_invoice_postcode']}}, <br /> {{$team['teams_invoice_town']}}</td>
                        </tr>

                        <tr>
                            <td class="text-right">NIP:</td>
                            <td>{{$team['teams_nip']}}</td>
                        </tr>

                        <tr class="pdf_line">
                            <td class="text-right">Phone:</td>
                            <td>{{$team['teams_phone']}}</td>
                        </tr>

                        <tr>
                            <td class="text-right">Data wystawienia:</td>
                            <td>{{$finances['finances_issue_date']}}</td>
                        </tr>

                        <tr>
                            <td class="text-right">Termin platnosci:</td>
                            <td>{{$finances['finances_payment_date']}}</td>
                        </tr>

                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>

                    <table class="col-xs-6 customers_table">
                        <tr>
                            <td class="text-right">Nabywca:</td>
                            <td>{{$finances['finances_customer_name']}}</td>
                        </tr>

                        <tr>
                            <td class="text-right">Adres:</td>
                            <td>{{$finances['finances_invoice_street']}}, {{$finances['finances_invoice_post_code']}}, <br /> {{$finances['finances_invoice_town']}}</td>
                        </tr>

                        <tr>
                            <td class="text-right">NIP:</td>
                            <td>{{$finances['finances_nip']}}</td>
                        </tr>

                        <tr class="pdf_line">
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>

                        <tr>
                            <td class="text-right">Sposób płatności:</td>
                            <td>{{$finances['finances_payment_method'] == 0 ? 'Gotówką' : 'Przelew'}}</td>
                        </tr>

                        <tr>
                            <td class="text-right">Bank:</td>
                            <td>{{$team['teams_bank_name']}}</td>
                        </tr>

                        <tr>
                            <td class="text-right">Numer konta:</td>
                            <td>{{$team['teams_nip']}}</td>
                        </tr>
                    </table>
                </div>

                <table class="table table-responsive table-bordered table-striped">
                    <tr class="info">
                        <th class="pdf_number">Lp.</th>
                        <th>Nazwa</th>
                        <th class="pdf_amount">Iłość</th>
                        <th class="pdf_dimension">J.m.</th>
                        <th class="pdf_cost_netto">Cena netto</th>
                        <th class="pdf_cost_netto">Wartość netto</th>
                        <th class="pdf_discount_percent">Rabat, %</th>
                        <th class="pdf_cost_with_discount">Wartość po rabacie</th>
                        <th class="pdf_vat_percent">Stawka VAT, %</th>
                        <th class="pdf_vat_amount">Kwota VAT</th>
                        <th class="pdf_total_cost">Wartość brutto</th>
                    </tr>

                <?php $i=1; ?>
                @foreach($products as $product)

                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$product['products_name']}}</td>
                        <td>{{$product['products_amount']}}</td>
                        <td>{{$product['products_dimension']}}</td>
                        <td>{{$product['products_cost']}}</td>
                        <td>{{$product['products_cost']}}</td>
                        <td>{{$product['products_discount_percent']}}</td>
                        <td>{{$product['products_cost_with_discount']}}</td>
                        <td>{{$product['products_vat_percent']}}</td>
                        <td>{{$product['products_vat_amount']}}</td>
                        <td>{{$product['products_total_cost']}}</td>
                    </tr>

                <?php $i++; ?>
                @endforeach

                @if ( ! empty($products[0]->products_shipping_price))
                    <tr>
                        <td>{{$i}}</td>
                        <td>Koszt przesyłki</td>
                        <td>1</td>
                        <td>&nbsp;</td>
                        <td>{{$products[0]['products_shipping_price']}}</td>
                        <td>{{$products[0]['products_shipping_price']}}</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>{{$products[0]['products_vat_shipping_percent']}}</td>
                        <td>{{$products[0]['products_vat_shipping_amount']}}</td>
                        <td>{{$products[0]['products_vat_shipping_amount']}}</td>
                    </tr>

                @endif

                    <tr>
                        <td colspan="2" class="pfd_total_sum">Razem do zapłąty: {{$finances['finances_total_amount']}}</td>
                    </tr>
                </table>
            </div>
        </div>

    </body>
</html>



