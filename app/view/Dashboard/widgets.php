<!-- profileData Modal -->
<div class="modal fade" id="profileData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-4 bg-c-lite-green" id="modal-body">
                        <div class="card-block text-center text-white" style="padding-top: 25%">
                            <div class="m-b-25"> <img src="https://img.icons8.com/bubbles/100/000000/user.png" class="img-radius" alt="User-Profile-Image"> </div>
                            <h5 class="f-w-600" id="usersName"></h5>
                            <h6 id="id" class=""></h6>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card-block">
                            <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Informacije</h6>
                            <div class="row">
                                <div class="col-sm-6">
                                    <p class="m-b-10 f-w-600">Email adresa</p>
                                    <h6 class="text-muted f-w-400" id="email"></h6>
                                </div>
                                <div class="col-sm-6">
                                    <p class="m-b-10 f-w-600">Kontakt telefon</p>
                                    <h6 class="text-muted f-w-400" id="usersPhone"></h6>
                                </div>
                                <div class="col-sm-6">
                                    <p class="m-b-10 f-w-600">Datum rođenja</p>
                                    <h6 class="text-muted f-w-400" id="birthday"></h6>
                                </div>
                                <div class="col-sm-6">
                                    <p class="m-b-10 f-w-600">Status</p>
                                    <h6 class="text-muted f-w-400" id="status"></h6>
                                </div>
                            </div>
                            <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600">Članarina</h6>
                            <div class="row">
                                <div class="col-sm-6">
                                    <p class="m-b-10 f-w-600">Ime članarine</p>
                                    <h6 class="text-muted f-w-400" id="membershipName"></h6>
                                </div>
                                <div class="col-sm-6">
                                    <p class="m-b-10 f-w-600">Trajanje</p>
                                    <h6 class="text-muted f-w-400" id="membershipDuration"></h6>
                                </div>
                            </div>
                            <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600"></h6>
                            <div class="row">
                                <div class="col-12">
                                    <p class="m-b-10 f-w-600 " id="numberOfArrivals"></p>
                                </div>
                            </div>
                            <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600"></h6>
                            <div class="row">
                                <div class="col-sm-4">
                                    <p class="m-b-10 f-w-600 potvrdidolazak" id="confirmArrival"></p>
                                </div>
                                <div class="col-sm-2"></div>
                                <div class="col-sm-6">
                                    <p class="m-b-10 membershipData btn btn-block btn-outline-secondary" id="" >Nova članarina</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- profileData Modal end -->

<!-- membershipData Modal start-->
<div class="modal fade" id="membershipData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-block">
                            <h6 class="m-b-20 p-b-5 b-b-default f-w-600" style="font-size: 18px">Nova članarina</h6>
                            <div class="row forma" id="forma">
                                <form id="formforma">
                                <select id="memberships" name="usersMembershipsMembershipName" style="width: 100%; padding: 10px"></select>
                                </form>
                            </div>
                            <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600"></h6>
                            <div class="row">
                                <div class="col-sm-4">
                                </div>
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4">
                                    <input type="submit" class="m-b-10 btn btn-block btn-outline-info" form="formforma" value="Produži članarinu">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- membershipData Modal end -->

<!-- newUserRegistration Modal start -->
<div class="modal fade" id="newUserRegistration" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="container">
                        <div class="card-block">
                            <h6 class="m-b-20 p-b-5 b-b-default f-w-600" style="font-size: 18px">Registracija novog korisnika</h6>
                            <form id="formformaNewUser">
                                <div class="row forma" id="forma">
                                    <div class="col-lg-4 col-md-12">
                                        <label class="nav-item linkanimation f-w-100">ID broj kartice <span class="mandatoryField"> *</span></label><br>
                                        <input type="text" class="newUserInputForm" name="Users_Id" placeholder="ID broj kartice" oninvalid="this.setCustomValidity('Molimo unesite ispravan ID broj')" oninput="setCustomValidity('')" required min="1">
                                    </div>
                                    <div class="col-lg-4 col-md-12">
                                        <label class="nav-item linkanimation f-w-100">Ime korisnika <span class="mandatoryField"> *</span></label><br>
                                        <input type="text" class="newUserInputForm" name="Users_Name" placeholder="Ime korisnika" oninvalid="this.setCustomValidity('Molimo unesite ispravno ime korisnika')" oninput="setCustomValidity('')" required>
                                    </div>
                                    <div class="col-lg-4 col-md-12">
                                        <label class="nav-item linkanimation f-w-100">Prezime korisnika <span class="mandatoryField"> *</span></label><br>
                                        <input type="text" class="newUserInputForm" name="Users_Surname" placeholder="Prezime korisnika" oninvalid="this.setCustomValidity('Molimo unesite ispravno prezime korisnika')" oninput="setCustomValidity('')" required>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-lg-6 col-md-12">
                                        <label class="nav-item linkanimation f-w-100">E-mail adresa korisnika <span class="mandatoryField"> *</span></label><br>
                                        <input type="email" class="newUserInputForm" name="Users_Email" placeholder="E-mail adresa korisnika" oninvalid="this.setCustomValidity('Molimo unesite ispravnu e-mail adresu')" oninput="setCustomValidity('')" required>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <label class="nav-item linkanimation f-w-100">Kontakt telefon korisnika <span class="mandatoryField"> *</span></label><br>
                                        <input type="text" class="newUserInputForm" name="Users_Phone" placeholder="Kontakt telefon korisnika" oninvalid="this.setCustomValidity('Molimo unesite ispravan kontakt telefon korisnika')" oninput="setCustomValidity('')" required >
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-lg-6 col-md-12">
                                        <label class="nav-item linkanimation f-w-100">Adresa korisnika <span class="mandatoryField"> *</span></label><br>
                                        <input type="text" class="newUserInputForm" name="Users_Address" placeholder="Adresa korisnika" oninvalid="this.setCustomValidity('Molimo unesite ispravnu e-mail adresu korisnika')" oninput="setCustomValidity('')" required >
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <label class="nav-item linkanimation f-w-100">Mjesto korisnika <span class="mandatoryField"> *</span></label><br>
                                        <input type="text" class="newUserInputForm" name="Users_City" placeholder="Mjesto korisnika" oninvalid="this.setCustomValidity('Molimo unesite ispravno ime korisnika')" oninput="setCustomValidity('')" required>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-lg-6 col-md-12">
                                        <label class="nav-item linkanimation f-w-100">OIB korisnika <span class="mandatoryField"> *</span></label><br>
                                        <input type="text" class="newUserInputForm" name="Users_Oib" min="11" max="11" placeholder="OIB korisnika" oninvalid="this.setCustomValidity('Molimo unesite ispravan OIB korisnika')" oninput="setCustomValidity('')" required >
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <label class="nav-item linkanimation f-w-100">Datum rođenja korisnika <span class="mandatoryField"> *</span></label><br>
                                        <input type="date" class="newUserInputForm" name="Users_Birthday" placeholder="Datum rođenja korisnika" max="<?= date('Y-m-d'); ?>" oninvalid="this.setCustomValidity('Molimo unesite ispravan datum rođenja')" oninput="setCustomValidity('')" required >
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-lg-4 col-md-12">
                                        <label class="nav-item linkanimation f-w-100">Spol korisnika <span class="mandatoryField"> *</span></label><br>
                                        <select id="gender" class="newUserInputForm" name="Users_Gender">
                                        <option value="Muško" class="newUserInputForm" selected>Muško</option>
                                        <option value="Žensko">Žensko</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-md-12">
                                        <label class="nav-item linkanimation f-w-100">Status korisnika <span class="mandatoryField"> *</span></label><br>
                                        <select id="status" class="newUserInputForm" name="Users_Status">
                                            <option value="Zaposlen/a" selected>Zaposlen/a</option>
                                            <option value="Student/ica">Student/ica</option>
                                            <option value="Učenik/ca">Učenik/ca</option>
                                            <option value="Umirovljenik/ica">Umirovljenik/ica</option>
                                            <option value="Nezaposlen/a">Nezaposlen/a</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-md-12">
                                        <label class="nav-item linkanimation f-w-100">Referenca korisnika <span class="mandatoryField"> *</span></label><br>
                                        <select id="reference" class="newUserInputForm" name="Users_Reference">
                                            <option value="Preporuka druge osobe">Preporuka druge osobe</option>
                                            <option value="Društvene mreže" selected>Društvene mreže</option>
                                            <option value="Na radnom mjestu">Na radnom mjestu</option>
                                            <option value="Drugo">Drugo</option>
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-lg-7 col-md-12">
                                        <label class="nav-item linkanimation f-w-100">Firma / ustanova / fakultet korisnika</label><br>
                                        <input class="newUserInputForm" name="Users_Company" id="inputEmailAddress" type="text" placeholder="Unesi firmu/ustanovu/fakultet korisnika (neobavezno)">
                                    </div>
                                    <div class="col-lg-1"></div>
                                    <div class="col-lg-4 col-md-12">
                                        <label class="nav-item linkanimation f-w-100">Slika korisnika</label><br>
                                        <input type="file" name="myfile" id="fileToUpload">
                                    </div>
                                </div>
                            </form>
                            <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600"></h6>
                            <div class="row">
                                <div class="col-sm-4">
                                    <span class="mandatoryField linkanimation">*  Obavezna polja</span>
                                </div>
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4">
                                    <input type="submit" class="m-b-10 btn btn-block btn-outline-info" form="formformaNewUser" value="Registracija korisnika">
                                </div>
                            </div>
                            <br>
                        </div>
            </div>
        </div>
    </div>
</div>
<!-- newUserRegistration Modal end -->

<!-- staffSettings Modal start -->
<div class="modal fade" id="staffSettings" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="container">
                <div class="card-block">
                    <h6 class="m-b-20 p-b-5 b-b-default f-w-600" style="font-size: 18px">Korisničke postavke</h6>
                    <br>
                    <form id="formformaStaffSettingsPassword">
                        <div class="row">
                            <div class="col-12"><p>Postavljanje nove lozinke</p></div>
                            <div class="col-lg-6 col-md-12">
                                <label class="nav-item linkanimation f-w-100">Trenutna lozinka<span class="mandatoryField"> *</span></label><br>
                                <input type="password" class="newUserInputForm" name="Staff_Password" placeholder="Trenutna lozinka" oninvalid="this.setCustomValidity('Ovo polje ne smije biti prazno.')" oninput="setCustomValidity('')" required>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <label class="nav-item linkanimation f-w-100">Nova lozinka <span class="mandatoryField"> *</span></label><br>
                                <input type="password" class="newUserInputForm" name="Staff_New_Password" placeholder="Nova lozinka" oninvalid="this.setCustomValidity('Ovo polje ne smije biti prazno i lozinka mora imati više od 6 znakova.')" oninput="setCustomValidity('')" minlength="6" required >
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                <span class="mandatoryField linkanimation">*  Obavezna polja</span>
                            </div>
                            <div class="col-sm-4"></div>
                            <div class="col-sm-4">
                                <input type="submit" class="m-b-10 btn btn-block btn-outline-info" form="formformaStaffSettingsPassword" value="Spremanje lozinke">
                            </div>
                        </div>
                    </form>

                    <form id="formformaStaffSettingsData">
                        <div class="dropdown-divider"></div>
                            <br>

                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <label class="nav-item linkanimation f-w-100">OIB <span class="mandatoryField"> *</span></label><br>
                                    <input type="text" class="newUserInputForm" name="Staff_Oib" min="11" max="11" placeholder="OIB korisnika" oninvalid="this.setCustomValidity('Molimo unesite ispravan OIB korisnika')" oninput="setCustomValidity('')" required value="<?=$staffData->Staff_Oib?>">
                                </div>
                            </div>
                        <br>
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <label class="nav-item linkanimation f-w-100">Kontakt telefon <span class="mandatoryField"> *</span></label><br>
                                    <input type="text" class="newUserInputForm" name="Staff_Phone" placeholder="Kontakt telefon" max="<?= date('Y-m-d'); ?>" oninvalid="this.setCustomValidity('Molimo unesite ispravan kontakt telefon')" oninput="setCustomValidity('')" required value="<?=$staffData->Staff_Phone?>">
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <label class="nav-item linkanimation f-w-100">Kontakt email <span class="mandatoryField"> *</span></label><br>
                                    <input type="email" class="newUserInputForm" name="Staff_Email" placeholder="Kontakt e-mail adresa" max="<?= date('Y-m-d'); ?>" oninvalid="this.setCustomValidity('Molimo unesite ispravnu e-mail adresu')" oninput="setCustomValidity('')" required value="<?=$staffData->Staff_Email?>">
                                </div>
                            </div>
                            <br>
                        <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600"></h6>
                        <div class="row">
                            <div class="col-sm-4">
                                <span class="mandatoryField linkanimation">*  Obavezna polja</span>
                            </div>
                            <div class="col-sm-4"></div>
                            <div class="col-sm-4">
                                <input type="submit" class="m-b-10 btn btn-block btn-outline-info" form="formformaStaffSettingsData" value="Spremanje podataka">
                            </div>
                        </div>
                        <br>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- staffSettings Modal end -->