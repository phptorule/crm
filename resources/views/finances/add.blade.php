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
                                        <input type="text" class="form-control" name="customer" disabled="disabled" />
                                    </div>

                                    <div class="col-sm-6">
                                        <button class="btn btn-exp btn-sm dropdown-toggle" ng-click="selectCustomer()"><i class="fa fa-bars"></i> Wybierz Kontrahenta</button>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Numer faktury</label><span class="req_field"> *</span>
                                <input type="text" class="form-control" name="finance_number" required />
                            </div>

                            <div class="form-group">
                                <label>Data wystawlenia</label><span class="req_field"> *</span>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="input-group">
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
                                <label>Zaplacona</label><span class="req_field"> *</span>
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
                                        <div class="input-group">
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
                                        <select class="form-control" name="invoice_paid" ng-model="assign_to">
                                            <option ng-repeat="user in team_users" value="@{{ user.users_id }}">@{{ user.users_first_name + ' ' + user.users_last_name }}</option>
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
            </div>

            <div class="panel-body">
                <form class="no-transition" name="form_address" method="post" novalidate="novalidate">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Ulica</label>
                                <input type="text" class="form-control" name="invoice_street" ng-model="customers.invoice_street" />
                            </div>

                            <div class="form-group">
                                <label>Skrytka Pocztowa do faktury</label>
                                <input type="text" class="form-control" name="invoice_mailbox" ng-show="edit_address || ! customer_id" ng-model="customers.invoice_mailbox" />
                            </div>

                            <div class="form-group">
                                <label>Miejscowosc</label>
                                <input type="text" class="form-control" name="invoice_town" ng-model="customers.invoice_town" />
                            </div>

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
                <table id="customers_table" class="table table-bordered table-striped table-hover">
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
                            <td>test</td>
                            <td>test</td>
                            <td>test</td>
                            <td>test</td>
                            <td>test</td>
                            <td>test</td>
                        </tr>
                    </tbody>
               </table>
            </div>
        </div>
    </div>

    <div class="col-sm-12 text-right">
        <button type="submit" class="btn btn-add" ng-show=" ! customer_id" ng-click="save(check)">{{ __('Zapisc') }}</button>
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
                                <td>@{{ customer.company_name }}</td>
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
      <button type="button" class="btn btn-danger pull-left" ng-click="cancel()">Anuluj</button>
   </div>
</script>

<script type="text/ng-template" id="CreateCustomer.html">
    <div class="modal-header modal-header-primary" ng-init="initList()">
       <button type="button" class="close" ng-click="cancel()" aria-hidden="true">×</button>
       <h3><i class="fa fa-user m-r-5"></i> Kontrahenci</h3>
    </div>
    <div class="modal-body">
       <div class="row">
            <div class="col-md-12">
                <div class="modal_content_header">
                    <form class="no-transition" name="form" method="post" novalidate="novalidate">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Nazwa firmy</label><span class="req_field"> *</span>
                                    <span class="form-span" ng-model="customers.company_name" ng-show=" ! edit_general && customer_id">@{{ customers.company_name }}</span>
                                    <input type="text" class="form-control" name="company_name" ng-show="edit_general || ! customer_id" ng-model="customers.company_name" required />
                                </div>

                                <div class="form-group">
                                    <label>Numer NIP</label>
                                    <span class="form-span" ng-model="customers.nip" ng-show=" ! edit_general && customer_id">@{{ customers.nip }}</span>
                                    <input type="text" class="form-control" name="nip" ng-show="edit_general || ! customer_id" ng-model="customers.nip" />
                                </div>

                                <div class="form-group">
                                    <label>Osoba kontaktowa</label>
                                    <span class="form-span" ng-model="customers.contact_person" ng-show=" ! edit_general && customer_id">@{{ customers.contact_person }}</span>
                                    <input type="text" class="form-control" name="contact_person" ng-show="edit_general || ! customer_id" ng-model="customers.contact_person" />
                                </div>

                                <div class="form-group">
                                    <label>Telefon</label>
                                    <span class="form-span" ng-model="customers.phone_number" ng-show=" ! edit_general && customer_id">@{{ customers.phone_number }}</span>
                                    <input type="text" class="form-control" name="phone_number" ng-show="edit_general || ! customer_id" ng-model="customers.phone_number" />
                                </div>

                                <div class="form-group">
                                    <label>Email</label>
                                    <span class="form-span" ng-model="customers.email" ng-show=" ! edit_general && customer_id">@{{ customers.email }}</span>
                                    <input type="text" class="form-control" name="email" ng-show="edit_general || ! customer_id" ng-model="customers.email" />
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Ulica</label>
                                    <span class="form-span" ng-model="customers.invoice_street" ng-show=" ! edit_address && customer_id">@{{ customers.invoice_street }}</span>
                                    <input type="text" class="form-control" name="invoice_street" ng-show="edit_address || ! customer_id" ng-model="customers.invoice_street" />
                                </div>

                                <div class="form-group">
                                    <label>Skrytka Pocztowa do faktury</label>
                                    <span class="form-span" ng-model="customers.invoice_mailbox" ng-show=" ! edit_address && customer_id">@{{ customers.invoice_mailbox }}</span>
                                    <input type="text" class="form-control" name="invoice_mailbox" ng-show="edit_address || ! customer_id" ng-model="customers.invoice_mailbox" />
                                </div>

                                <div class="form-group">
                                    <label>Miejscowosc</label>
                                    <span class="form-span" ng-model="customers.invoice_town" ng-show=" ! edit_address && customer_id">@{{ customers.invoice_town }}</span>
                                    <input type="text" class="form-control" name="invoice_town" ng-show="edit_address || ! customer_id" ng-model="customers.invoice_town" />
                                </div>

                                <div class="form-group">
                                    <label>Wojewodztwo</label>
                                    <span class="form-span" ng-model="customers.invoice_province" ng-show=" ! edit_address && customer_id">@{{ customers.invoice_province }}</span>
                                    <input type="text" class="form-control" name="invoice_province" ng-show="edit_address || ! customer_id" ng-model="customers.invoice_province"  />
                                </div>

                                <div class="form-group">
                                    <label>Kod</label>
                                    <span class="form-span" ng-model="customers.invoice_post_code" ng-show=" ! edit_address && customer_id">@{{ customers.invoice_post_code }}</span>
                                    <input type="text" class="form-control" name="invoice_post_code" ng-show="edit_address || ! customer_id" ng-model="customers.invoice_post_code" />
                                </div>

                                <div class="form-group">
                                    <label>Kraj</label>
                                    <span class="form-span" ng-model="customers.invoice_region" ng-show=" ! edit_address && customer_id">@{{ customers.invoice_region }}</span>
                                    <input type="text" class="form-control" name="invoice_region" ng-show="edit_address || ! customer_id" ng-model="customers.invoice_region" />
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Ulica - Adres wysylki</label>
                                    <span class="form-span" ng-model="customers.send_street" ng-show=" ! edit_address && customer_id">@{{ customers.send_street }}</span>
                                    <input type="text" class="form-control" name="send_street" ng-show="edit_address || ! customer_id" ng-model="customers.send_street" />
                                </div>

                                <div class="form-group">
                                    <label>Skrytka Pocztowa do wysylki</label>
                                    <span class="form-span" ng-model="customers.send_mailbox" ng-show=" ! edit_address && customer_id">@{{ customers.send_mailbox }}</span>
                                    <input type="text" class="form-control" name="send_mailbox" ng-show="edit_address || ! customer_id" ng-model="customers.send_mailbox" />
                                </div>

                                <div class="form-group">
                                    <label>Miejscowosc - Adres wysylki</label>
                                    <span class="form-span" ng-model="customers.send_town" ng-show=" ! edit_address && customer_id">@{{ customers.send_town }}</span>
                                    <input type="text" class="form-control" name="send_town" ng-show="edit_address || ! customer_id" ng-model="customers.send_town" />
                                </div>

                                <div class="form-group">
                                    <label>Wojewodztwo - Adres wysylki</label>
                                    <span class="form-span" ng-model="customers.send_province" ng-show=" ! edit_address && customer_id">@{{ customers.send_province }}</span>
                                    <input type="text" class="form-control" name="send_province" ng-show="edit_address || ! customer_id" ng-model="customers.send_province" />
                                </div>

                                <div class="form-group">
                                    <label>Kod - Adres wysylki</label>
                                    <span class="form-span" ng-model="customers.send_post_code" ng-show=" ! edit_address && customer_id">@{{ customers.send_post_code }}</span>
                                    <input type="text" class="form-control" name="send_post_code" ng-show="edit_address || ! customer_id" ng-model="customers.send_post_code" />
                                </div>

                                <div class="form-group">
                                    <label>Kraj - Adres wysylki</label>
                                    <span class="form-span" ng-model="customers.send_region" ng-show=" ! edit_address && customer_id">@{{ customers.send_region }}</span>
                                    <input type="text" class="form-control" name="send_region" ng-show="edit_address || ! customer_id" ng-model="customers.send_region" />
                                </div>
                            </div>

                            <div class="col-sm-12 text-right">
                                <button type="submit" class="btn btn-add" ng-show=" ! customer_id" ng-click="save(check)">{{ __('Dodaj nowego kontrahenta') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
   </div>

   <div class="modal-footer">
      <button type="button" class="btn btn-danger pull-left" ng-click="cancel()">Anuluj</button>
   </div>
</script>