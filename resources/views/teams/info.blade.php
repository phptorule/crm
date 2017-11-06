<div class="row" data-ng-controller="TeamsCtrl" data-ng-init="getTeam()">
    <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="btn-group" id="buttonlist">
                    <h3>Informacje podstawowe</h3>
                </div>

                <div class="custom_panel_item pull-right" ng-show="teams_id">
                    <a href="javascript:void(0);" ng-show=" ! edit_general" ng-click="editTeam('general')">Edytuj dane <i class="panel-control-icon ti-pencil"></i></a>
                </div>

                <div class="custom_panel_item pull-right" ng-show="edit_general">
                    <a href="javascript:void(0);" ng-click="save()">Zapisz <i class="fa fa-floppy-o"></i></a>
                </div>

                <div class="custom_panel_item pull-right" ng-show="edit_general">
                    <a href="javascript:void(0);" ng-click="cancelEdit('general')">Anuluj</a>
                </div>
            </div>

            <div class="panel-body">
                <form class="no-transition" name="form" method="post" novalidate="novalidate">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Nazwa firmy</label><span class="req_field"> *</span>
                                <span class="form-span" ng-show=" ! edit_general">@{{ team.teams_name }}</span>
                                <input type="text" class="form-control" name="teams_name" ng-show="edit_general" ng-model="team.teams_name" />
                            </div>

                            <div class="form-group">
                                <label>Telefon</label>
                                <span class="form-span" ng-show=" ! edit_general">@{{ team.teams_phone }}</span>
                                <input type="text" class="form-control" name="teams_phone" ng-show="edit_general" ng-model="team.teams_phone" />
                            </div>

                            <div class="form-group">
                                <label>Telefon dodatkowy</label>
                                <span class="form-span" ng-show=" ! edit_general">@{{ team.teams_extra_phone }}</span>
                                <input type="text" class="form-control" name="teams_extra_phone" ng-show="edit_general" ng-model="team.teams_extra_phone" />
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <span class="form-span" ng-show=" ! edit_general">@{{ team.teams_email }}</span>
                                <input type="text" class="form-control" name="teams_email" ng-show="edit_general" ng-model="team.teams_email" />
                            </div>

                            <div class="form-group">
                                <label>Email dodatkowy</label>
                                <span class="form-span" ng-show=" ! edit_general">@{{ team.teams_extra_email }}</span>
                                <input type="text" class="form-control" name="extra_email" ng-show="edit_general" ng-model="team.teams_extra_email" />
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Numer NIP</label>
                                <span class="form-span" ng-show=" ! edit_general">@{{ team.teams_nip }}</span>
                                <input type="text" class="form-control" name="teams_nip" ng-show="edit_general" ng-model="team.teams_nip" />
                            </div>

                            <div class="form-group">
                                <label>Bank</label>
                                <span class="form-span" ng-show=" ! edit_general">@{{ team.teams_bank_name }}</span>
                                <input type="text" class="form-control" name="teams_bank_name" ng-show="edit_general" ng-model="team.teams_bank_name" />
                            </div>

                            <div class="form-group">
                                <label>Konto bankowe</label>
                                <span class="form-span" ng-show=" ! edit_general">@{{ team.teams_bank_account }}</span>
                                <input type="text" class="form-control" name="teams_bank_account" ng-show="edit_general" ng-model="team.teams_bank_account" />
                            </div>

                            <div class="form-group">
                                <label>Strona WWW</label>
                                <span class="form-span" ng-show=" ! edit_general">@{{ team.teams_website }}</span>
                                <input type="text" class="form-control" name="teams_website" ng-show="edit_general" ng-model="team.teams_website" />
                            </div>

                            <div class="form-group">
                                <label>Facebook Id</label>
                                <span class="form-span" ng-show=" ! edit_general">@{{ team.teams_fb_link }}</span>
                                <input type="text" class="form-control" name="teams_fb_link" ng-show="edit_general" ng-model="team.teams_fb_link" />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="btn-group" id="buttonlist">
                    <h3>Informacje adresowe</h3>
                </div>

                <div class="custom_panel_item pull-right" ng-show="teams_id">
                    <a href="javascript:void(0);" ng-show=" ! edit_address" ng-click="editTeam('address')">Edytuj dane <i class="panel-control-icon ti-pencil"></i></a>
                </div>

                <div class="custom_panel_item pull-right" ng-show="edit_address">
                    <a href="javascript:void(0);" ng-click="save()">Zapisz <i class="fa fa-floppy-o"></i></a>
                </div>

                <div class="custom_panel_item pull-right" ng-show="edit_address">
                    <a href="javascript:void(0);" ng-click="cancelEdit('address')">Anuluj</a>
                </div>
            </div>

            <div class="panel-body">
                <form class="no-transition" name="form_address" method="post" novalidate="novalidate">
                    <div class="row">
                        <div class="col-sm-6">
                            <h4>Adres do faktury</h4>
                            <div class="form-group">
                                <label>Ulica</label>
                                <span class="form-span" ng-show=" ! edit_address">@{{ team.teams_invoice_street }}</span>
                                <input type="text" class="form-control" name="teams_invoice_street" ng-show="edit_address" ng-model="team.teams_invoice_street" />
                            </div>

                            <div class="form-group">
                                <label>Miejscowosc</label>
                                <span class="form-span" ng-show=" ! edit_address">@{{ team.teams_invoice_town }}</span>
                                <input type="text" class="form-control" name="teams_invoice_town" ng-show="edit_address" ng-model="team.teams_invoice_town" />
                            </div>

                            <div class="form-group">
                                <label>Wojewodztwo</label>
                                <span class="form-span" ng-show=" ! edit_address">@{{ team.teams_invoice_province }}</span>
                                <input type="text" class="form-control" name="teams_invoice_province" ng-show="edit_address" ng-model="team.teams_invoice_province"  />
                            </div>

                            <div class="form-group">
                                <label>Kod</label>
                                <span class="form-span" ng-show=" ! edit_address">@{{ team.teams_invoice_postcode }}</span>
                                <input type="text" class="form-control" name="teams_invoice_postcode" ng-show="edit_address" ng-model="team.teams_invoice_postcode" />
                            </div>

                            <div class="form-group">
                                <label>Kraj</label>
                                <span class="form-span" ng-show=" ! edit_address">@{{ team.teams_invoice_region }}</span>
                                <input type="text" class="form-control" name="teams_invoice_region" ng-show="edit_address" ng-model="team.teams_invoice_region" />
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <h4>Adres do wysylki</h4>
                            <div class="form-group">
                                <label>Ulica</label>
                                <span class="form-span" ng-show=" ! edit_address">@{{ team.teams_send_street }}</span>
                                <input type="text" class="form-control" name="teams_send_street" ng-show="edit_address" ng-model="team.teams_send_street" />
                            </div>

                            <div class="form-group">
                                <label>Miejscowosc</label>
                                <span class="form-span" ng-show=" ! edit_address">@{{ team.teams_send_town }}</span>
                                <input type="text" class="form-control" name="teams_send_town" ng-show="edit_address" ng-model="team.teams_send_town" />
                            </div>

                            <div class="form-group">
                                <label>Wojewodztwo</label>
                                <span class="form-span" ng-show=" ! edit_address">@{{ team.teams_send_province }}</span>
                                <input type="text" class="form-control" name="teams_send_province" ng-show="edit_address" ng-model="team.teams_send_province" />
                            </div>

                            <div class="form-group">
                                <label>Kod</label>
                                <span class="form-span" ng-show=" ! edit_address">@{{ team.teams_send_postcode }}</span>
                                <input type="text" class="form-control" name="teams_send_postcode" ng-show="edit_address" ng-model="team.teams_send_postcode" />
                            </div>

                            <div class="form-group">
                                <label>Kraj</label>
                                <span class="form-span" ng-show=" ! edit_address">@{{ team.teams_send_region }}</span>
                                <input type="text" class="form-control" name="teams_send_region" ng-show="edit_address" ng-model="team.teams_send_region" />
                            </div>
                        </div>
                    </div>
                </form>
                <p>(<span class="req_field">*</span>) - Wymagane pola</p>
            </div>
        </div>
    </div>

    <div class="col-sm-12 text-right">
        <button type="submit" class="btn btn-add" ng-click="save()">Zapisz</button>
    </div>
</div>