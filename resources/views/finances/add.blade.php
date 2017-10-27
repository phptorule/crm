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
                                        <input type="text" class="form-control" name="customer" disabled="disabled" ng-model="finances.company_name" />
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
                        </div>

                        <div class="col-sm-6">
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

                            <div class="form-group">
                                <label>Termin platności</label><span class="req_field"> *</span>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="input-group custom-datapicker-input">
                                            <input type="text" class="form-control" name="payment_date" uib-datepicker-popup="dd/MM/yyyy" ng-model="payment_date" is-open="date[1].opened" show-button-bar="false" datepicker-options="dateOptions" required="required" />
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
                                        <select class="form-control" name="assign_to" ng-model="finances.assign_to">
                                            <option ng-repeat="user in getUsersList()" value="@{{ user.users_id }}">@{{ user.users_first_name + ' ' + user.users_last_name }}</option>
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
                                <input type="text" class="form-control" name="invoice_street" ng-model="finances.invoice_street" />
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
                                <input type="text" class="form-control" name="send_street" ng-model="finances.send_street" />
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
                <table id="finances_product_table" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="info">
                            <th>Nazwa pozycji</th>
                            <th>Ilosc</th>
                            <th>Waluta</th>
                            <th>Cena</th>
                            <th>Suma netto</th>
                            <th>Suma brutto</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="invoice_street" ng-model="finances.product_name" />
                                </div>
                            </td>

                            <td>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="invoice_street" ng-model="finances.product_count" />
                                </div>
                            </td>

                            <td>
                                <select class="form-control" ng-model="finances.currency">
                                    <option selected="selected" value="0">PLN</option>
                                    <option value="1">EUR</option>
                                    <option value="2">USD</option>
                                </select>
                            </td>

                            <td class="text-right discount">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="invoice_street" ng-model="finances.product_cost" />
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-add" ng-click="discount_window = ! discount_window">Rabat</button>
                                    <div class="discount_window" ng-show="discount_window">
                                        <div class="discount_header">
                                            <h4>Kwota całkowita netto: </h4>
                                            <button type="button" class="close" ng-click="discount_window = ! discount_window" aria-hidden="true">×</button>
                                        </div>

                                        <div class="i-check">
                                            <input type="radio" id="square-radio-1" value="without" name="square-radio" checked />
                                            <label for="square-radio-1" ng-click="setDiscount('without')">Bez rabatu</label>
                                        </div>

                                        <div class="discount_block">
                                            <div class="i-check">
                                                <input type="radio" id="square-radio-2" value="percent" name="square-radio" />
                                                <label for="square-radio-2" ng-click="setDiscount('percent')">% Procentowy</label>
                                            </div>

                                            <div class="discount_input pull-right" ng-show="discount_radio == 'percent'">
                                                <input type="text" class="form-control" name="percent_discount" /> %
                                            </div>
                                        </div>

                                        <div class="i-check">
                                            <input type="radio" id="square-radio-3" value="regular" name="square-radio" />
                                            <label for="square-radio-3" ng-click="setDiscount('regular')">Wartosciowy</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <span>Po rabacie:</span>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-add" ng-click="">Podatek VAT</button>
                                </div>
                            </td>

                            <td>
                                <div class="form-group">0</div>
                                <div class="form-group">0</div>
                                <div class="form-group">0</div>
                                <div class="form-group">0</div>
                            </td>

                            <td>
                                <div class="form-group">&nbsp;</div>
                                <div class="form-group">&nbsp;</div>
                                <div class="form-group">&nbsp;</div>
                                <div class="form-group">0</div>
                            </td>
                        </tr>
                    </tbody>
               </table>
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

                   <footer class="table-footer" >
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