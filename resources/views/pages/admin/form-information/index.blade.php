@extends('layouts.dashboard')
@section('title', $title)
@section('content')
    <div class="row mb-5">
        <div class="col-md-12" id="boxTable">
            <ul class="nav nav-tabs md-tabs" role="tablist">
                <li class="nav-item"><a class="nav-link active text-uppercase" id="tabRequest" data-toggle="tab" href="#request"
                        role="tab">Permohonan</a>
                    <div class="slide"></div>
                </li>
                <li class="nav-item"><a class="nav-link text-uppercase" id="tabObjection" data-toggle="tab"
                        href="#objection" role="tab">Keberatan</a>
                    <div class="slide"></div>
                </li>
                <li class="nav-item"><a class="nav-link text-uppercase" id="tabComplaint" data-toggle="tab"
                        href="#complaint" role="tab">Pengaduan</a>
                    <div class="slide"></div>
                </li>
                <li class="nav-item"><a class="nav-link text-uppercase" id="tabSatisfaction" data-toggle="tab"
                        href="#satisfaction" role="tab">Kepuasan</a>
                    <div class="slide"></div>
                </li>
            </ul>
            <div class="tab-content card-block" style="padding: 0px; padding-top: 1.25em">
                <div class="tab-pane active" id="request" role="tabpanel">
                    <center>
                        <h5>Loading ....</h5>
                    </center>
                </div>
                <div class="tab-pane" id="objection">
                    <center>
                        <h5>Loading ....</h5>
                    </center>
                </div>
                <div class="tab-pane" id="complaint">
                    <center>
                        <h5>Loading .... </h5>
                    </center>
                </div>
                <div class="tab-pane" id="satisfaction">
                    <center>
                        <h5>Loading .... </h5>
                    </center>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Detail Request -->
    <div class="modal fade bd-example-modal-lg" id="requestModal" tabindex="-1" aria-labelledby="requestModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg   ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="requestModalLabel">Detail Permintaan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Nama :</strong> <span class="text-muted" id="reqName"></span></p>
                    <p><strong>Telpon :</strong> <span class="text-muted"  id="reqPhone"></span></p>
                    <p><strong>Pekerjaan :</strong> <span class="text-muted"  id="reqJob"></span></p>
                    <p><strong>Email :</strong> <span class="text-muted"  id="reqEmail"></span></p>
                    <p><strong>Alamat :</strong> <span class="text-muted"  id="reqAddress"></span></p>
                    <p><strong>Identitas :  </strong></p>
                    <img id="reqImage" src="" alt="identitas" class="img img-responsive img-tumbnail" style="max-width: 400px !important; object-fit: cover;">
                    <hr>
                    <p><strong>Informasi Dibutuhkan :</strong> <span class="text-muted"  id="reqInformation"></span></p>
                    <p><strong>Tujuan :</strong> <span class="text-muted"  id="reqPurpose"></span></p>
                    <p><strong>Cara Memperoleh :</strong> <span class="text-muted"  id="reqHowToGet"></span></p>
                    <p><strong>Cara Menyalin :</strong> <span class="text-muted"  id="reqHotToCopy"></span></p>

                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('js/plugin/datatables/datatables.min.js') }}"></script>
    <script>
        let reqTable = null;
        let objTable = null;
        let comTable = null;
        let satTable = null;


        $(function() {
            $("#request").load("/admin/form/request", function() {
                requestDataTable()
            })
            $("#objection").load("/admin/form/objection", function() {
                objectionDataTable()
            })
            $("#complaint").load("/admin/form/complaint", function() {
                complaintDataTable()
            })
            $("#satisfaction").load("/admin/form/satisfaction", function() {
                satisfactionDataTable()
            })

            $(".tab-pane").hide()
            $("#request").show()


            $("#tabRequest").click(function() {
                showTab("request")
                // requestDataTable()
            })

            $("#tabObjection").click(function() {
                showTab("objection")
            })

            $("#tabComplaint").click(function() {
                showTab("complaint")
            })

            $("#tabSatisfaction").click(function() {
                showTab("satisfaction")
            })
        })


        function showTab(tabName) {
            $(".tab-pane").hide();
            $('#' + tabName).show();
        }

        function getData(id) {
            $.ajax({
                url: `/api/admin/form/${id}/detail`,
                method: "GET",
                dataType: "json",
                success: function(res) {
                    let d = res.data
                    if (d.type == "request") {
                        console.log('data :', d)
                        showRequestModal(d)
                    }

                    if (d.type == "objection") {
                        showObjectionModal(d)
                    }

                    if (d.type == "complaint") {
                        complaintDataTable(d)
                    }

                    if (d.type == "satisfaction") {
                        showSatisfactionModal(d)
                    }

                },
                error: function(err) {
                    console.log("error :", err);
                    showMessage("warning", "flaticon-error", "Peringatan", err.message || err.responseJSON
                        ?.message);
                }
            })
        }

        function showRequestModal(data) {
            $("#reqName").html(data.name);
            $("#reqPhone").html(data.phone);
            $("#reqJob").html(data.job);
            $("#reqEmail").html(data.email);
            $("#reqAddress").html(data.address);
            $("#reqImage").attr("src", data.image)
            $("#reqInformation").html(data.information);
            $("#reqPurpose").html(data.purpose);
            $("#reqHowToGet").html(data.howtoget_information);
            $("#reqHotToCopy").html(data.howtocopy_information);
            $("#requestModal").modal('show');
        }

        function showObjectionModal(data) {
            $("#exampleModal").modal('show');
        }

        function showComplaintModal(data) {
            $("#exampleModal").modal('show');
        }

        function showSatisfactionModal(data) {
            $("#exampleModal").modal('show');
        }

        function refreshData(tableName) {
            if (tableName == "request") {
                reqTable.ajax.reload(null, false);
            } else if (tableName == "objection") {
                objTable.ajax.reload(null, false);
            } else if (tableName == "complaint") {
                comTable.ajax.reload(null, false);
            } else if (tableName == "satisfaction") {
                satTable.ajax.reload(null, false);
            }
        }

        function requestDataTable() {
            const url = "/api/admin/form/request/datatable";
            reqTable = $("#requestDataTable").DataTable({
                searching: true,
                orderng: true,
                lengthChange: true,
                responsive: true,
                processing: true,
                serverSide: true,
                searchDelay: 1000,
                paging: true,
                lengthMenu: [5, 10, 25, 50, 100],
                ajax: url,
                columns: [{
                    data: "action"
                }, {
                    data: "name"
                }, {
                    data: "phone"
                }, {
                    data: "email"
                }, {
                    data: "information"
                }, {
                    data: "purpose"
                }],
                pageLength: 25,
            });
        }

        function objectionDataTable() {
            const url = "/api/admin/form/objection/datatable";
            objTable = $("#objectionDataTable").DataTable({
                searching: true,
                orderng: true,
                lengthChange: true,
                responsive: true,
                processing: true,
                serverSide: true,
                searchDelay: 1000,
                paging: true,
                lengthMenu: [5, 10, 25, 50, 100],
                ajax: url,
                columns: [{
                    data: "action"
                }, {
                    data: "name"
                }, {
                    data: "phone"
                }, {
                    data: "email"
                }, {
                    data: "information"
                }, {
                    data: "description"
                }],
                pageLength: 25,
            });
        }


        function complaintDataTable() {
            const url = "/api/admin/form/complaint/datatable";
            comTable = $("#complaintDataTable").DataTable({
                searching: true,
                orderng: true,
                lengthChange: true,
                responsive: true,
                processing: true,
                serverSide: true,
                searchDelay: 1000,
                paging: true,
                lengthMenu: [5, 10, 25, 50, 100],
                ajax: url,
                columns: [{
                    data: "action"
                }, {
                    data: "name"
                }, {
                    data: "phone"
                }, {
                    data: "email"
                }, {
                    data: "nameof_reported"
                }, {
                    data: "information"
                }],
                pageLength: 25,
            });
        }

        function satisfactionDataTable() {
            const url = "/api/admin/form/satisfaction/datatable";
            satTable = $("#satisfactiontDataTable").DataTable({
                searching: true,
                orderng: true,
                lengthChange: true,
                responsive: true,
                processing: true,
                serverSide: true,
                searchDelay: 1000,
                paging: true,
                lengthMenu: [5, 10, 25, 50, 100],
                ajax: url,
                columns: [{
                    data: "action"
                }, {
                    data: "name"
                }, {
                    data: "date"
                }, {
                    data: "email"
                }, {
                    data: "typeof_service"
                }],
                pageLength: 25,
            });
        }

        function removeData(id, type) {
            let c = confirm("Apakah anda yakin untuk menghapus data ini ?");
            if (c) {
                $.ajax({
                    url: "/api/admin/form",
                    method: "DELETE",
                    data: {
                        id: id
                    },
                    beforeSend: function() {
                        console.log("Loading...")
                    },
                    success: function(res) {
                        refreshData(type);
                        showMessage("success", "flaticon-alarm-1", "Sukses", res.message);
                    },
                    error: function(err) {
                        console.log("error :", err);
                        showMessage("danger", "flaticon-error", "Peringatan", err.message || err.responseJSON
                            ?.message);
                    }
                })
            }
        }
    </script>
@endpush
