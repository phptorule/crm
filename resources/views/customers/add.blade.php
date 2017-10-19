<div class="row" data-ng-controller="CustomersCtrl" ng-init="get()">
    <button type="button" class="btn btn-labeled btn-danger m-b-5 delete_customer pull-right" ng-show="customer_id" ng-click="remove(customer_id)">
        <span class="btn-label"><i class="glyphicon glyphicon-trash"></i></span>Usuń kontrahenta
    </button>

    <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="btn-group" id="buttonlist">
                    <h3>Informacje podstawowe</h3>
                </div>

                <div class="custom_panel_item pull-right" ng-show="customer_id">
                    <a href="javascript:void(0);" ng-show=" ! edit_general" ng-click="editCustomers('general')">Edytuj <i class="panel-control-icon ti-pencil"></i></a>
                </div>

                <div class="custom_panel_item pull-right" ng-show="customer_id && edit_general">
                    <a href="javascript:void(0);" ng-click="save()">Zapisz <i class="fa fa-floppy-o"></i></a>
                </div>

                <div class="custom_panel_item pull-right" ng-show="customer_id && edit_general">
                    <a href="javascript:void(0);" ng-click="cancelEdit('general')">Anuluj</a>
                </div>
            </div>

            <div class="panel-body">
                <form class="no-transition" name="form" method="post" novalidate="novalidate">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Nazwa firmy</label><span class="req_field"> *</span>
                                <span class="form-span" ng-model="customers.company_name" ng-show=" ! edit_general && customer_id">@{{ customers.company_name }}</span>
                                <input type="text" class="form-control" name="company_name" ng-show="edit_general || ! customer_id" ng-model="customers.company_name" required />
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
                                <label>Telefon dodatkowy</label>
                                <span class="form-span" ng-model="customers.extra_phone_number" ng-show=" ! edit_general && customer_id">@{{ customers.extra_phone_number }}</span>
                                <input type="text" class="form-control" name="extra_phone_number" ng-show="edit_general || ! customer_id" ng-model="customers.extra_phone_number" />
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <span class="form-span" ng-model="customers.email" ng-show=" ! edit_general && customer_id">@{{ customers.email }}</span>
                                <input type="text" class="form-control" name="email" ng-show="edit_general || ! customer_id" ng-model="customers.email" />
                            </div>

                            <div class="form-group">
                                <label>Email dodatkowy</label>
                                <span class="form-span" ng-model="customers.extra_email" ng-show=" ! edit_general && customer_id">@{{ customers.extra_email }}</span>
                                <input type="text" class="form-control" name="extra_email" ng-show="edit_general || ! customer_id" ng-model="customers.extra_email" />
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Numer NIP</label>
                                <span class="form-span" ng-model="customers.nip" ng-show=" ! edit_general && customer_id">@{{ customers.nip }}</span>
                                <input type="text" class="form-control" name="nip" ng-show="edit_general || ! customer_id" ng-model="customers.nip" />
                            </div>

                            <div class="form-group">
                                <label>Przypisany do</label>
                                <span class="form-span" ng-model="customers.assign_to" ng-show=" ! edit_general && customer_id">@{{ customers.assign_to }}</span>
                                <input type="text" class="form-control" name="assign_to" ng-show="edit_general || ! customer_id" ng-model="customers.assign_to" />
                            </div>

                            <div class="form-group">
                                <label>Konto bankowe</label>
                                <span class="form-span" ng-model="customers.bank_account" ng-show=" ! edit_general && customer_id">@{{ customers.bank_account }}</span>
                                <input type="text" class="form-control" name="bank_account" ng-show="edit_general || ! customer_id" ng-model="customers.bank_account" />
                            </div>

                            <div class="form-group">
                                <label>Strona WWW</label>
                                <span class="form-span" ng-model="customers.website" ng-show=" ! edit_general && customer_id">@{{ customers.website }}</span>
                                <input type="text" class="form-control" name="website" ng-show="edit_general || ! customer_id" ng-model="customers.website" />
                            </div>

                            <div class="form-group">
                                <label>Facebook Id</label>
                                <span class="form-span" ng-model="customers.fb_link" ng-show=" ! edit_general && customer_id">@{{ customers.fb_link }}</span>
                                <input type="text" class="form-control" name="fb_link" ng-show="edit_general || ! customer_id" ng-model="customers.fb_link" />
                            </div>
                        </div>
                    </div>
                    <div class="row" ng-show="customer_id">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Czas utworzenia</label>
                                <input type="text" class="form-control" name="created_date" disabled="disabled" ng-model="customers.created_at" />
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Czas modyfikacji</label>
                                <input type="text" class="form-control" name="updated_date" disabled="disabled" ng-model="customers.updated_at" />
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

                <div class="custom_panel_item pull-right" ng-show="customer_id">
                    <a href="javascript:void(0);" ng-show=" ! edit_address" ng-click="editCustomers('address')">Edytuj <i class="panel-control-icon ti-pencil"></i></a>
                </div>

                <div class="custom_panel_item pull-right" ng-show="customer_id && edit_address">
                    <a href="javascript:void(0);" ng-click="save()">Zapisz <i class="fa fa-floppy-o"></i></a>
                </div>

                <div class="custom_panel_item pull-right" ng-show="customer_id && edit_address">
                    <a href="javascript:void(0);" ng-click="cancelEdit('address')">Anuluj</a>
                </div>
            </div>

            <div class="panel-body">
                <form class="no-transition" name="form_address" method="post" novalidate="novalidate">
                    <div class="row">
                        <div class="col-sm-6">
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

                        <div class="col-sm-6">
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
                    <h3>Inne</h3>
                </div>

                <div class="custom_panel_item pull-right" ng-show="customer_id">
                    <a href="javascript:void(0);" ng-show=" ! edit_rest" ng-click="editCustomers('rest')">Edytuj <i class="panel-control-icon ti-pencil"></i></a>
                </div>

                <div class="custom_panel_item pull-right" ng-show="customer_id && edit_rest">
                    <a href="javascript:void(0);" ng-click="save()">Zapisz <i class="fa fa-floppy-o"></i></a>
                </div>

                <div class="custom_panel_item pull-right" ng-show="customer_id && edit_rest">
                    <a href="javascript:void(0);" ng-click="cancelEdit('rest')">Anuluj</a>
                </div>
            </div>

            <div class="panel-body">
                <form class="no-transition" name="form_rest" method="post" novalidate="novalidate">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Opis</label>
                                <span class="form-span" ng-model="customers.description" ng-show=" ! edit_rest && customer_id">@{{ customers.description }}</span>
                                <textarea class="form-control" rows="1" name="description" ng-show="edit_rest || ! customer_id" ng-model="customers.description"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-6">

                            <div class="form-group">
                                <label>Typ osoby</label>
                                <span class="form-span" ng-show=" ! edit_rest && customer_id && customers.customer_type == '0'">Regular</span>
                                <span class="form-span" ng-show=" ! edit_rest && customer_id && customers.customer_type == '1'">Vendor</span>
                                <span class="form-span" ng-show=" ! edit_rest && customer_id && customers.customer_type == '2'">V.I.P.</span>
                                <select class="form-control" name="customer_type" ng-show="edit_rest || ! customer_id" ng-model="customers.customer_type">
                                    <option value="0">Regular</option>
                                    <option value="1">Vendor</option>
                                    <option value="2">V.I.P.</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
                <p>(<span class="req_field">*</span>) - required fields</p>
            </div>
        </div>
    </div>

    <div class="col-sm-12" ng-show="customer_id">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="btn-group" id="buttonlist">
                    <h3>Komentarze i notatki</h3>
                </div>
            </div>

            <div class="panel-body">
                <form>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="comments_area">
                                <div class="comment_box" ng-repeat="comment in comments">
                                    <p>@{{ comment.comment_text }}</p>
                                    <p>
                                        <span>Autor: @{{ comment.author + ' (' + comment.created_at + ')' }} </span>
                                    </p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Dodaj komentarz</label>
                                <textarea class="form-control" rows="3" name="comments" ng-model="customers.comments"></textarea>
                            </div>
                        </div>

                        <div class="col-sm-12 text-left">
                            <button type="submit" class="btn btn-add" ng-click="addComment()">{{ __('Zapisz') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-sm-12 text-right">
        <button type="submit" class="btn btn-add" ng-show=" ! customer_id" ng-click="save()">{{ __('Dodaj nowego kontrahenta') }}</button>
    </div>
</div>

<script type="text/ng-template" id="CustomersDelete.html">
   <div class="modal-header modal-header-primary">
      <button type="button" class="close" ng-click="cancel()" aria-hidden="true">×</button>
      <h3><i class="fa fa-user m-r-5"></i> Usuń kontrahenta</h3>
   </div>
   <div class="modal-body">
      <div class="row">
         <div class="col-md-12">
            <form class="form-horizontal">
               <fieldset>
                  <div class="col-md-12 form-group user-form-group">
                     <label class="control-label">Czy napewno usunąć?</label>
                     <div class="pull-right">
                        <button type="button" class="btn btn-danger btn-sm" ng-click="cancel()">Nie</button>
                        <button type="submit" class="btn btn-add btn-sm" ng-click="delete(customer_id)">Tak</button>
                     </div>
                  </div>
               </fieldset>
            </form>
         </div>
      </div>
   </div>
   <div class="modal-footer">
      <button type="button" class="btn btn-danger pull-left" ng-click="cancel()">Anuluj</button>
   </div>
</script>