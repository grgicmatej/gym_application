<!-- profileData Modal -->
<div class="modal fade" id="profileData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-4 bg-c-lite-green" id="modal-body">
                        <div class="card-block text-center text-white" style="padding-top: 25%">
                            <div class="m-b-25"> <img src="https://img.icons8.com/bubbles/100/000000/user.png" class="img-radius" alt="User-Profile-Image"> </div>
                            <h5 class="f-w-600" id="ime"></h5>
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
                                    <h6 class="text-muted f-w-400" id="telefon"></h6>
                                </div>
                                <div class="col-sm-6">
                                    <p class="m-b-10 f-w-600">Datum rođenja</p>
                                    <h6 class="text-muted f-w-400" id="datumrodenja"></h6>
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
                                    <h6 class="text-muted f-w-400" id="imeclanarine"></h6>
                                </div>
                                <div class="col-sm-6">
                                    <p class="m-b-10 f-w-600">Trajanje</p>
                                    <h6 class="text-muted f-w-400" id="trajanjeclanarine"></h6>
                                </div>
                            </div>
                            <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600"></h6>
                            <div class="row">
                                <div class="col-12">
                                    <p class="m-b-10 f-w-600 " id="brojdolazaka"></p>
                                </div>
                            </div>
                            <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600"></h6>
                            <div class="row">
                                <div class="col-sm-4">
                                    <p class="m-b-10 f-w-600 potvrdidolazak" id="potvrdidolazak"></p>
                                </div>
                                <div class="col-sm-2"></div>
                                <div class="col-sm-6">
                                    <p class="m-b-10 membershipData btn btn-block btn-outline-secondary" id="" >Nova članarina</p>
                                    <h6 class="text-muted f-w-400" id="trajanjeclanarine"></h6>
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


<!-- membershipData -->
<div class="modal fade" id="membershipData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-block">
                            <h6 class="m-b-20 p-b-5 b-b-default f-w-600" style="font-size: 18px">Nova članarina</h6>
                            <div class="row forma" id="forma"></div>
                            <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600"></h6>
                            <div class="row">
                                <div class="col-sm-4">
                                    <p class="m-b-10 f-w-600 potvrdidolazak" id="potvrdidolazak"></p>
                                </div>
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4">
                                    <input type="submit" class="m-b-10 btn btn-block btn-outline-info" form="newmembershipform" value="Produži članarinu">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>