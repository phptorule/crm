<div class="row" data-ng-controller="FinancesCtrl" ng-init="init()">
    <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="btn-group" id="buttonlist">
                    <h3>Informacje podstawowe</h3>
                </div>

                <div class="custom_panel_item pull-right" ng-show="finances_id">
                    <a href="javascript:void(0);" ng-show=" ! edit_general" ng-click="editFinances('general')">Edytuj dane <i class="panel-control-icon ti-pencil"></i></a>
                </div>

                <div class="custom_panel_item pull-right" ng-show="edit_general">
                    <a href="javascript:void(0);" ng-click="save()">Zapisz <i class="fa fa-floppy-o"></i></a>
                </div>

                <div class="custom_panel_item pull-right" ng-show="edit_general">
                    <a href="javascript:void(0);" ng-click="cancelEdit('general')">Anuluj</a>
                </div>
            </div>

            <div class="panel-body">
                <form class="no-transition" name="form" method="post" novalidate="novalidate">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Klient</label><span class="req_field"> *</span>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="customer" disabled="disabled" ng-model="finances.company_name" required />
                                    </div>

                                    <div class="col-sm-6">
                                        <button class="btn btn-exp btn-sm dropdown-toggle" ng-click="selectCustomer()"><i class="fa fa-bars"></i> Wybierz Kontrahenta</button>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Numer faktury</label>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="finance_number" ng-model="finances_number" disabled="disabled" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Sposób płatności</label>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <select class="form-control" ng-model="pay_type" required>
                                            <option value="0">Gotówką</option>
                                            <option value="1">Przelew </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Zaplacona</label>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <select class="form-control" name="invoice_paid" ng-model="invoice_paid">
                                            <option value="0">Nie</option>
                                            <option value="1">Tak</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Data wystawienia</label>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="input-group custom-datapicker-input">
                                            <input type="text" class="form-control" name="issue_date" uib-datepicker-popup="dd/MM/yyyy" ng-model="issue_date" is-open="date[0].opened" show-button-bar="false" datepicker-options="dateOptions" required="required" />
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-default" ng-click="calendarOpen(0)"><i class="glyphicon glyphicon-calendar"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Termin platności</label><span class="req_field"> *</span>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="input-group custom-datapicker-input">
                                            <input type="text" class="form-control" name="payment_date" uib-datepicker-popup="dd/MM/yyyy" ng-model="payment_date" is-open="date[1].opened" show-button-bar="false" datepicker-options="dateOptions" required />
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-default" ng-click="calendarOpen(1)"><i class="glyphicon glyphicon-calendar"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Przypisany do</label><span class="req_field"> *</span>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <select class="form-control" name="assign_to" ng-model="finances.assign_to" required>
                                            <option ng-repeat="user in team_users" value="@{{ user.users_id }}">@{{ user.users_first_name + ' ' + user.users_last_name }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="btn-group" id="buttonlist">
                    <h3>Informacje adresowe</h3>
                </div>

                <div class="custom_panel_item pull-right" ng-show="finances_id">
                    <a href="javascript:void(0);" ng-show=" ! edit_address" ng-click="editFinances('address')">Edytuj dane <i class="panel-control-icon ti-pencil"></i></a>
                </div>

                <div class="custom_panel_item pull-right" ng-show="edit_address">
                    <a href="javascript:void(0);" ng-click="save()">Zapisz <i class="fa fa-floppy-o"></i></a>
                </div>

                <div class="custom_panel_item pull-right" ng-show="edit_address">
                    <a href="javascript:void(0);" ng-click="cancelEdit('address')">Anuluj</a>
                </div>
            </div>

            <div class="panel-body">
                <form class="no-transition" name="form_address" method="post" novalidate="novalidate">
                    <div class="row">
                        <div class="col-sm-6">
                            <h4>Adres do faktury</h4>
                            <div class="form-group">
                                <label>Ulica</label><span class="req_field"> *</span>
                                <input type="text" class="form-control" name="invoice_street" ng-model="finances.invoice_street" required />
                            </div>

                            <div class="form-group">
                                <label>Skrytka Pocztowa</label>
                                <input type="text" class="form-control" name="invoice_mailbox" ng-model="finances.invoice_mailbox" />
                            </div>

                            <div class="form-group">
                                <label>Miejscowosc</label>
                                <input type="text" class="form-control" name="invoice_town" ng-model="finances.invoice_town" />
                            </div>

                            <div class="form-group">
                                <label>Wojewodztwo</label>
                                <input type="text" class="form-control" name="invoice_province" ng-model="finances.invoice_province"  />
                            </div>

                            <div class="form-group">
                                <label>Kod</label>
                                <input type="text" class="form-control" name="invoice_post_code" ng-model="finances.invoice_post_code" />
                            </div>

                            <div class="form-group">
                                <label>Kraj</label>
                                <input type="text" class="form-control" name="invoice_region" ng-model="finances.invoice_region" />
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <h4>Adres do wysylki</h4>
                            <div class="form-group">
                                <label>Ulica</label><span class="req_field"> *</span>
                                <input type="text" class="form-control" name="send_street" ng-model="finances.send_street" required />
                            </div>

                            <div class="form-group">
                                <label>Skrytka Pocztowa</label>
                                <input type="text" class="form-control" name="send_mailbox" ng-model="finances.send_mailbox" />
                            </div>

                            <div class="form-group">
                                <label>Miejscowosc</label>
                                <input type="text" class="form-control" name="send_town" ng-model="finances.send_town" />
                            </div>

                            <div class="form-group">
                                <label>Wojewodztwo</label>
                                <input type="text" class="form-control" name="send_province" ng-model="finances.send_province" />
                            </div>

                            <div class="form-group">
                                <label>Kod</label>
                                <input type="text" class="form-control" name="send_post_code" ng-model="finances.send_post_code" />
                            </div>

                            <div class="form-group">
                                <label>Kraj</label>
                                <input type="text" class="form-control" name="send_region" ng-model="finances.send_region" />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="btn-group" id="buttonlist">
                    <h3>Produkty i usługi</h3>
                </div>

                <div class="custom_panel_item pull-right" ng-show="finances_id">
                    <a href="javascript:void(0);" ng-show=" ! edit_products" ng-click="editFinances('products')">Edytuj dane <i class="panel-control-icon ti-pencil"></i></a>
                </div>

                <div class="custom_panel_item pull-right" ng-show="edit_products">
                    <a href="javascript:void(0);" ng-click="save()">Zapisz <i class="fa fa-floppy-o"></i></a>
                </div>

                <div class="custom_panel_item pull-right" ng-show="edit_products">
                    <a href="javascript:void(0);" ng-click="cancelEdit('products')">Anuluj</a>
                </div>
            </div>

            <div class="panel-body product_block">
                <form name="form_products" class="no-transition" method="post" novalidate="novalidate">
                    <input type="hidden" name="products_ids" ng-model="finances.products_ids" required="" />
                    <table id="finances_product_table" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr class="info">
                                <th>Typ pozycji</th>
                                <th class="product_name_column">Nazwa pozycji<span class="req_field"> *</span></th>
                                <th class="product_small_column">Ilosc<span class="req_field" ng-show="products.products_type == 0"> *</span></th>
                                <th class="product_small_column">Jm</th>
                                <th>Waluta</th>
                                <th>Cena<span class="req_field"> *</span></th>
                                <th>Suma netto</th>
                                <th>Suma brutto</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr ng-repeat="(k, products) in productsList">
                                <td>
                                    <select class="form-control" name="invoice_type" ng-model="productsList[k].products_type">
                                        <option value="0">Produkt</option>
                                        <option value="1">Usługa</option>
                                    </select>
                                </td>

                                <td class="product_name_column">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="product_name_@{{ k }}" ng-model="productsList[k].products_name" required />
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="product_amount" ng-change="getProductCost(k)" ng-show="productsList[k].products_type == 0" ng-model="productsList[k].products_amount" required />
                                        <input type="text" class="form-control" ng-change="getProductCost(k)" ng-show="productsList[k].products_type == 1" ng-model="productsList[k].products_amount" />
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="product_dimension" ng-model="productsList[k].products_dimension" maxlength="4" />
                                    </div>
                                </td>

                                <td>
                                    <select class="form-control" name="currency" ng-model="productsList[k].products_currency">
                                        <option value="0">PLN</option>
                                        <option value="1">EUR</option>
                                        <option value="2">USD</option>
                                    </select>
                                </td>

                                <td class="text-right discount">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="product_cost_@{{ k }}" ng-change="getProductCost(k)" ng-model="productsList[k].products_cost" required />
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-add" ng-click="openDiscount(k)">Rabat</button>
                                        <div class="discount_window" ng-show="discount_window[k]">
                                            <div class="discount_header">
                                                <h4>Kwota całkowita netto: @{{ productsList[k].cost_with_discount.toFixed(2) }}</h4>
                                                <button type="button" class="close" ng-click="discount_window[k] = ! discount_window[k]" aria-hidden="true">×</button>
                                            </div>

                                            <div class="form-group">
                                                <input type="radio" id="radio-1-@{{ k }}" ng-model="discount_radio[k]" ng-click="setDiscount(k, 'without')" value="without" />
                                                <label for="radio-1-@{{ k }}">Bez rabatu</label>
                                            </div>

                                            <div class="discount_block">
                                                <div class="form-group">
                                                    <input type="radio" id="radio-2-@{{ k }}" ng-model="discount_radio[k]" ng-click="setDiscount(k, 'percent')" value="percent" />
                                                    <label for="radio-2-@{{ k }}">% Procentowy</label>

                                                    <div class="discount_input pull-right" ng-show="discount_radio[k] == 'percent'">
                                                        <input type="text" class="form-control" ng-change="getProductCost(k)" ng-model="productsList[k].discount_percent" name="discount_percent" /> %
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="discount_block">
                                                <div class="form-group">
                                                    <input type="radio" id="radio-3-@{{ k }}" ng-model="discount_radio[k]" ng-click="setDiscount(k, 'regular')" value="regular" />
                                                    <label for="radio-3-@{{ k }}">Wartosciowy</label>

                                                    <div class="discount_input pull-right" ng-show="discount_radio[k] == 'regular'">
                                                        <input type="text" class="form-control" ng-change="getProductCost(k)" ng-model="productsList[k].discount_regular" name="discount_regular" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <span>Po rabacie:</span>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-add" ng-click="openTax(k)">Podatek VAT</button>
                                        <div class="vat_window" ng-show="vat_window[k]">
                                            <div class="discount_header">
                                                <h4>Kwota netto: @{{ (productsList[k].cost_with_discount ? productsList[k].cost_with_discount : productsList[k].cost_netto).toFixed(2) }}</h4>
                                                <button type="button" class="close" ng-click="vat_window[k] = ! vat_window[k]" aria-hidden="true">×</button>
                                            </div>

                                            <div class="discount_block">
                                                <div class="form-group">
                                                    <div class="discount_input">
                                                        <input type="text" class="form-control" ng-change="getProductCost(k)" ng-model="productsList[k].products_vat_percent" /> %
                                                    </div>

                                                    <div class="discount_input pull-right">
                                                        VAT <input type="text" class="form-control" ng-model="productsList[k].products_vat_amount" name="vat_amount" disabled="disabled" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group">@{{ productsList[k].cost_netto.toFixed(2) }}</div>
                                    <div class="form-group">@{{ productsList[k].discount_amount.toFixed(2) }}</div>
                                    <div class="form-group">@{{ productsList[k].cost_with_discount.toFixed(2) }}</div>
                                    <div class="form-group">@{{ productsList[k].products_vat_amount.toFixed(2) }}</div>
                                </td>

                                <td>
                                    <div class="form-group">&nbsp;</div>
                                    <div class="form-group">&nbsp;</div>
                                    <div class="form-group">&nbsp;</div>
                                    <div class="form-group">@{{ productsList[k].products_total_cost.toFixed(2) }}</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <footer class="table-footer">
                        <div class="form-group">
                            <button type="submit" class="btn btn-add" ng-click="addProduct()">Dodaj pozycję</button>
                        </div>
                    </footer>
               </form>

               <table id="finances_product_sum_table" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="info">
                            <th class="text-right">Wartosc brutto:</th>
                            <th class="product_total_sum">@{{ getTotalAmount().toFixed(2) }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td class="text-right discount_sum">
                                <div class="form-group">
                                    <span>Koszt przesyłki/dojazdu:</span>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-add" ng-click="vat_sum_window = ! vat_sum_window">Podatek od kosztow przesyłki</button>
                                    <div class="vat_sum_window" ng-show="vat_sum_window">
                                        <div class="discount_header">
                                            <h4>Koszt przesyłki/dojazdu: </h4>
                                            <button type="button" class="close" ng-click="vat_sum_window = ! vat_sum_window" aria-hidden="true">×</button>
                                        </div>

                                        <div class="discount_block">
                                            <div class="form-group">
                                                <div class="discount_input">
                                                    <input type="text" class="form-control" ng-model="products.vat_shipping_percent" name="vat_percent" /> %
                                                </div>

                                                <div class="discount_input pull-right">
                                                    VAT <input type="text" class="form-control" ng-model="products.vat_shipping_amount" name="vat_shipping_amount" disabled="disabled" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="form-group">
                                    <input type="text" class="form-control" ng-model="products.shipping_price" name="shipping_price" />
                                </div>

                                <div class="form-group">
                                    @{{ products.vat_shipping_amount.toFixed(2) }}
                                </div>
                            </td>
                        </tr>
                    </tbody>

                    <tfoot>
                        <tr>
                            <td class="text-right">Calkowita wartosc brutto:</td>
                            <td>@{{ getShippingTax().toFixed(2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <p>(<span class="req_field">*</span>) - Wymagane pola</p>
    </div>

    <div class="col-sm-12 text-right">
        <button type="submit" class="btn btn-add" ng-click="saveProduct()">Zapisc</button>
    </div>
</div>

<script type="text/ng-template" id="SelectCustomer.html">
    <div class="modal-header modal-header-primary" ng-init="initList()">
       <button type="button" class="close" ng-click="cancel()" aria-hidden="true">×</button>
       <h3><i class="fa fa-user m-r-5"></i> Kontrahenci</h3>
    </div>
    <div class="modal-body">
       <div class="row">
            <div class="col-md-12">
                <div class="modal_content_header">
                    <form>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Szukaj</label>
                                    <input type="text" class="form-control" name="search_input" placeholder="Szukaj" ng-model="searchInput" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <button class="btn btn-add pull-right" ng-click="addCustomer()">
                                    <i class="fa fa-plus"></i> Utwórz Kontrahenta
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table id="customers_table" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr class="info">
                                <th>Nazwa firmy</th>
                                <th>Numer NIP</th>
                                <th>Miejscowosc</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="customer in filteredCustomers | filter:searchInput">
                                <td><a href="javascript:void(0);" ng-click="getCustomer(customer)">@{{ customer.company_name }}</a></td>
                                <td>@{{ customer.nip }}</td>
                                <td>@{{ customer.invoice_town }}</td>
                            </tr>
                        </tbody>
                   </table>

                   <!--footer class="table-footer">
                        <div class="row">
                            <div class="col-md-offset-6 col-md-6 text-right pagination-container">
                                <pagination
                                    ng-model="currentPage"
                                    total-items="todos.length"
                                    max-size="maxSize"
                                    boundary-links="true">
                                </pagination>
                            </div>
                        </div>
                    </footer-->
                </div>
            </div>
        </div>
   </div>

   <div class="modal-footer">
      <button type="button" class="btn btn-danger pull-right" ng-click="cancel()">Anuluj</button>
   </div>
</script>

<script type="text/ng-template" id="CreateCustomer.html">
    <div class="modal-header modal-header-primary" ng-init="initList()">
       <button type="button" class="close" ng-click="cancel()" aria-hidden="true">×</button>
       <h3><i class="fa fa-user m-r-5"></i> Utwórz Kontrahenta</h3>
    </div>
    <div class="modal-body">
       <div class="row">
            <div class="col-md-12">
                <form class="no-transition" name="form" method="post" novalidate="novalidate">
                    <div class="row">
                        <div class="col-sm-12 mb-30">
                            <h3 class="modal_h3">Informacje podstawowe</h3>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Nazwa firmy</label><span class="req_field"> *</span>
                                        <input type="text" class="form-control" name="company_name" ng-model="customers.company_name" required />
                                    </div>

                                    <div class="form-group">
                                        <label>Numer NIP</label>
                                        <input type="text" class="form-control" name="nip" ng-model="customers.nip" />
                                    </div>

                                    <div class="form-group">
                                        <label>Osoba kontaktowa</label>
                                        <input type="text" class="form-control" name="contact_person" ng-model="customers.contact_person" />
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Telefon</label>
                                        <input type="text" class="form-control" name="phone_number" ng-model="customers.phone_number" />
                                    </div>

                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" class="form-control" name="email" ng-model="customers.email" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 mb-30">
                            <h3 class="modal_h3">Informacje adresowe do faktury</h3>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Ulica</label>
                                        <input type="text" class="form-control" name="invoice_street" ng-model="customers.invoice_street" />
                                    </div>

                                    <div class="form-group">
                                        <label>Skrytka Pocztowa do faktury</label>
                                        <input type="text" class="form-control" name="invoice_mailbox" ng-model="customers.invoice_mailbox" />
                                    </div>

                                    <div class="form-group">
                                        <label>Miejscowosc</label>
                                        <input type="text" class="form-control" name="invoice_town" ng-model="customers.invoice_town" />
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Wojewodztwo</label>
                                        <input type="text" class="form-control" name="invoice_province" ng-model="customers.invoice_province"  />
                                    </div>

                                    <div class="form-group">
                                        <label>Kod</label>
                                        <input type="text" class="form-control" name="invoice_post_code" ng-model="customers.invoice_post_code" />
                                    </div>

                                    <div class="form-group">
                                        <label>Kraj</label>
                                        <input type="text" class="form-control" name="invoice_region" ng-model="customers.invoice_region" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <h3 class="modal_h3">Informacje adresowe do wysylki</h3>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Ulica - Adres wysylki</label>
                                        <input type="text" class="form-control" name="send_street" ng-model="customers.send_street" />
                                    </div>

                                    <div class="form-group">
                                        <label>Skrytka Pocztowa do wysylki</label>
                                        <input type="text" class="form-control" name="send_mailbox" ng-model="customers.send_mailbox" />
                                    </div>

                                    <div class="form-group">
                                        <label>Miejscowosc - Adres wysylki</label>
                                        <input type="text" class="form-control" name="send_town" ng-model="customers.send_town" />
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Wojewodztwo - Adres wysylki</label>
                                        <input type="text" class="form-control" name="send_province" ng-model="customers.send_province" />
                                    </div>

                                    <div class="form-group">
                                        <label>Kod - Adres wysylki</label>
                                        <input type="text" class="form-control" name="send_post_code" ng-model="customers.send_post_code" />
                                    </div>

                                    <div class="form-group">
                                        <label>Kraj - Adres wysylki</label>
                                        <input type="text" class="form-control" name="send_region" ng-model="customers.send_region" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 text-right">
                            <button type="submit" class="btn btn-add" ng-click="saveCustomer()">{{ __('Dodaj nowego kontrahenta') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
   </div>

   <div class="modal-footer">
      <button type="button" class="btn btn-danger pull-right" ng-click="cancel()">Anuluj</button>
   </div>
</script>