<div class="row" data-ng-controller="CustomersCtrl" data-ng-init="initList()">
   <div class="col-sm-12">
      <div class="panel panel-bd">
         <div class="panel-heading">
            <div class="btn-group" id="buttonexport">
                  <h4>Lista kontrahentów</h4>
            </div>
         </div>
         <div class="panel-body">
         <!-- Plugin content:powerpoint,txt,pdf,png,word,xl -->
            <div class="btn-group">
               <div class="buttonexport" id="buttonlist">
                  <a class="btn btn-add" href="/customers/add"> <i class="fa fa-plus"></i> Utwórz Kontrahenta
                  </a>
               </div>
               <button class="btn btn-exp btn-sm dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Table Data</button>
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
                              <label>Szukaj</label>
                              <input type="text" class="form-control" name="search_input" placeholder="Szukaj" ng-model="searchInput" />
                           </div>
                        </div>

                        <!--div class="col-sm-6">
                           <div class="form-group">
                              <label>W</label>
                              <select class="form-control">
                                 <option>Nazwa firmy</option>
                                 <option>Telefon</option>
                                 <option>Email</option>
                                 <option>Address</option>
                                 <option>type</option>
                                 <option>join</option>
                                 <option>Strona WWW</option>
                              </select>
                           </div>
                        </div-->
                  </div>
               </form>
            </div>
            <!-- Plugin content:powerpoint,txt,pdf,png,word,xl -->
            <div class="table-responsive">
               <table id="customers_table" class="table table-bordered table-striped table-hover">
                  <thead>
                     <tr class="info">
                        <th>Nazwa firmy</th>
                        <th>Telefon</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>type</th>
                        <th>Join</th>
                        <th>Strona WWW</th>
                        <th>Przegląd</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr ng-repeat="customer in pagesList | filter:searchInput">
                        <td>@{{ customer.company_name }}</td>
                        <td>@{{ customer.phone_number }}</td>
                        <td>@{{ customer.email }}</td>
                        <td>@{{ customer.invoice_town }}</td>
                        <td>
                           <span ng-show="customer.customer_type == '0'">Regular</span>
                           <span ng-show="customer.customer_type == '1'">Vendor</span>
                           <span ng-show="customer.customer_type == '2'">V.I.P.</span>
                        </td>
                        <td>@{{ customer.created_at }}</td>
                        <td>@{{ customer.website }}</td>
                        <td class="view_customer">
                           <a href="/customers/add/@{{ customer.customer_id }}" class="btn btn-success btn-labeled m-b-5">
                              <span class="btn-label"><i class="glyphicon glyphicon-info-sign"></i></span>Otwórz
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