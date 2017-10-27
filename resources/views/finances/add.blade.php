<div class="row" data-ng-controller="FinancesCtrl" ng-init="init()">
    <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="btn-group" id="buttonlist">
                    <h3>Informacje podstawowe</h3>
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
                                        <input type="text" class="form-control" name="finance_number" required />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Data wystawlenia</label>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="input-group custom-datapicker-input">
                                            <input type="text" class="form-control" name="invoice_date" uib-datepicker-popup="dd/MM/yyyy" ng-model="invoice_date" is-open="date[0].opened" show-button-bar="false" datepicker-options="dateOptions" required="required" />
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-default" ng-click="calendarOpen(0)"><i class="glyphicon glyphicon-calendar"></i></button>
                                            </span>
                                        </div>
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
                                            <option ng-repeat="user in getUsersList()" value="@{{ user.users_id }}">@{{ user.users_first_name + ' ' + user.users_last_name }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Sposób płatności</label>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <select class="form-control" name="assign_to" ng-model="finances.pay_type" required>
                                            <option value="0">Gotówką</option>
                                            <option value="1">Przelew </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <p>(<span class="req_field">*</span>) - required fields</p>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="btn-group" id="buttonlist">
                    <h3>Informacje adresowe</h3>
                </div>

                <div class="custom_panel_item pull-right">
                    <a href="javascript:void(0);" ng-click="copySendAddress()">Kopiuj adres wysylki <i class="fa fa-clone"></i></a>
                    <a href="javascript:void(0);" ng-click="copyInvoiceAddress()">Kopiuj adres do faktury <i class="fa fa-clone"></i></a>
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
                <p>(<span class="req_field">*</span>) - required fields</p>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="btn-group" id="buttonlist">
                    <h3>Producty i usługi</h3>
                </div>
            </div>

            <div class="panel-body">
                <form name="form_products" method="post" novalidate="novalidate">
                    <table id="finances_product_table" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr class="info">
                                <th>Nazwa pozycji<span class="req_field"> *</span></th>
                                <th>Ilosc<span class="req_field"> *</span></th>
                                <th>Waluta</th>
                                <th>Cena<span class="req_field"> *</span></th>
                                <th>Suma netto</th>
                                <th>Suma brutto</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="product_name" ng-model="finances.product_name" required />
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="product_count" ng-model="finances.product_count" required />
                                    </div>
                                </td>

                                <td>
                                    <select class="form-control" name="currency" ng-model="finances.currency" required>
                                        <option selected="selected" value="0">PLN</option>
                                        <option value="1">EUR</option>
                                        <option value="2">USD</option>
                                    </select>
                                </td>

                                <td class="text-right discount">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="product_cost" ng-model="finances.product_cost" required />
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-add" ng-click="discount_window = ! discount_window">Rabat</button>
                                        <div class="discount_window" ng-show="discount_window">
                                            <div class="discount_header">
                                                <h4>Kwota całkowita netto: @{{ getSumWithDiscount() }}</h4>
                                                <button type="button" class="close" ng-click="discount_window = ! discount_window" aria-hidden="true">×</button>
                                            </div>

                                            <div class="form-group">
                                                <input type="radio" id="square-radio-1" ng-model="discount_radio" ng-click="setDiscount('without')" value="without" />
                                                <label for="square-radio-1">Bez rabatu</label>
                                            </div>

                                            <div class="discount_block">
                                                <div class="form-group">
                                                    <input type="radio" id="square-radio-2" ng-model="discount_radio" ng-click="setDiscount('percent')" value="percent"  />
                                                    <label for="square-radio-2">% Procentowy</label>

                                                    <div class="discount_input pull-right" ng-show="discount_radio == 'percent'">
                                                        <input type="text" class="form-control" ng-model="discount_percent" name="discount_percent" /> %
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="discount_block">
                                                <div class="form-group">
                                                    <input type="radio" id="square-radio-3" ng-model="discount_radio" ng-click="setDiscount('regular')" value="regular" />
                                                    <label for="square-radio-3">Wartosciowy</label>

                                                    <div class="discount_input pull-right" ng-show="discount_radio == 'regular'">
                                                        <input type="text" class="form-control" ng-model="discount_regular" name="discount_regular" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <span>Po rabacie:</span>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-add" ng-click="vat_window = ! vat_window">Podatek VAT</button>
                                        <div class="vat_window" ng-show="vat_window">
                                            <div class="discount_header">
                                                <h4>Kwota netto: @{{ getSumWithDiscount() }}</h4>
                                                <button type="button" class="close" ng-click="vat_window = ! vat_window" aria-hidden="true">×</button>
                                            </div>

                                            <div class="discount_block">
                                                <div class="form-group">
                                                    <div class="discount_input">
                                                        <input type="text" class="form-control" ng-model="product_vat" name="product_vat" /> %
                                                    </div>

                                                    <div class="discount_input pull-right">
                                                        VAT <input type="text" class="form-control" ng-model="product_vat_sum" name="product_vat_sum" disabled="disabled" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group">@{{ getSumNetto() }}</div>
                                    <div class="form-group">@{{ getDiscount() }}</div>
                                    <div class="form-group">@{{ getSumWithDiscount() }}</div>
                                    <div class="form-group">@{{ getVat() }}</div>
                                </td>

                                <td>
                                    <div class="form-group">&nbsp;</div>
                                    <div class="form-group">&nbsp;</div>
                                    <div class="form-group">&nbsp;</div>
                                    <div class="form-group">@{{ getSumBrutto() }}</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <footer class="table-footer">
                        <p>(<span class="req_field">*</span>) - required fields</p>
                    </footer>
               </form>
            </div>
        </div>
    </div>

    <div class="col-sm-12 text-right">
        <button type="submit" class="btn btn-add" ng-click="save()">Zapisc</button>
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

                   <footer class="table-footer">
                        <div class="row">
                            <div class="col-md-offset-6 col-md-6 text-right pagination-container">
                                <div data-pagination="" data-num-pages="numPages()" data-current-page="currentPage" data-max-size="maxSize" data-boundary-links="true"></div>
                            </div>
                        </div>
                    </footer>
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