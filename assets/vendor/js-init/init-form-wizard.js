
var file2 = window.location.origin+'/ks-jepara/assets/function/func.php';
var fileKunci2 = window.location.origin+'/ks-jepara/assets/function/kunci.php';
$(function() {
    $('#default').stepy({
        backLabel: 'Kembali',
        block: true,
        nextLabel: 'Lanjut',
        titleClick: false,
        titleTarget: '.stepy-tab',
        next: function(){
            var cek = ValidasiSimpanKk();
            if (cek.res) {
                $.ajax({
                    url:fileKunci2,
                    type: 'POST',
                    success:function(data){
                        var json = JSON.parse(data);
                        var no_kk = $('#no_kk').val();
                        var puskesmas = $('#puskesmas').val();
                        var no_kel = $('#no_urut_kel').val();
                        var no_rt = $('#no_urut_rt').val();
                        var cek2 = $('#cek').val();
                        var data = {'page':'simpan-kk', 'no_kk': no_kk, 'puskesmas': puskesmas, 'no_kel': no_kel, 'no_rt': no_rt, 'kunci': json.kunci};
                        if (cek2 == 0) {
                            swal({
                                title: "Simpan data KK ini?",
                                text: "Data akan disimpan ke database.",
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonClass: "btn-success",
                                confirmButtonText: "Ya, Simpan data ini",
                                cancelButtonText: "Batal",
                                closeOnConfirm: false,
                                closeOnCancel: true
                            },
                            function(isConfirm) {
                                if (isConfirm) {
                                    $.ajax({
                                        type:'POST',
                                        url:file2,
                                        data:data,
                                        success:function(data){
                                            var json=JSON.parse(data);
                                            if (json.res == '1') {
                                                alertB('Sukses!', json.msg, 'success');
                                                var param = 'no_kk='+no_kk;
                                                showTable('data-art', 'data-art', param);
                                                showTable('survei-art', 'survei-art', param);
                                                $('#cek').val("1");
                                            } else {
                                                alertB('Error!', json.msg, 'error');
                                                // swal({
                                                //     title: 'Error!',
                                                //     text: json.msg,
                                                //     type:'error',
                                                //     showCancelButton: true,
                                                //     confirmButtonClass: "btn-danger",
                                                //     confirmButtonText: "Ya",
                                                //     cancelButtonText: "Batal",
                                                //     closeOnConfirm: false,
                                                //     closeOnCancel: true
                                                // },
                                                // function(isConfirm) {
                                                //     if (isConfirm) {
                                                //         window.open('?page=survey&view&id='+json.data.nik+'&no_kk='+json.data.no_kk, '_blank');
                                                //         console.log(json.data.nik);
                                                //     }
                                                // });
                                            }
                                        }
                                    });
                                }
                            });
                        }
                    }
                });
            } else {
                alertB("Error !", cek.msg, "error");
            }
        },
        finish: function(){
            $('#default').submit(function (e) {
                e.preventDefault();
                var cek = validasiSurveyKK();
                var data = $(this).serialize();
                if (cek.res) {
                    swal({
                        title: "Simpan data survei ini?",
                        text: "Data akan disimpan ke database.",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-success",
                        confirmButtonText: "Ya, Simpan data ini",
                        cancelButtonText: "Batal",
                        closeOnConfirm: false,
                        closeOnCancel: true
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                type:'POST',
                                url:file2,
                                data:data,
                                success:function(data){
                                    var json=JSON.parse(data);
                                    if (json.res == '1') {
                                        alertNav('Sukses!', json.msg, 'success', 'survey');
                                    } else {
                                        alertB("Error !", json.msg, 'error');
                                    }
                                }
                            });
                            // console.log(data);
                        }
                    });
                    // console.log(data);
                } else {
                    alertB("Error !", cek.msg, "error");
                }
            })
        }
    });
});

$(document).ready(function () {
    var form = $("#wizard-validation-form");
    form.validate({
        errorPlacement: function errorPlacement(error, element) {
            element.after(error);
        }
    });
    form.children("div").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        onStepChanging: function (event, currentIndex, newIndex) {
            form.validate().settings.ignore = ":disabled,:hidden";
            return form.valid();
        },
        onFinishing: function (event, currentIndex) {
            form.validate().settings.ignore = ":disabled";
            return form.valid();
        },
        onFinished: function (event, currentIndex) {
            alert("Submitted!");
        }
    }).validate({
        errorPlacement: function errorPlacement(error, element) {
            element.after(error);
        },
        rules: {
            confirm: {
                equalTo: "#password"
            }
        }
    });
});