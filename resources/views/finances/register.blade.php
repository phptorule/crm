<div class="row" data-ng-controller="FinancesCtrl" ng-init="init()">
    <form class="no-transition" name="form" method="post" novalidate="novalidate">
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
                        <a href="javascript:void(0);" ng-click="saveRegister()">Zapisz <i class="fa fa-floppy-o"></i></a>
                    </div>

                    <div class="custom_panel_item pull-right" ng-show="edit_general">
                        <a href="javascript:void(0);" ng-click="cancelEdit('general')">Anuluj</a>
                    </div>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Numer faktury</label><span class="req_field"> *</span>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <span class="form-span" ng-show=" ! edit_general && finances_id">@{{ finances.registered_finances_number }}</span>
                                        <input type="text" class="form-control" name="registered_finances_number" ng-show="edit_general || ! finances_id" ng-model="finances.registered_finances_number" required />
                                    </div>

                                    <div class="col-sm-6" ng-show=" ! finances_id">
                                        <button class="btn btn-exp btn-sm dropdown-toggle" ng-click=""><i class="fa fa-download"></i> Dołącz plik faktury</button>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Klient</label><span class="req_field"> *</span>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <span class="form-span" ng-show=" ! edit_general && finances_id">@{{ finances.finances_customer_name }}</span>
                                        <input type="text" class="form-control" name="finances_customer_name" ng-show="edit_general || ! finances_id" disabled="disabled" ng-model="finances.finances_customer_name" required />
                                    </div>

                                    <div class="col-sm-6" ng-show=" ! finances_id">
                                        <button class="btn btn-exp btn-sm dropdown-toggle" ng-click="selectCustomer()"><i class="fa fa-bars"></i> Wybierz Kontrahenta</button>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Temat</label>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <span class="form-span" ng-show=" ! edit_general && finances_id">@{{ finances.registered_subject }}</span>
                                        <input type="text" class="form-control" name="registered_subject" ng-show="edit_general || ! finances_id" ng-model="finances.registered_subject" required />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Cena netto</label>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <span class="form-span" ng-show=" ! edit_general && finances_id">@{{ finances.registered_finances_netto }}</span>
                                        <input type="text" class="form-control" ng-show="edit_general || ! finances_id" ng-model="finances.registered_finances_netto" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Cena brutto</label>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <span class="form-span" ng-show=" ! edit_general && finances_id">@{{ finances.registered_finances_brutto }}</span>
                                        <input type="text" class="form-control" ng-show="edit_general || ! finances_id" ng-model="finances.registered_finances_brutto" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Sposób płatności</label>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <span class="form-span" ng-show=" ! edit_general && finances_id && finances_payment_method == '0'">Gotówką</span>
                                        <span class="form-span" ng-show=" ! edit_general && finances_id && finances_payment_method == '1'">Przelew</span>
                                        <select class="form-control" ng-show="edit_general || ! finances_id" ng-model="finances_payment_method" required>
                                            <option value="0">Gotówką</option>
                                            <option value="1">Przelew </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Zaplacona</label><span class="req_field"> *</span>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <span class="form-span" ng-show=" ! edit_general && finances_id && finances_paid == '0'">Nie</span>
                                        <span class="form-span" ng-show=" ! edit_general && finances_id && finances_paid == '1'">Tak</span>
                                        <select class="form-control" ng-show="edit_general || ! finances_id" ng-model="finances_paid">
                                            <option value="0">Nie</option>
                                            <option value="1">Tak</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Data wystawienia</label>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <span class="form-span" ng-show=" ! edit_general && finances_id">@{{ finances.finances_issue_date }}</span>
                                        <div class="input-group custom-datapicker-input" ng-show="edit_general || ! finances_id">
                                            <input type="text" class="form-control" name="issue_date" uib-datepicker-popup="dd/MM/yyyy" ng-model="finances_issue_date" is-open="date[0].opened" show-button-bar="false" datepicker-options="dateOptions" />
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
                                        <span class="form-span" ng-show=" ! edit_general && finances_id">@{{ finances.finances_payment_date }}</span>
                                        <div class="input-group custom-datapicker-input" ng-show="edit_general || ! finances_id">
                                            <input type="text" class="form-control" uib-datepicker-popup="dd/MM/yyyy" ng-model="finances_payment_date" is-open="date[1].opened" show-button-bar="false" datepicker-options="dateOptions" required />
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
                                        <span class="form-span" ng-show=" ! edit_general && finances_id">@{{ user.users_first_name + ' ' + user.users_last_name }}</span>
                                        <select class="form-control" ng-show="edit_general || ! finances_id" ng-model="finances.finances_assign_to">
                                            <option ng-repeat="user in team_users" value="@{{ user.users_id }}">@{{ user.users_first_name + ' ' + user.users_last_name }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="btn-group" id="buttonlist">
                        <h3>Informacje konta bankowego</h3>
                    </div>

                    <div class="custom_panel_item pull-right" ng-show="finances_id">
                        <a href="javascript:void(0);" ng-show=" ! edit_bank" ng-click="editFinances('bank')">Edytuj dane <i class="panel-control-icon ti-pencil"></i></a>
                    </div>

                    <div class="custom_panel_item pull-right" ng-show="edit_bank">
                        <a href="javascript:void(0);" ng-click="saveRegister()">Zapisz <i class="fa fa-floppy-o"></i></a>
                    </div>

                    <div class="custom_panel_item pull-right" ng-show="edit_bank">
                        <a href="javascript:void(0);" ng-click="cancelEdit('bank')">Anuluj</a>
                    </div>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Rachunek</label>
                                <span class="form-span" ng-show=" ! edit_bank && finances_id">@{{ finances.registered_bank_account }}</span>
                                <input type="text" class="form-control" ng-show="edit_bank || ! finances_id" ng-model="finances.registered_bank_account" required />
                            </div>

                            <div class="form-group">
                                <label>Tytuł zamówienia</label>
                                <span class="form-span" ng-show=" ! edit_bank && finances_id">@{{ finances.registered_order_title }}</span>
                                <input type="text" class="form-control" ng-show="edit_bank || ! finances_id" ng-model="finances.registered_order_title" />
                            </div>

                            <div class="form-group">
                                <label>NIP</label>
                                <span class="form-span" ng-show=" ! edit_bank && finances_id">@{{ finances.registered_bank_nip }}</span>
                                <input type="text" class="form-control" ng-show="edit_bank || ! finances_id" ng-model="finances.registered_bank_nip" />
                            </div>

                            <div class="form-group">
                                <label>Bank</label>
                                <span class="form-span" ng-show=" ! edit_bank && finances_id">@{{ finances.registered_bank_name }}</span>
                                <input type="text" class="form-control" ng-show="edit_bank || ! finances_id" ng-model="finances.registered_bank_name"  />
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Ulica</label>
                                <span class="form-span" ng-show=" ! edit_bank && finances_id">@{{ finances.registered_bank_street }}</span>
                                <input type="text" class="form-control" ng-show="edit_bank || ! finances_id" ng-model="finances.registered_bank_street" required />
                            </div>

                            <div class="form-group">
                                <label>Miejscowosc</label>
                                <span class="form-span" ng-show=" ! edit_bank && finances_id">@{{ finances.registered_bank_town }}</span>
                                <input type="text" class="form-control" ng-show="edit_bank || ! finances_id" ng-model="finances.registered_bank_town" />
                            </div>

                            <div class="form-group">
                                <label>Kod</label>
                                <span class="form-span" ng-show=" ! edit_bank && finances_id">@{{ finances.registered_bank_postcode }}</span>
                                <input type="text" class="form-control" ng-show="edit_bank || ! finances_id" ng-model="finances.registered_bank_postcode" />
                            </div>

                            <div class="form-group">
                                <label>Kraj</label>
                                <span class="form-span" ng-show=" ! edit_bank && finances_id">@{{ finances.registered_bank_region }}</span>
                                <input type="text" class="form-control" ng-show="edit_bank || ! finances_id" ng-model="finances.registered_bank_region" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="btn-group" id="buttonlist">
                        <h3>Inne</h3>
                    </div>

                    <div class="custom_panel_item pull-right" ng-show="customer_id">
                        <a href="javascript:void(0);" ng-show=" ! edit_rest" ng-click="editCustomers('rest')">Edytuj <i class="panel-control-icon ti-pencil"></i></a>
                    </div>

                    <div class="custom_panel_item pull-right" ng-show="customer_id && edit_rest">
                        <a href="javascript:void(0);" ng-click="saveRegister()">Zapisz <i class="fa fa-floppy-o"></i></a>
                    </div>

                    <div class="custom_panel_item pull-right" ng-show="customer_id && edit_rest">
                        <a href="javascript:void(0);" ng-click="cancelEdit('rest')">Anuluj</a>
                    </div>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Opis</label>
                                <span class="form-span" ng-model="customers.description" ng-show=" ! edit_rest && finances_id">@{{ finances.registered_description }}</span>
                                <textarea class="form-control" rows="1" name="description" ng-show="edit_rest || ! finances_id" ng-model="finances.registered_description"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <p ng-show=" ! customer_id">(<span class="req_field">*</span>) - Wymagane pola</p>
        </div>

        <div class="col-sm-12 text-right">
            <button type="submit" class="btn btn-add" ng-click="registerFinance()">Zapisc</button>
        </div>
    </form>
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
                            <tr ng-repeat="customer in customers | filter:searchInput">
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