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
                                <label>Nazwa firmy</label><span class="req_field"> *</span>
                                <input type="text" class="form-control" name="company_name" required />
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Nazwa firmy</label><span class="req_field"> *</span>
                                <input type="text" class="form-control" name="company_name" required />
                            </div>

                            <div class="form-group">
                                <label>Nazwa firmy</label><span class="req_field"> *</span>
                                <input type="text" class="form-control" name="company_name" required />
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
                <form class="no-transition" name="form" method="post" novalidate="novalidate">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Nazwa firmy</label><span class="req_field"> *</span>
                                <input type="text" class="form-control" name="company_name" required />
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Nazwa firmy</label><span class="req_field"> *</span>
                                <input type="text" class="form-control" name="company_name" required />
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
                <form class="no-transition" name="form" method="post" novalidate="novalidate">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Nazwa firmy</label><span class="req_field"> *</span>
                                <input type="text" class="form-control" name="company_name" required />
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Nazwa firmy</label><span class="req_field"> *</span>
                                <input type="text" class="form-control" name="company_name" required />
                            </div>
                        </div>
                    </div>
                </form>
                <p>(<span class="req_field">*</span>) - required fields</p>
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
                <div class="search_box">
                    <form>
                        <div class="row">
                            <div class="col-sm-12">
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
                            <tr ng-repeat="customer in pagesList | filter:searchInput">
                                <td>@{{ customer.company_name }}</td>
                                <td>@{{ customer.nip }}</td>
                                <td>@{{ customer.invoice_town }}</td>
                            </tr>
                        </tbody>
                   </table>

                   <footer class="table-footer" >
                        <div class="row">
                            <div class="col-md-offset-6 col-md-6 text-right pagination-container">
                                <pagination class="pagination-sm"
                                            ng-model="currentPage"
                                            total-items="filteredStores.length"
                                            max-size="4"
                                            ng-change="changePage(currentPage)"
                                            items-per-page="numPerPage"
                                            rotate="false"
                                            previous-text="&lsaquo;" next-text="&rsaquo;"
                                            boundary-links="true"></pagination>
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