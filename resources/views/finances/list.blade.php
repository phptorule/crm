<div data-ng-controller="FinancesCtrl" data-ng-init="initList()">
    <section class="content-header">
        <div class="header-icon">
            <i class="@{{ Page.icon() }}"></i>
        </div>

        <div class="header-title">
            <h4>@{{ Page.title() }}</h4>
        </div>
    </section>

   <div class="row page_content">
      <div class="col-sm-12">
         <div class="panel panel-bd">
            <div class="panel-heading">
               <div class="btn-group" id="buttonexport">
                     <h4>Wystawione faktury</h4>
               </div>
            </div>
            <div class="panel-body">
            <!-- Plugin content:powerpoint,txt,pdf,png,word,xl -->
               <div class="btn-group list_button_group">
                  <div class="buttonexport" id="buttonlist">
                     <a class="btn btn-add" href="/finances/add"> <i class="fa fa-plus"></i> Utwórz fakturę
                     </a>
                  </div>
                  <button class="btn export_button dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Table Data</button>
                  <ul class="dropdown-menu exp-drop" role="menu">
                     <li>
                        <a href="#" onclick="$('#dataTableExample1').tableExport({type:'json',escape:'false'});">
                        <img src="/img/json.png" width="24" alt="logo"> JSON</a>
                     </li>
                     <li>
                        <a href="#" onclick="$('#dataTableExample1').tableExport({type:'json',escape:'false',ignoreColumn:'[2,3]'});">
                        <img src="/img/json.png" width="24" alt="logo"> JSON (ignoreColumn)</a>
                     </li>
                     <li><a href="#" onclick="$('#dataTableExample1').tableExport({type:'json',escape:'true'});">
                        <img src="/img/json.png" width="24" alt="logo"> JSON (with Escape)</a>
                     </li>
                     <li class="divider"></li>
                     <li><a href="#" onclick="$('#dataTableExample1').tableExport({type:'xml',escape:'false'});">
                        <img src="/img/xml.png" width="24" alt="logo"> XML</a>
                     </li>
                     <li><a href="#" onclick="$('#dataTableExample1').tableExport({type:'sql'});">
                        <img src="/img/sql.png" width="24" alt="logo"> SQL</a>
                     </li>
                     <li class="divider"></li>
                     <li>
                        <a href="#" onclick="$('#dataTableExample1').tableExport({type:'csv',escape:'false'});">
                        <img src="/img/csv.png" width="24" alt="logo"> CSV</a>
                     </li>
                     <li>
                        <a href="#" onclick="$('#dataTableExample1').tableExport({type:'txt',escape:'false'});">
                        <img src="/img/txt.png" width="24" alt="logo"> TXT</a>
                     </li>
                     <li class="divider"></li>
                     <li>
                        <a href="#" onclick="$('#dataTableExample1').tableExport({type:'excel',escape:'false'});">
                        <img src="/img/xls.png" width="24" alt="logo"> XLS</a>
                     </li>
                     <li>
                        <a href="#" onclick="$('#dataTableExample1').tableExport({type:'doc',escape:'false'});">
                        <img src="/img/word.png" width="24" alt="logo"> Word</a>
                     </li>
                     <li>
                        <a href="#" onclick="$('#dataTableExample1').tableExport({type:'powerpoint',escape:'false'});">
                        <img src="/img/ppt.png" width="24" alt="logo"> PowerPoint</a>
                     </li>
                     <li class="divider"></li>
                     <li>
                        <a href="#" onclick="$('#dataTableExample1').tableExport({type:'png',escape:'false'});">
                        <img src="/img/png.png" width="24" alt="logo"> PNG</a>
                     </li>
                     <li>
                        <a href="#" onclick="$('#dataTableExample1').tableExport({type:'pdf',pdfFontSize:'7',escape:'false'});">
                        <img src="/img/pdf.png" width="24" alt="logo"> PDF</a>
                     </li>
                  </ul>
               </div>

               <div class="search_box">
                  <form>
                     <div class="row">
                           <div class="col-sm-12">
                              <div class="form-group">
                                 <input type="text" class="form-control search_input" name="search_input" placeholder="Szukaj" ng-model="searchInput" />
                              </div>
                           </div>
                     </div>
                  </form>
               </div>
               <!-- Plugin content:powerpoint,txt,pdf,png,word,xl -->
               <div class="table-responsive">
                  <table id="finances_table" class="table table-bordered table-striped table-hover">
                     <thead>
                        <tr class="info">
                           <th class="finances_number">Numer faktury</th>
                           <th>Produkt</th>
                           <th class="finances_customer">Klient</th>
                           <th class="finances_status">Zapłacona</th>
                           <th class="finances_amount">Wartość brutto</th>
                           <th class="finances_assign_to">Przypisany do</th>
                           <th class="finances_view">Przegląd</th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr ng-repeat="finances in pagesList | filter:searchInput">
                           <td>@{{ finances.finances_number }}</td>

                           <td class="td_products">
                              <p ng-show="finances.products.length == 1 && finances.products[0].products_name.length <= 105">@{{ finances.products[0].products_name }}</p>
                              <p ng-show="finances.products.length == 1 && finances.products[0].products_name.length >= 105" ng-class="{'closed': ! toggled, 'open': toggled}" class="products_names">@{{ finances.products[0].products_name }}</p>
                              <div class="products_names" ng-class="{'closed': ! toggled, 'open': toggled}" ng-show="finances.products.length > 1" >
                                 <p ng-repeat="product in finances.products">
                                    @{{ product.products_name }}
                                 </p>
                              </div>
                              <button class="btn btn-add show_all" ng-show="finances.products.length > 1 || finances.products[0].products_name.length >= 105" ng-click="toggled = ! toggled"><i class="fa fa-plus" ng-show="! toggled"></i><i class="fa fa-minus" ng-show="toggled"></i></button>
                           </td>

                           <td>@{{ finances.finances_customer_name }}</td>

                           <td>
                              <span ng-show="finances.finances_paid == '0'">Nie</span>
                              <span ng-show="finances.finances_paid == '1'">Tak</span>
                           </td>

                           <td>
                              @{{ finances.finances_total_amount }}
                              <span ng-show="finances.products_currency == '0'">(PLN)</span>
                              <span ng-show="finances.products_currency == '1'">(EUR)</span>
                              <span ng-show="finances.products_currency == '2'">(USD)</span>
                           </td>

                           <td>@{{ finances.users.users_first_name + ' ' + finances.users.users_last_name }}</td>

                           <td class="view_customer">
                              <a href="/finances/add/@{{ finances.finances_id }}">
                                 Otwórz
                              </a>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>