<div data-ng-controller="FinancesCtrl" ng-init="initRegister()">
    <section class="content-header">
        <div class="header-icon">
            <i class="@{{ Page.icon() }}"></i>
        </div>

        <div class="header-title">
            <h4>@{{ Page.title() }}</h4>
        </div>
    </section>

    <div class="row page_content">
        <button type="button" class="btn btn-add m-b-5 delete_customer pull-right" ng-show="registered_id">
            Dołącz PDF
        </button>

        <form class="no-transition" name="form" method="post" novalidate="novalidate">
            <div class="col-sm-12">
                <div class="panel panel-bd">
                    <div class="panel-heading">
                        <h4>Informacje podstawowe</h4>

                        <div class="custom_panel_block" ng-show="registered_id">
                            <div class="custom_panel_item pull-right">
                                <a href="javascript:void(0);" ng-show=" ! edit_general" ng-click="editFinances('general')">Edytuj dane <i class="panel-control-icon ti-pencil"></i></a>
                            </div>

                            <div class="custom_panel_item" ng-show="edit_general">
                                <a href="javascript:void(0);" ng-click="registerFinance()">Zapisz <i class="fa fa-floppy-o"></i></a>
                            </div>

                            <div class="custom_panel_item pull-right" ng-show="edit_general">
                                <a href="javascript:void(0);" ng-click="cancelEdit('general')">Anuluj</a>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group" ng-show="finances.registered_finances_number || edit_general || ! registered_id">
                                    <label>Numer faktury</label><span class="req_field"> *</span>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <span class="form-span" ng-show=" ! edit_general && registered_id">@{{ finances.registered_finances_number }}</span>
                                            <input type="text" class="form-control" name="registered_finances_number" ng-show="edit_general || ! registered_id" ng-model="finances.registered_finances_number" required />
                                        </div>

                                        <div class="col-sm-6" ng-show=" ! registered_id">
                                            <button class="btn btn-exp btn-sm dropdown-toggle" ng-click=""><i class="fa fa-download"></i> Dołącz plik faktury</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" ng-show="finances.finances_customer_name || edit_general || ! registered_id">
                                    <label>Klient</label><span class="req_field"> *</span>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <span class="form-span" ng-show=" ! edit_general && registered_id">@{{ finances.finances_customer_name }}</span>
                                            <input type="text" class="form-control" name="finances_customer_name" ng-show="edit_general || ! registered_id" ng-model="finances.finances_customer_name" required />
                                        </div>

                                        <div class="col-sm-6" ng-show=" ! registered_id">
                                            <button class="btn btn-exp btn-sm dropdown-toggle" ng-click="selectCustomer()"><i class="fa fa-bars"></i> Wybierz Kontrahenta</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" ng-show="finances.registered_subject || edit_general || ! registered_id">
                                    <label>Temat</label>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <span class="form-span" ng-show=" ! edit_general && registered_id">@{{ finances.registered_subject }}</span>
                                            <input type="text" class="form-control" name="registered_subject" ng-show="edit_general || ! registered_id" ng-model="finances.registered_subject" required />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" ng-show="finances.registered_finances_netto || edit_general || ! registered_id">
                                    <label>Cena netto</label>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <span class="form-span" ng-show=" ! edit_general && registered_id">@{{ finances.registered_finances_netto }}</span>
                                            <input type="text" class="form-control" ng-show="edit_general || ! registered_id" ng-model="finances.registered_finances_netto" />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" ng-show="finances.registered_finances_brutto || edit_general || ! registered_id">
                                    <label>Cena brutto</label>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <span class="form-span" ng-show=" ! edit_general && registered_id">@{{ finances.registered_finances_brutto }}</span>
                                            <input type="text" class="form-control" ng-show="edit_general || ! registered_id" ng-model="finances.registered_finances_brutto" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Sposób płatności</label>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <span class="form-span" ng-show=" ! edit_general && registered_id && finances_payment_method == '0'">Gotówką</span>
                                            <span class="form-span" ng-show=" ! edit_general && registered_id && finances_payment_method == '1'">Przelew</span>
                                            <select class="form-control" ng-show="edit_general || ! registered_id" ng-model="finances_payment_method" required>
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
                                            <span class="form-span" ng-show=" ! edit_general && registered_id && finances_paid == '0'">Nie</span>
                                            <span class="form-span" ng-show=" ! edit_general && registered_id && finances_paid == '1'">Tak</span>
                                            <select class="form-control" ng-show="edit_general || ! registered_id" ng-model="finances_paid">
                                                <option value="0">Nie</option>
                                                <option value="1">Tak</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" ng-show="finances.finances_issue_date || edit_general || ! registered_id">
                                    <label>Data wystawienia</label>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <span class="form-span" ng-show=" ! edit_general && registered_id">@{{ finances.finances_issue_date }}</span>
                                            <div class="input-group custom-datapicker-input" ng-show="edit_general || ! registered_id">
                                                <input type="text" class="form-control" name="issue_date" uib-datepicker-popup="dd/MM/yyyy" ng-model="finances_issue_date" is-open="date[0].opened" show-button-bar="false" datepicker-options="dateOptions" />
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-default" ng-click="calendarOpen(0)"><i class="glyphicon glyphicon-calendar"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" ng-show="finances.finances_payment_date || edit_general || ! registered_id">
                                    <label>Termin platności</label><span class="req_field"> *</span>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <span class="form-span" ng-show=" ! edit_general && registered_id">@{{ finances.finances_payment_date }}</span>
                                            <div class="input-group custom-datapicker-input" ng-show="edit_general || ! registered_id">
                                                <input type="text" class="form-control" uib-datepicker-popup="dd/MM/yyyy" ng-model="finances_payment_date" is-open="date[1].opened" show-button-bar="false" datepicker-options="dateOptions" required />
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-default" ng-click="calendarOpen(1)"><i class="glyphicon glyphicon-calendar"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" ng-show="user || edit_general || ! registered_id">
                                    <label>Przypisany do</label><span class="req_field"> *</span>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <span class="form-span" ng-show=" ! edit_general && registered_id">@{{ user.users_first_name + ' ' + user.users_last_name }}</span>
                                            <select class="form-control" ng-show="edit_general || ! registered_id" ng-model="finances.finances_assign_to">
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
                <div class="panel panel-bd">
                    <div class="panel-heading">
                        <h4>Informacje konta bankowego</h4>

                        <div class="custom_panel_block" ng-show="registered_id">
                            <div class="custom_panel_item pull-right">
                                <a href="javascript:void(0);" ng-show=" ! edit_bank" ng-click="editFinances('bank')">Edytuj dane <i class="panel-control-icon ti-pencil"></i></a>
                            </div>

                            <div class="custom_panel_item" ng-show="edit_bank">
                                <a href="javascript:void(0);" ng-click="registerFinance()">Zapisz <i class="fa fa-floppy-o"></i></a>
                            </div>

                            <div class="custom_panel_item pull-right" ng-show="edit_bank">
                                <a href="javascript:void(0);" ng-click="cancelEdit('bank')">Anuluj</a>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group" ng-show="finances.registered_bank_account || edit_bank || ! registered_id">
                                    <label>Konto bankowe</label>
                                    <span class="form-span" ng-show=" ! edit_bank && registered_id">@{{ finances.registered_bank_account }}</span>
                                    <input type="text" class="form-control" ng-show="edit_bank || ! registered_id" ng-model="finances.registered_bank_account" required />
                                </div>

                                <div class="form-group" ng-show="finances.registered_order_title || edit_bank || ! registered_id">
                                    <label>Tytuł zamówienia</label>
                                    <span class="form-span" ng-show=" ! edit_bank && registered_id">@{{ finances.registered_order_title }}</span>
                                    <input type="text" class="form-control" ng-show="edit_bank || ! registered_id" ng-model="finances.registered_order_title" />
                                </div>

                                <div class="form-group" ng-show="finances.registered_bank_nip || edit_bank || ! registered_id">
                                    <label>NIP</label>
                                    <span class="form-span" ng-show=" ! edit_bank && registered_id">@{{ finances.registered_bank_nip }}</span>
                                    <input type="text" class="form-control" ng-show="edit_bank || ! registered_id" ng-model="finances.registered_bank_nip" />
                                </div>

                                <div class="form-group" ng-show="finances.registered_bank_name || edit_bank || ! registered_id">
                                    <label>Bank</label>
                                    <span class="form-span" ng-show=" ! edit_bank && registered_id">@{{ finances.registered_bank_name }}</span>
                                    <input type="text" class="form-control" ng-show="edit_bank || ! registered_id" ng-model="finances.registered_bank_name"  />
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group" ng-show="finances.registered_bank_street || edit_bank || ! registered_id">
                                    <label>Ulica</label>
                                    <span class="form-span" ng-show=" ! edit_bank && registered_id">@{{ finances.registered_bank_street }}</span>
                                    <input type="text" class="form-control" ng-show="edit_bank || ! registered_id" ng-model="finances.registered_bank_street" required />
                                </div>

                                <div class="form-group" ng-show="finances.registered_bank_town || edit_bank || ! registered_id">
                                    <label>Miejscowosc</label>
                                    <span class="form-span" ng-show=" ! edit_bank && registered_id">@{{ finances.registered_bank_town }}</span>
                                    <input type="text" class="form-control" ng-show="edit_bank || ! registered_id" ng-model="finances.registered_bank_town" />
                                </div>

                                <div class="form-group" ng-show="finances.registered_bank_postcode || edit_bank || ! registered_id">
                                    <label>Kod</label>
                                    <span class="form-span" ng-show=" ! edit_bank && registered_id">@{{ finances.registered_bank_postcode }}</span>
                                    <input type="text" class="form-control" ng-show="edit_bank || ! registered_id" ng-model="finances.registered_bank_postcode" />
                                </div>

                                <div class="form-group" ng-show="finances.registered_bank_region || edit_bank || ! registered_id">
                                    <label>Kraj</label>
                                    <span class="form-span" ng-show=" ! edit_bank && registered_id">@{{ finances.registered_bank_region }}</span>
                                    <input type="text" class="form-control" ng-show="edit_bank || ! registered_id" ng-model="finances.registered_bank_region" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="panel panel-bd">
                    <div class="panel-heading">
                        <h4>Inne</h4>

                        <div class="custom_panel_block" ng-show="registered_id">
                            <div class="custom_panel_item pull-right">
                                <a href="javascript:void(0);" ng-show=" ! edit_rest" ng-click="editFinances('rest')">Edytuj <i class="panel-control-icon ti-pencil"></i></a>
                            </div>

                            <div class="custom_panel_item" ng-show="registered_id && edit_rest">
                                <a href="javascript:void(0);" ng-click="registerFinance()">Zapisz <i class="fa fa-floppy-o"></i></a>
                            </div>

                            <div class="custom_panel_item pull-right" ng-show="registered_id && edit_rest">
                                <a href="javascript:void(0);" ng-click="cancelEdit('rest')">Anuluj</a>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group" ng-show="finances.registered_description || edit_rest || ! registered_id">
                                    <label>Opis</label>
                                    <span class="form-span" ng-model="finances.registered_description" ng-show=" ! edit_rest && registered_id">@{{ finances.registered_description }}</span>
                                    <textarea class="form-control" rows="1" ng-show="edit_rest || ! registered_id" ng-model="finances.registered_description"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <p ng-show=" ! customer_id">(<span class="req_field">*</span>) - Wymagane pola</p>
            </div>

            <div class="col-sm-12 text-right" ng-show="! registered_id">
                <button type="submit" class="btn btn-add" ng-click="registerFinance()">Zapisz</button>
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
                    </div>
                </div>
            </div>
       </div>

       <div class="modal-footer">
          <button type="button" class="btn btn-danger pull-right" ng-click="cancel()">Anuluj</button>
       </div>
    </script>
</div>