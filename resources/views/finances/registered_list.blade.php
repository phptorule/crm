<div data-ng-controller="FinancesCtrl" data-ng-init="initRegisteredList()">
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
               <h4>Zarejestrowane faktury</h4>
            </div>

            <div class="panel-body">
            <!-- Plugin content:powerpoint,txt,pdf,png,word,xl -->
               <div class="btn-group">
                  <div class="buttonexport" id="buttonlist">
                     <a class="btn btn-add" href="/finances/register"> <i class="fa fa-plus"></i> Zarejestruj fakturę
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
                                 <input type="text" class="form-control" name="search_input" placeholder="Szukaj" ng-model="searchInput" />
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
                           <th>Temat</th>
                           <th class="finances_customer">Klient</th>
                           <th class="finances_status">Zapłacona</th>
                           <th>Termin płatności</th>
                           <th class="finances_amount">Wartość brutto</th>
                           <th class="finances_view">Przegląd</th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr ng-repeat="registered in pagesList | filter:searchInput">
                           <td>
                              @{{ registered.registered_finances_number }}
                           </td>
                           <td>
                              @{{ registered.registered_subject }}
                           </td>
                           <td>
                              @{{ registered.registered_customer_name }}
                           </td>
                           <td>
                              <span ng-show="registered.registered_paid == '0'">Nie</span>
                              <span ng-show="registered.registered_paid == '1'">Tak</span>
                           </td>
                           <td>
                              @{{ registered.registered_payment_date }}
                           </td>
                           <td>
                              @{{ registered.registered_finances_brutto }}
                           </td>
                           <td class="view_customer">
                              <a href="/finances/register/@{{ registered.registered_id }}" class="btn btn-success btn-labeled m-b-5">
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
</div>