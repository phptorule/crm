<div class="row" data-ng-controller="CustomersCtrl" data-ng-init="init()">
    <!-- Form controls -->
    <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="btn-group" id="buttonlist">
                    <h3>Informacje podstawowe</h3>
                </div>
            </div>

            <div class="panel-body">
                <form  name="form" method="post" novalidate="novalidate">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Nazwa firmy</label>
                                <input type="text" class="form-control" name="company_name" placeholder="Nazwa firmy" ng-model="customers.company_name" required />
                            </div>

                            <div class="form-group">
                                <label>Osoba kontaktowa</label>
                                <input type="text" class="form-control" name="contact_person" placeholder="Osoba kontaktowa" ng-model="customers.contact_person" />
                            </div>

                            <div class="form-group">
                                <label>Telefon</label>
                                <input type="email" class="form-control" name="phone_number" placeholder="Telefon" ng-model="customers.phone_number" />
                            </div>

                            <div class="form-group">
                                <label>Telefon dodatkowy</label>
                                <input type="text" class="form-control" name="extra_phone_number" placeholder="Telefon dodatkowy" ng-model="customers.extra_phone_number" />
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" name="email" placeholder="Email" ng-model="customers.email" />
                            </div>

                            <div class="form-group">
                                <label>Email dodatkowy</label>
                                <input type="text" class="form-control" name="extra_email" placeholder="Email dodatkowy" ng-model="customers.extra_email" />
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Numer NIP</label>
                                <input type="text" class="form-control" name="nip" placeholder="Numer NIP" ng-model="customers.nip" />
                            </div>

                            <div class="form-group">
                                <label>Przypisany do</label>
                                <input type="text" class="form-control" name="assign_to" placeholder="Przypisany do" ng-model="customers.assign_to" />
                            </div>

                            <div class="form-group">
                                <label>Konto bankowe</label>
                                <input type="text" class="form-control" name="bank_account" placeholder="Konto bankowe" ng-model="customers.bank_account" />
                            </div>

                            <div class="form-group">
                                <label>Strona WWW</label>
                                <input type="text" class="form-control" name="website" placeholder="Strona WWW" ng-model="customers.website" />
                            </div>

                            <div class="form-group">
                                <label>Facebook Id</label>
                                <input type="text" class="form-control" name="fb_link" placeholder="Facebook Id" ng-model="customers.fb_link" />
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
            </div>

            <div class="panel-body">
                <form  name="address_form" method="post" novalidate="novalidate">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Ulica</label>
                                <input type="text" class="form-control" name="invoice_street" placeholder="Ulica" ng-model="customers.invoice_street" />
                            </div>

                            <div class="form-group">
                                <label>Skrytka Pocztowa do faktury</label>
                                <input type="text" class="form-control" name="invoice_mailbox" placeholder="Skrytka Pocztowa do faktury" ng-model="customers.invoice_mailbox" />
                            </div>

                            <div class="form-group">
                                <label>Miejscowosc</label>
                                <input type="text" class="form-control" name="invoice_town" placeholder="Miejscowosc" ng-model="customers.invoice_town" />
                            </div>

                            <div class="form-group">
                                <label>Wojewodztwo</label>
                                <input type="text" class="form-control" name="invoice_province" placeholder="Wojewodztwo" ng-model="customers.invoice_province"  />
                            </div>

                            <div class="form-group">
                                <label>Kod</label>
                                <input type="text" class="form-control" name="invoice_post_code" placeholder="Kod" ng-model="customers.invoice_post_code" />
                            </div>

                            <div class="form-group">
                                <label>Kraj</label>
                                <input type="text" class="form-control" name="invoice_region" placeholder="Kraj" ng-model="customers.invoice_region" />
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Ulica - Adres wysylki</label>
                                <input type="text" class="form-control" name="send_street" placeholder="Ulica" ng-model="customers.send_street" />
                            </div>

                            <div class="form-group">
                                <label>Skrytka Pocztowa do wysylki</label>
                                <input type="text" class="form-control" name="send_mailbox" placeholder="Skrytka Pocztowa do faktury" ng-model="customers.send_mailbox" />
                            </div>

                            <div class="form-group">
                                <label>Miejscowosc - Adres wysylki</label>
                                <input type="text" class="form-control" name="send_town" placeholder="Miejscowosc" ng-model="customers.send_town" />
                            </div>

                            <div class="form-group">
                                <label>Wojewodztwo - Adres wysylki</label>
                                <input type="text" class="form-control" name="send_province" placeholder="Wojewodztwo" ng-model="customers.send_province" />
                            </div>

                            <div class="form-group">
                                <label>Kod - Adres wysylki</label>
                                <input type="text" class="form-control" name="send_post_code" placeholder="Kod" ng-model="customers.send_post_code" />
                            </div>

                            <div class="form-group">
                                <label>Kraj - Adres wysylki</label>
                                <input type="text" class="form-control" name="send_region" placeholder="Kraj" ng-model="customers.send_region" />
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
                    <h3>Inne</h3>
                </div>
            </div>

            <div class="panel-body">
                <form  name="rest_form" method="post" novalidate="novalidate">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Komentarze</label>
                                <textarea class="form-control" rows="3" name="comments" ng-model="comments"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Typ osoby</label>
                                <select class="form-control" name="customer_type" ng-model="customer_type">
                                    <option value="0">regular</option>
                                    <option value="1">vendor</option>
                                    <option value="2">vip</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-sm-12 text-right">
        <button type="submit" class="btn btn-success" ng-click="save()">{{ __('Add new customer') }}</button>
    </div>
</div>