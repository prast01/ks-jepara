var url_string = window.location.href; //window.location.href
var url = new URL(url_string);
var c = url.searchParams.get("page");
var file = window.location.origin+'/ks-jepara/assets/function/func.php';
var fileKunci = window.location.origin+'/ks-jepara/assets/function/kunci.php';

function alertNav(a, b, c, d, e='') {
    swal({
        title: a,
        text: b,
        type:c,
        showCancelButton: false,
        confirmButtonClass: "btn-info",
        confirmButtonText: "OK",
        closeOnConfirm: false
    },function(){
        location.href = e+'?page='+d;
    });
}

function alertB(a, b, c) {
    swal(a, b, c);
}

function clickHapus(a, b, c) {
    var data = {'page': a, 'id': b};
    swal({
        title: "Anda Yakin?",
        text: "Data yang sudah terhapus tidak dapat dikembalikan!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Ya, Hapus data ini",
        cancelButtonText: "Batal",
        closeOnConfirm: false,
        closeOnCancel: true
    },
    function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                type:'POST',
                url:file,
                data:data,
                success:function(data){
                    var json=JSON.parse(data);
                    if(json.res==1){
                        alertNav('Sukses!', json.msg, 'success', c);
                    }else{
                        alertB('Error!', json.msg, 'error');
                    }
                }
            });
        }
    });
}

function clickNav(a, b, c) {
    location.href = '?page='+a+'&'+c+'&id='+b;
}

function logout() {
    var data = {'page': 'logout'}
    swal({
        title: "Anda Yakin Keluar?",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Ya",
        cancelButtonText: "Batal",
        closeOnConfirm: false,
        closeOnCancel: true
    },
    function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                type:'POST',
                url:file,
                data:data,
                success:function(data){
                    var json=JSON.parse(data);
                    if(json.res==1){
                        swal({
                            title: 'Sukses!',
                            text: json.msg,
                            type: 'success',
                            showCancelButton: false,
                            confirmButtonClass: "btn-info",
                            confirmButtonText: "OK",
                            closeOnConfirm: false
                        },
                        function(){
                            location.href = '../ks-jepara/';
                        });
                    }else{
                        alertB('Error!', json.msg, 'error');
                    }
                }
            });
        }
    });
}

function cekSesi(time) {
    var data = {'page':'cekSesi', 'time': time};
    setTimeout(function() {
        $.ajax({
            type:'POST',
            url:file,
            data:data,
            success:function(data){
                var json=JSON.parse(data);
                if(json.res==1){
                    swal({
                        title: 'Error!',
                        text: json.msg,
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "OK",
                        closeOnConfirm: false
                    },
                    function(){
                        location.href = '../ks-jepara/';
                    });
                } else {
                    cekSesi(time);
                }
            }
        });
    }, 5000);

}

var time = 60*10;
cekSesi(time);

function makeTable(jsonArr,idHtml){
    var table='<div class="table-responsive">'
    table +='<table id="tbl-'+idHtml+'" class="table table-bordered table-striped">';
    for (let index = 0; index < jsonArr.length; index++) {
        var keys=Object.keys(jsonArr[index]); 
        if(index==0){
            table +='<thead><tr>';
            for (let i=0;i<keys.length;i++) {
                table +='<th>'+keys[i]+'</th>';
            }
            table +='</tr></thead>';
        }
        table +='<tr id="art-'+index+'">';
        for (let i=0;i<keys.length;i++) {
            table +='<td>'+jsonArr[index][keys[i]]+'</td>';
        }
        table +='</tr>';
        
    }
    table +='</table></div>';
    return table;
}

function showTable(page,idHtml,param){
    $.ajax({
        type:'POST',
        url:file,
        data:"page="+page+'&'+param,
        success:function(data){
            //alert(data);
            res=JSON.parse(data);
            if(res.res==1){
                $('#'+idHtml).html(makeTable(res.data,idHtml));
                $('#tbl-'+idHtml).DataTable();
            }else{
                $('#'+idHtml).html(showAlert('warning','peringatan',res.mess));
            }
        }
    });
}


switch (c) {
    case "user":    
        $('#form-user-add').submit(function(e) {
            e.preventDefault();
            var data = $(this).serialize();
            $.ajax({
                type:'POST',
                url:file,
                data:data,
                success:function(data){
                    var json=JSON.parse(data);
                    if(json.res==1){
                        alertNav('Sukses!', json.msg, 'success', 'user');
                    }else{
                        alertB('Error!', json.msg, 'error');
                    }
                }
            });

        });

        $('#form-user-edit').submit(function(e) {
            e.preventDefault();
            var data = $(this).serialize();
            $.ajax({
                type:'POST',
                url:file,
                data:data,
                success:function(data){
                    var json=JSON.parse(data);
                    if(json.res==1){
                        alertNav('Sukses!', json.msg, 'success', 'user');
                    }else{
                        alertB('Error!', json.msg, 'error');
                    }
                }
            });

        });

        $('#form-user-pass').submit(function(e) {
            e.preventDefault();
            var data = $(this).serialize();
            $.ajax({
                type:'POST',
                url:file,
                data:data,
                success:function(data){
                    var json=JSON.parse(data);
                    if(json.res==1){
                        alertNav('Sukses!', json.msg, 'success', 'user');
                    }else{
                        alertB('Error!', json.msg, 'error');
                    }
                }
            });

        });

        break;

    case "survey":
        // placeholder
        $("#jekel").select2({
            placeholder: "Pilih Jenis Kelamin",
            allowClear: true
        });

        $("#agama").select2({
            placeholder: "Pilih Agama",
            allowClear: true
        });

        $("#pend").select2({
            placeholder: "Pilih Pendidikan",
            allowClear: true
        });

        $("#hub_kel").select2({
            placeholder: "Pilih Hubungan Keluarga",
            allowClear: true
        });

        $("#status").select2({
            placeholder: "Pilih Status Perkawinan",
            allowClear: true
        });

        $("#peker").select2({
            placeholder: "Pilih Pekerjaan",
            allowClear: true
        });

		$('#q2').hide();
		$('#q4').hide();
		$('#q6').hide();
        $('#q7').hide();
        $("input[name$='sab']").click(function (e) {
            var a = $(this).val();
            if(a == 'Y'){
                $('#q2').show();
            } else if(a == 'T') {
                $('input:radio[name=sat]').prop('checked', false);
                $('#q2').hide();
            }
        });
        $("input[name$='jk']").click(function (e) {
            // e.preventDefault();
            var a = $(this).val();
            if(a == 'Y'){
                $('#q4').show();
            } else if(a == 'T') {
                $('input:radio[name=js]').prop('checked', false);
                $('#q4').hide();
            }
        });
        $("input[name$='gjb']").click(function (e) {
            // e.preventDefault();
            var a = $(this).val();
            if(a == 'Y'){
                $('input:radio[name=pasung]').prop('checked', false);
                $('#q6').show();
                $('#q7').hide();
            } else if(a == 'T') {
                $('input:radio[name=obat]').prop('checked', false);
                $('#q7').show();
                $('#q6').hide();
            }
        });

        var no_kk = $('#no_kk').val();
        if(no_kk != ''){
            var param = 'no_kk='+no_kk;
            showTable('data-art', 'data-art', param);
            showTable('survei-art', 'survei-art', param);
            var data2 = {'page':'cariSurveiKk', 'no_kk': no_kk};
            $.ajax({
                type:'POST',
                url:file,
                data:data2,
                success:function(data){
                    var json = JSON.parse(data);
                    if (json.data.sab == 'Y') {
                        $('#q2').show();
                    }
                    if (json.data.jk == 'Y') {
                        $('#q4').show();
                    }
                    if (json.data.gjb == 'Y') {
                        $('#q6').show();
                    } else if(json.data.gjb == 'T'){
                        $('#q7').show();
                    }
                    ceklist('sab', json.data.sab);
                    ceklist('sat', json.data.sat);
                    ceklist('jk', json.data.jk);
                    ceklist('js', json.data.js);
                    ceklist('gjb', json.data.gjb);
                    ceklist('obat', json.data.obat_gjb);
                    ceklist('pasung', json.data.pasung);
                    $('#keterangan_kk').val(json.data.keterangan);
                }
            });

        };

		$('#cari_kk').hide();
		$('#ganti_nik').hide();
        $('#no_kk').attr("placeholder", "Masukkan Nomor NIK");

        $('#ganti_nik').click(function (e) {
            e.preventDefault();
            $('#cari_kk').hide();
            $('#ganti_nik').hide();
            $('#cari_nik').show();
            $('#ganti_kk').show();
            $('#no_kk').attr("placeholder", "Masukkan Nomor NIK");
            $('#by').val('nik');
        });

        $('#ganti_kk').click(function (e) {
            e.preventDefault();
            $('#cari_kk').show();
            $('#ganti_nik').show();
            $('#cari_nik').hide();
            $('#ganti_kk').hide();
            $('#no_kk').attr("placeholder", "Masukkan Nomor KK");
            $('#by').val('kk');
        });

        $('#cari_kk').click(function (e) {
            e.preventDefault();
            var puskesmas = $('#puskesmas').val();
            var no_kk = $('#no_kk').val();
            var by = $('#by').val();
            if (no_kk == '') {
                return alertB("Error !", "Nomor KK tidak boleh kosong", "error");
            } else if(no_kk.length < 16){
                return alertB("Error !", "Nomor KK kurang dari 16 digit", "error");
            } else if(no_kk.length == 16){
                swal({
                    title: "Cari No KK?",
                    text: "Akan dicari No KK pada Server Disdukcapil Jepara",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-success",
                    confirmButtonText: "Ya, Cari data ini",
                    cancelButtonText: "Batal",
                    closeOnConfirm: false,
                    closeOnCancel: true
                },
                function(isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            url:fileKunci,
                            type: 'POST',
                            success:function(data){
                                var json = JSON.parse(data);
                                var data = {'page':'getKk', 'no_kk': no_kk, 'by': by, 'kunci': json.kunci, 'puskesmas': puskesmas};
                                $.ajax({
                                    type:'POST',
                                    url:file,
                                    data:data,
                                    success:function(data){
                                        var json2=JSON.parse(data);
                                        if(json2.res==1){
                                            $('#no_kk').val(json2.data.nomor_kk);
                                            $('#nama_kk').val(json2.data.nama_lengkap);
                                            $('#rt').val(json2.data.no_rt);
                                            $('#rw').val(json2.data.no_rw);
                                            $('#jml_art').val(json2.data.jml_art);
                                            $('#alamat').val(json2.data.alamat);
                                            $('#art_dewasa').val(json2.data.art_dewasa);
                                            $('#art_10_54').val(json2.data.art_10_54);
                                            $('#art_12_59').val(json2.data.art_12_59);
                                            $('#art_0_11').val(json2.data.art_0_11);
                                            $('#option_s4').val(json2.data.no_kel).select2('destroy').select2();
                                            // var param = 'no_kk='+no_kk;
                                            // showTable('data-art', 'data-art', param);
                                            // showTable('survei-art', 'survei-art', param);
                                            alertB('Sukses!', json2.msg, 'success');
                                        }else{
                                            alertB('Error!', json2.msg, 'error');
                                        }
                                    }
                                });
    
                            }
                        });
                    }
                });
            } else {
                return alertB("Error !", "Nomor KK lebih dari 16 digit", "error");
            }
            
        });

        $('#cari_nik').click(function (e) {
            e.preventDefault();
            var no_kk = $('#no_kk').val();
            var puskesmas = $('#puskesmas').val();
            var by = $('#by').val();
            if (no_kk == '') {
                return alertB("Error !", "Nomor NIK tidak boleh kosong", "error");
            } else if(no_kk.length < 16){
                return alertB("Error !", "Nomor NIK kurang dari 16 digit", "error");
            } else if(no_kk.length == 16){
                swal({
                    title: "Cari No NIK?",
                    text: "Akan dicari No NIK pada Server Disdukcapil Jepara",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-success",
                    confirmButtonText: "Ya, Cari data ini",
                    cancelButtonText: "Batal",
                    closeOnConfirm: false,
                    closeOnCancel: true
                },
                function(isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            url:fileKunci,
                            type: 'POST',
                            success:function(data){
                                var json = JSON.parse(data);
                                var data = {'page':'getKk', 'no_kk': no_kk, 'by': by, 'kunci': json.kunci, 'puskesmas': puskesmas};
                                $.ajax({
                                    type:'POST',
                                    url:file,
                                    data:data,
                                    success:function(data){
                                        var json2=JSON.parse(data);
                                        if(json2.res==1){
                                            $('#no_kk').val(json2.data.nomor_kk);
                                            $('#nama_kk').val(json2.data.nama_lengkap);
                                            $('#rt').val(json2.data.no_rt);
                                            $('#rw').val(json2.data.no_rw);
                                            $('#jml_art').val(json2.data.jml_art);
                                            $('#alamat').val(json2.data.alamat);
                                            $('#art_dewasa').val(json2.data.art_dewasa);
                                            $('#art_10_54').val(json2.data.art_10_54);
                                            $('#art_12_59').val(json2.data.art_12_59);
                                            $('#art_0_11').val(json2.data.art_0_11);
                                            $('#option_s4').val(json2.data.no_kel).select2('destroy').select2();
                                            var param = 'no_kk='+json2.data.nomor_kk;
                                            showTable('data-art', 'data-art', param);
                                            showTable('survei-art', 'survei-art', param);
                                            alertB('Sukses!', json2.msg, 'success');
                                        }else{
                                            alertB('Error!', json2.msg, 'error');
                                        }
                                    }
                                });

                            }
                        });
                    }
                });
            } else {
                return alertB("Error !", "Nomor NIK lebih dari 16 digit", "error");
            }
            
        });

        var by = $('#by').val();
        $('#no_kk').keypress(function (e) {
            // var key = e.which;
            // if(key == 13){
                // if(by == 'kk'){
                    // $('#cari_kk').click();
                    // return false;
                // } else if(by == 'nik'){
                //     $('#cari_nik').click();
                //     return false;
                // }
            // }
            return event.charCode >= 48 && event.charCode <= 57;
        });

        $('#cari_art').click(function (e) {
            e.preventDefault();
            var nik = $('#nik').val();
            swal({
                title: "Cari No NIK?",
                text: "Akan dicari No NIK pada Server Disdukcapil Jepara",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-success",
                confirmButtonText: "Ya, Cari data ini",
                cancelButtonText: "Batal",
                closeOnConfirm: false,
                closeOnCancel: true
            },
            function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url:fileKunci,
                        type: 'POST',
                        success:function(data){
                            var json = JSON.parse(data);
                            var data = {'page':'getNik', 'nik': nik, 'kunci': json.kunci};
                            $.ajax({
                                type:'POST',
                                url:file,
                                data:data,
                                success:function(data){
                                    var json2=JSON.parse(data);
                                    if(json2.res==1){
                                        $('#nama_art').val(json2.data.nama_lengkap);
                                        $('#tgl_lahir').val(json2.data.tanggal_lahir);
                                        $('#tahun').val(json2.data.umur_thn);
                                        $('#bulan').val(json2.data.umur_bln);
                                        cekHamil(json2.data.umur_thn, json2.data.jenis_kelamin, json2.data.wanita_usia_hamil);
                                        $('#jekel').val(json2.data.jekel).select2('destroy').select2();
                                        $('#agama').val(json2.data.id_agama).select2('destroy').select2();
                                        $('#pend').val(json2.data.id_pendidikan).select2('destroy').select2();
                                        $('#hub_kel').val(json2.data.id_hubkel).select2('destroy').select2();
                                        $('#status').val(json2.data.sts_kawin).select2('destroy').select2();
                                        $('#peker').val(json2.data.id_pekerjaan).select2('destroy').select2();
                                        alertB('Sukses!', json2.msg, 'success');
                                    }else{
                                        $('#nama_art').val("");
                                        $('#tgl_lahir').val("");
                                        $('#tahun').val("");
                                        $('#bulan').val("");
                                        $('#jekel').val("").select2({
                                            placeholder: "Pilih Jenis Kelamin",
                                            allowClear: true
                                        });
                                        $('#agama').val("").select2({
                                            placeholder: "Pilih Agama",
                                            allowClear: true
                                        });
                                        $('#pend').val("").select2({
                                            placeholder: "Pilih Pendidikan",
                                            allowClear: true
                                        });
                                        $('#hub_kel').val("").select2({
                                            placeholder: "Pilih Hubungan Keluarga",
                                            allowClear: true
                                        });
                                        $('#status').val("").select2({
                                            placeholder: "Pilih Status Perkawinan",
                                            allowClear: true
                                        });
                                        $('#peker').val("").select2({
                                            placeholder: "Pilih Pekerjaan",
                                            allowClear: true
                                        });
                                        alertB('Error!', json2.msg, 'error');
                                    }
                                }
                            });

                        }
                    });
                }
            });
            
        });

        $('#nik').keypress(function (e) {
            // var key = e.which;
            // if(key == 13){
            //     $('#cari_art').click();
            //     return false;  
            // }
            
            return event.charCode >= 48 && event.charCode <= 57;
        });

        $('#reset_art').click(function (e) {
            e.preventDefault();
            $('#nik').val("");
            $('#nik').attr("placeholder", "Masukkan NIK");
            $('#nama_art').val("");
            $('#tgl_lahir').val("");
            $('#tahun').val("");
            $('#bulan').val("");
            $('#keterangan_art').val("");
            $('#jekel').val("").select2({
                placeholder: "Pilih Jenis Kelamin",
                allowClear: true
            });
            $('#agama').val("").select2({
                placeholder: "Pilih Agama",
                allowClear: true
            });
            $('#pend').val("").select2({
                placeholder: "Pilih Pendidikan",
                allowClear: true
            });
            $('#hub_kel').val("").select2({
                placeholder: "Pilih Hubungan Keluarga",
                allowClear: true
            });
            $('#status').val("").select2({
                placeholder: "Pilih Status Perkawinan",
                allowClear: true
            });
            $('#peker').val("").select2({
                placeholder: "Pilih Pekerjaan",
                allowClear: true
            });
            $('input:radio[name=usia_hamil]').prop('checked', false);
            $('#q_hamil').hide();
        });

        $('#simpan_art').click(function (e) {
            e.preventDefault();
            var jml_art = $('#jml_art').val();
            var no_kk = $('#no_kk').val();
            var jml = parseInt(jml_art) + 1;

            var nik = $('#nik').val();
            var nama_art = $('#nama_art').val();
            var tgl_lahir = $('#tgl_lahir').val();
            var jekel = $('#jekel').val();
            var agama = $('#agama').val();
            var pend = $('#pend').val();
            var hub_kel = $('#hub_kel').val();
            var tahun = $('#tahun').val();
            var bulan = $('#bulan').val();
            var status = $('#status').val();
            var peker = $('#peker').val();
            var keterangan_art = $('#keterangan_art').val();

            if(jekel == '2'){
                var usia_hamil = $("input[name='usia_hamil']:checked").val();
            } else {
                var usia_hamil = "";
            }

            var data = {
                'page':'simpan-art',
                'no_kk':no_kk,
                'nik':nik,
                'nama_art':nama_art,
                'tgl_lahir':tgl_lahir,
                'jekel':jekel,
                'agama':agama,
                'pend':pend,
                'hub_kel':hub_kel,
                'tahun':tahun,
                'bulan':bulan,
                'status':status,
                'peker':peker,
                'usia_hamil':usia_hamil,
                'keterangan_art':keterangan_art
            }

            swal({
                title: "Simpan ART ini?",
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
                        url:file,
                        data:data,
                        success:function(data){
                            var json2=JSON.parse(data);
                            if(json2.res==1){
                                $('#jml_art').val(jml);
                                var param = 'no_kk='+no_kk;
                                showTable('data-art', 'data-art', param);
                                showTable('survei-art', 'survei-art', param);
                                $('#nik').val("");
                                $('#nik').attr("placeholder", "Masukkan NIK");
                                $('#nama_art').val("");
                                $('#tgl_lahir').val("");
                                $('#tahun').val("");
                                $('#bulan').val("");
                                $('#q_hamil').hide();
                                $('#jekel').val("").select2({
                                    placeholder: "Pilih Jenis Kelamin",
                                    allowClear: true
                                });
                                $('#agama').val("").select2({
                                    placeholder: "Pilih Agama",
                                    allowClear: true
                                });
                                $('#pend').val("").select2({
                                    placeholder: "Pilih Pendidikan",
                                    allowClear: true
                                });
                                $('#hub_kel').val("").select2({
                                    placeholder: "Pilih Hubungan Keluarga",
                                    allowClear: true
                                });
                                $('#status').val("").select2({
                                    placeholder: "Pilih Status Perkawinan",
                                    allowClear: true
                                });
                                $('#peker').val("").select2({
                                    placeholder: "Pilih Pekerjaan",
                                    allowClear: true
                                });
                                alertB('Sukses!', json2.msg, 'success');
                            }else{
                                alertB('Error!', json2.msg, 'error');
                            }
                        }
                    });
                }
            });
        })

        function editArt(nik) {
            var data = {'page':'cariNik', 'nik': nik};
            $.ajax({
                type:'POST',
                url:file,
                data:data,
                success:function(data){
                    var json=JSON.parse(data);
                    if(json.res==1){
                        $('#nik').val(json.data.nik);
                        $('#nama_art').val(json.data.nama);
                        $('#tgl_lahir').val(json.data.tanggal_lahir);
                        $('#tahun').val(json.data.umur_thn);
                        $('#bulan').val(json.data.umur_bln);
                        $('#keterangan_art').val(json.data.keterangan);
                        cekHamil(json.data.umur_thn, json.data.jenis_kelamin, json.data.wanita_usia_hamil);
                        $('#jekel').val(json.data.jenis_kelamin).select2('destroy').select2();
                        $('#agama').val(json.data.agama).select2('destroy').select2();
                        $('#pend').val(json.data.pendidikan).select2('destroy').select2();
                        $('#hub_kel').val(json.data.hub_kel).select2('destroy').select2();
                        $('#status').val(json.data.marital_status).select2('destroy').select2();
                        $('#peker').val(json.data.pekerjaan).select2('destroy').select2();
                        // alertB('Sukses!', json.msg, 'success');
                    }else{
                        alertB('Error!', json.msg, 'error');
                    }
                }
            });
        };

        function hapusArt(nik) {
            var jml_art = $('#jml_art').val();
            var no_kk = $('#no_kk').val();
            var jml = parseInt(jml_art) - 1;
            var data = {'page': 'art-del', 'nik': nik};
            swal({
                title: "Anda Yakin?",
                text: "Data yang sudah terhapus tidak dapat dikembalikan!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Ya, Hapus data ini",
                cancelButtonText: "Batal",
                closeOnConfirm: false,
                closeOnCancel: true
            },
            function(isConfirm) {
                if (isConfirm) {
                    var art = $('#art_wawancara').val();
                    $.ajax({
                        type:'POST',
                        url:file,
                        data:data,
                        success:function(data){
                            var json=JSON.parse(data);
                            if(json.res==1){
                                if (json.ada == 1) {
                                    var jml_wa = parseInt(art)-1;
                                    $('#art_wawancara').val(jml_wa);
                                }
                                $('#jml_art').val(jml);
                                var param = 'no_kk='+no_kk;
                                showTable('data-art', 'data-art', param);
                                showTable('survei-art', 'survei-art', param);
                                alertB('Sukses!', json.msg, 'success');
                            }else{
                                alertB('Error!', json.msg, 'error');
                            }
                        }
                    });
                }
            });
        };


        $('#q_hamil').hide();
        function cekHamil(umur, jekel, hamil) {
            if(jekel == '2' && umur > 10){
                $('#q_hamil').show();
                var radios = $('input:radio[name=usia_hamil]');
                if(hamil == 'Y') {
                    radios.filter('[value=Y]').prop('checked', true);
                } else {
                    radios.filter('[value=T]').prop('checked', true);
                }
            } else {
                $('#q_hamil').hide();
            }
        }
        
		$('#i3').hide();
		$('#i4').hide();
		$('#i5').hide();
		$('#i8').hide();
		$('#i10a').hide();
		$('#i11').hide();
		$('#i12').hide();
		$('#i13').hide();
		$('#i14').hide();
		$('#i15').hide();

        function surveiArt(nik) {
            $('#i6').hide();
            $('#i7').hide();
            $('#i9').hide();
            $('#i10').hide();
            $('input:radio[name=jkn]').prop('checked', false);
            $('input:radio[name=merokok]').prop('checked', false);
            $('input:radio[name=babj]').prop('checked', false);
            $('input:radio[name=sab2]').prop('checked', false);
            $('input:radio[name=tb]').prop('checked', false);
            $('input:radio[name=obtb]').prop('checked', false);
            $('input:radio[name=batuk]').prop('checked', false);
            $('input:radio[name=hipertensi]').prop('checked', false);
            $('input:radio[name=obhiper]').prop('checked', false);
            $('input:radio[name=tekanan_darah]').prop('checked', false);
            $('input:radio[name=kb]').prop('checked', false);
            $('input:radio[name=pantau_balita]').prop('checked', false);
            $('input:radio[name=faskes]').prop('checked', false);
            $('input:radio[name=asi_eksklusif]').prop('checked', false);
            $('input:radio[name=imunisasi]').prop('checked', false);
            $('#sistol').val("");
            $('#diastol').val("");
            $('#keterangan_indi').val("");
            $('#page').val("simpan-survei-art");
            $("#modalSurvei").modal();
            
            var data = {'page':'cariNik', 'nik': nik};
            $.ajax({
                type:'POST',
                url:file,
                data:data,
                success:function(data){
                    var json=JSON.parse(data);
                    if(json.res==1){
                        $('#m_kk').val(json.data.no_kk);
                        $('#m_nik').val(nik);
                        $('#m_nama').val(json.data.nama);
                        $('#m_tahun').val(json.data.umur_thn);
                        $('#m_bulan').val(json.data.umur_bln);
                        var bln = json.data.umur_bln;
                        var thn = json.data.umur_thn;
                        if(bln >=1 && bln <= 6 && thn == 0){
                            $('#i3').hide();
                            $('#i4').hide();
                            $('#i5').hide();
                            // $('#i6').hide();
                            // $('#i7').hide();
                            $('#i8').hide();
                            // $('#i9').hide();
                            // $('#i10').hide();
                            $('#i10a').hide();
                            $('#i11').hide();
                            $('#i12').hide();
                            $('#i13').hide();
                            $('#i14').show();
                            $('#i15').show();
                        }else if(bln >= 7 && thn == 0){
                            $('#i3').hide();
                            $('#i4').hide();
                            $('#i5').hide();
                            // $('#i6').hide();
                            // $('#i7').hide();
                            $('#i8').hide();
                            // $('#i9').hide();
                            // $('#i10').hide();
                            $('#i10a').hide();
                            $('#i11').hide();
                            $('#i12').show();
                            $('#i13').hide();
                            $('#i14').hide();
                            $('#i15').hide();
                        } else if(bln == 0 && thn > 17){
                            if(json.data.jenis_kelamin == '2'){
                                if(json.data.marital_status == '2'){
                                    if(json.data.wanita_usia_hamil == 'T' || json.data.wanita_usia_hamil == null){
                                        if(json.data.ada == '1'){
                                            $('#i3').show();
                                            $('#i4').show();
                                            $('#i5').show();
                                            // $('#i6').show();
                                            // $('#i7').show();
                                            $('#i8').show();
                                            // $('#i9').show();
                                            // $('#i10').show();
                                            $('#i10a').hide();
                                            $('#i11').show();
                                            $('#i12').hide();
                                            $('#i13').show();
                                            $('#i14').hide();
                                            $('#i15').hide();
                                        } else {
                                            $('#i3').show();
                                            $('#i4').show();
                                            $('#i5').show();
                                            // $('#i6').show();
                                            // $('#i7').show();
                                            $('#i8').show();
                                            // $('#i9').show();
                                            // $('#i10').show();
                                            $('#i10a').hide();
                                            $('#i11').show();
                                            $('#i12').hide();
                                            $('#i13').hide();
                                            $('#i14').hide();
                                            $('#i15').hide();
                                        }
                                    } else {
                                        $('#i3').show();
                                        $('#i4').show();
                                        $('#i5').show();
                                        // $('#i6').show();
                                        // $('#i7').show();
                                        $('#i8').show();
                                        // $('#i9').show();
                                        // $('#i10').show();
                                        $('#i10a').hide();
                                        $('#i11').hide();
                                        $('#i12').hide();
                                        $('#i13').hide();
                                        $('#i14').hide();
                                        $('#i15').hide();
                                    }
                                } else {
                                    $('#i3').show();
                                    $('#i4').show();
                                    $('#i5').show();
                                    // $('#i6').show();
                                    // $('#i7').show();
                                    $('#i8').show();
                                    // $('#i9').show();
                                    // $('#i10').show();
                                    $('#i10a').hide();
                                    $('#i11').hide();
                                    $('#i12').hide();
                                    $('#i13').hide();
                                    $('#i14').hide();
                                    $('#i15').hide();
                                }
                            } else if(json.data.jenis_kelamin == '1'){
                                if(json.data.marital_status == '2'){
                                    $('#i3').show();
                                    $('#i4').show();
                                    $('#i5').show();
                                    // $('#i6').show();
                                    // $('#i7').show();
                                    $('#i8').show();
                                    // $('#i9').show();
                                    // $('#i10').show();
                                    $('#i10a').hide();
                                    $('#i11').show();
                                    $('#i12').hide();
                                    $('#i13').hide();
                                    $('#i14').hide();
                                    $('#i15').hide();
                                } else {
                                    $('#i3').show();
                                    $('#i4').show();
                                    $('#i5').show();
                                    // $('#i6').show();
                                    // $('#i7').show();
                                    $('#i8').show();
                                    // $('#i9').show();
                                    // $('#i10').show();
                                    $('#i10a').hide();
                                    $('#i11').hide();
                                    $('#i12').hide();
                                    $('#i13').hide();
                                    $('#i14').hide();
                                    $('#i15').hide();
                                }
                            }

                        } else {
                            $('#i3').hide();
                            $('#i4').hide();
                            $('#i5').hide();
                            // $('#i6').hide();
                            // $('#i7').hide();
                            $('#i8').hide();
                            // $('#i9').hide();
                            // $('#i10').hide();
                            $('#i10a').hide();
                            $('#i11').hide();
                            $('#i12').hide();
                            $('#i13').hide();
                            $('#i14').hide();
                            $('#i15').hide();
                        }


                    }else{
                        alertB('Error!', json.msg, 'error');
                    }
                }
            });
        };

        function ceklist(a, b) {
            $('input:radio[name='+a+']').filter('[value='+b+']').prop('checked', true);
        }

        function editSurveiArt(nik) {
            $('#i6').hide();
            $('#i7').hide();
            $('#i9').hide();
            $('#i10').hide();
            $('#page').val("ubah-survei-art");
            $("#modalSurvei").modal();
            
            var data = {'page':'cariNik', 'nik': nik};
            var data2 = {'page':'cariSurvei', 'nik': nik};
            $.ajax({
                type:'POST',
                url:file,
                data:data,
                success:function(data){
                    var json=JSON.parse(data);
                    if(json.res==1){
                        $('#m_kk').val(json.data.no_kk);
                        $('#m_nik').val(nik);
                        $('#m_nama').val(json.data.nama);
                        $('#m_tahun').val(json.data.umur_thn);
                        $('#m_bulan').val(json.data.umur_bln);
                        var bln = json.data.umur_bln;
                        var thn = json.data.umur_thn;
                        if(bln >=1 && bln <= 6 && thn == 0){
                            $('#i3').hide();
                            $('#i4').hide();
                            $('#i5').hide();
                            // $('#i6').hide();
                            // $('#i7').hide();
                            $('#i8').hide();
                            // $('#i9').hide();
                            // $('#i10').hide();
                            $('#i10a').hide();
                            $('#i11').hide();
                            $('#i12').hide();
                            $('#i13').hide();
                            $('#i14').show();
                            $('#i15').show();
                        }else if(bln >= 7 && thn == 0){
                            $('#i3').hide();
                            $('#i4').hide();
                            $('#i5').hide();
                            // $('#i6').hide();
                            // $('#i7').hide();
                            $('#i8').hide();
                            // $('#i9').hide();
                            // $('#i10').hide();
                            $('#i10a').hide();
                            $('#i11').hide();
                            $('#i12').show();
                            $('#i13').hide();
                            $('#i14').hide();
                            $('#i15').hide();
                        } else if(bln == 0 && thn > 17){
                            if(json.data.jenis_kelamin == '2'){
                                if(json.data.marital_status == '2'){
                                    if(json.data.wanita_usia_hamil == 'T' || json.data.wanita_usia_hamil == null){
                                        if(json.data.ada == '1'){
                                            $('#i3').show();
                                            $('#i4').show();
                                            $('#i5').show();
                                            // $('#i6').show();
                                            // $('#i7').show();
                                            $('#i8').show();
                                            // $('#i9').show();
                                            // $('#i10').show();
                                            $('#i10a').hide();
                                            $('#i11').show();
                                            $('#i12').hide();
                                            $('#i13').show();
                                            $('#i14').hide();
                                            $('#i15').hide();
                                        } else {
                                            $('#i3').show();
                                            $('#i4').show();
                                            $('#i5').show();
                                            // $('#i6').show();
                                            // $('#i7').show();
                                            $('#i8').show();
                                            // $('#i9').show();
                                            // $('#i10').show();
                                            $('#i10a').hide();
                                            $('#i11').show();
                                            $('#i12').hide();
                                            $('#i13').hide();
                                            $('#i14').hide();
                                            $('#i15').hide();
                                        }
                                    } else {
                                        $('#i3').show();
                                        $('#i4').show();
                                        $('#i5').show();
                                        // $('#i6').show();
                                        // $('#i7').show();
                                        $('#i8').show();
                                        // $('#i9').show();
                                        // $('#i10').show();
                                        $('#i10a').hide();
                                        $('#i11').hide();
                                        $('#i12').hide();
                                        $('#i13').hide();
                                        $('#i14').hide();
                                        $('#i15').hide();
                                    }
                                } else {
                                    $('#i3').show();
                                    $('#i4').show();
                                    $('#i5').show();
                                    // $('#i6').show();
                                    // $('#i7').show();
                                    $('#i8').show();
                                    // $('#i9').show();
                                    // $('#i10').show();
                                    $('#i10a').hide();
                                    $('#i11').hide();
                                    $('#i12').hide();
                                    $('#i13').hide();
                                    $('#i14').hide();
                                    $('#i15').hide();
                                }
                            } else if(json.data.jenis_kelamin == '1'){
                                if(json.data.marital_status == '2'){
                                    $('#i3').show();
                                    $('#i4').show();
                                    $('#i5').show();
                                    // $('#i6').show();
                                    // $('#i7').show();
                                    $('#i8').show();
                                    // $('#i9').show();
                                    // $('#i10').show();
                                    $('#i10a').hide();
                                    $('#i11').show();
                                    $('#i12').hide();
                                    $('#i13').hide();
                                    $('#i14').hide();
                                    $('#i15').hide();
                                } else {
                                    $('#i3').show();
                                    $('#i4').show();
                                    $('#i5').show();
                                    // $('#i6').show();
                                    // $('#i7').show();
                                    $('#i8').show();
                                    // $('#i9').show();
                                    // $('#i10').show();
                                    $('#i10a').hide();
                                    $('#i11').hide();
                                    $('#i12').hide();
                                    $('#i13').hide();
                                    $('#i14').hide();
                                    $('#i15').hide();
                                }
                            }

                        } else {
                            $('#i3').hide();
                            $('#i4').hide();
                            $('#i5').hide();
                            // $('#i6').hide();
                            // $('#i7').hide();
                            $('#i8').hide();
                            // $('#i9').hide();
                            // $('#i10').hide();
                            $('#i10a').hide();
                            $('#i11').hide();
                            $('#i12').hide();
                            $('#i13').hide();
                            $('#i14').hide();
                            $('#i15').hide();
                        }
                        
                        $.ajax({
                            type: 'POST',
                            url: file,
                            data: data2,
                            success:function (data) {
                                var json = JSON.parse(data);
                                if(json.data.tb == 'Y'){
                                    $('#i6').show();
                                } else if(json.data.tb == 'T'){
                                    $('#i7').show();
                                }
                                if(json.data.hipertensi == 'Y'){
                                    $('#i9').show();
                                } else if(json.data.hipertensi == 'T'){
                                    $('#i10').show();
                                }
                                if(json.data.tekanan_darah == 'Y'){
                                    $('#i10a').show();
                                }
                                ceklist('jkn', json.data.jkn);
                                ceklist('merokok', json.data.merokok);
                                ceklist('babj', json.data.babj);
                                ceklist('sab2', json.data.sab);
                                ceklist('tb', json.data.tb);
                                ceklist('obtbe', json.data.obat_tb);
                                ceklist('batuk', json.data.batuk);
                                ceklist('hipertensi', json.data.hipertensi);
                                ceklist('obhiper', json.data.obat_hipertensi);
                                ceklist('tekanan_darah', json.data.tekanan_darah);
                                ceklist('kb', json.data.kb);
                                ceklist('pantau_balita', json.data.pantau_balita);
                                ceklist('faskes', json.data.faskes);
                                ceklist('asi_eksklusif', json.data.asi_eksklusif);
                                ceklist('imunisasi', json.data.imunisasi);
                                $('#sistol').val(json.data.sistolik);
                                $('#diastol').val(json.data.diastolik);
                                $('#keterangan_indi').val(json.data.keterangan);
                            }
                        });

                    }else{
                        alertB('Error!', json.msg, 'error');
                    }
                }
            });
        }

        $("input[name$='tb']").click(function (e) {
            var a = $(this).val();
            if(a == 'Y'){
                $('input:radio[name=batuk]').prop('checked', false);
                $('#i6').show();
                $('#i7').hide();
            } else if(a == 'T') {
                $('input:radio[name=obtbe]').prop('checked', false);
                $('#i6').hide();
                $('#i7').show();
            }
        });

        $("input[name$='hipertensi']").click(function (e) {
            var a = $(this).val();
            if(a == 'Y'){
                $('input:radio[name=tekanan_darah]').prop('checked', false);
                $('#i9').show();
                $('#i10').hide();
                $('#i10a').hide();
                $('#sistol').val("");
                $('#diastol').val("");
            } else if(a == 'T') {
                $('input:radio[name=obhiper]').prop('checked', false);
                $('#i9').hide();
                $('#i10').show();
                $('#i10a').hide();
                $('#sistol').val("");
                $('#diastol').val("");
            }
        });
        
        $("input[name$='tekanan_darah']").click(function (e) {
            var a = $(this).val();
            if(a == 'Y'){
                $('#i10a').show();
            } else if(a == 'T') {
                $('#sistol').val("");
                $('#diastol').val("");
                $('#i10a').hide();
            }
        });

        $('#tgl_lahir').change(function (e) {
            var tgl_lahir = $(this).val();
            var today = new Date();
            var birthday = new Date(tgl_lahir);
            var umur_thn = 0;
            var umur_bln = 0;
            var thn = today.getFullYear() - birthday.getFullYear();
            if(thn > 5){
                umur_thn = thn;
            } else {
                var b_t = today.getMonth()+1;
                var b_b = birthday.getMonth()+1;
                if(today.getFullYear() == birthday.getFullYear()){
                    if(b_b < b_t){
                        umur_bln = b_t - b_b;
                    }
                } else if(birthday.getFullYear() < today.getFullYear()){
                    if(b_b < b_t){
                        var b  = b_t - b_b;
                    } else if(b_b > b_t) {
                        var b  = (12-b_b) + b_t;
                    }

                    if(thn > 1){
                        var t = thn * 12;
                    } else {
                        var t = 0;
                    }
                    umur_bln = t + b;
                }
                // umur_bln = (thn * 12) + birthday.getMonth() + 1;
            }

            $('#tahun').val(umur_thn);
            $('#bulan').val(umur_bln);
        });

        function validasiSurveyIndi(thn) {
            var msg = {'res':1};
            if($("input[name='jkn']:checked").length == 0){
                msg = {'res' : 0, 'msg':'Pertanyaan JKN harus diisi !'};
                return msg;
            }
            if($("input[name='merokok']:checked").length == 0){
                msg = {'res' : 0, 'msg':'Pertanyaan merokok harus diisi !'};
                return msg;
            }
            if (thn != 0 && thn > 17) {
                if($("input[name='babj']:checked").length == 0){
                    msg = {'res' : 0, 'msg':'Pertanyaan buang air besar di jamban harus diisi !'};
                    return msg;
                }
                if($("input[name='sab2']:checked").length == 0){
                    msg = {'res' : 0, 'msg':'Pertanyaan tentang menggunakan air bersih harus diisi !'};
                    return msg;
                }
                if($("input[name='tb']:checked").length == 0){
                    msg = {'res' : 0, 'msg':'Pertanyaan menderita TB harus diisi !'};
                    return msg;
                } else {
                    if ($("input[name='tb']:checked").val() == 'Y') {
                        if($("input[name='obtbe']:checked").length == 0){
                            msg = {'res' : 0, 'msg':'Pertanyaan konsumsi obat TB teratur harus diisi !'};
                            return msg;
                        }
                    } else {
                        if($("input[name='batuk']:checked").length == 0){
                            msg = {'res' : 0, 'msg':'Pertanyaan tentang batuk harus diisi !'};
                            return msg;
                        }
                    }
                }
                if($("input[name='hipertensi']:checked").length == 0){
                    msg = {'res' : 0, 'msg':'Pertanyaan menderita hipertensi harus diisi !'};
                    return msg;
                } else {
                    if ($("input[name='hipertensi']:checked").val() == 'Y') {
                        if($("input[name='obhiper']:checked").length == 0){
                            msg = {'res' : 0, 'msg':'Pertanyaan konsumsi obat hipertensi teratur harus diisi !'};
                            return msg;
                        }
                    } else {
                        if($("input[name='tekanan_darah']:checked").length == 0){
                            msg = {'res' : 0, 'msg':'Pertanyaan pernah pengecekan tekanan darah harus diisi !'};
                            return msg;
                        } else {
                            if ($("input[name='tekanan_darah']:checked").val() == 'Y') {
                                if($('#sistol').val() == '' ||$('#diastol').val() == ''){
                                    msg = {'res' : 0, 'msg':'Sistolik atau Diastolik harus diisi !'};
                                    return msg;
                                }
                            }
                        }
                    }
                }
            }

            return msg;

        }

        function resetSurveyIndi() {
            
            $("input[name$='jkn']").prop('checked', false);
            $("input[name$='merokok']").prop('checked', false);
            $("input[name$='babj']").prop('checked', false);
            $("input[name$='sab2']").prop('checked', false);
            $("input[name$='tb']").prop('checked', false);
            $("input[name$='obtbe']").prop('checked', false);
            $("input[name$='batuk']").prop('checked', false);
            $("input[name$='hipertensi']").prop('checked', false);
            $("input[name$='obhiper']").prop('checked', false);
            $("input[name$='tekanan_darah']").prop('checked', false);
            $("input[name$='kb']").prop('checked', false);
            $("input[name$='pantau_balita']").prop('checked', false);
            $("input[name$='faskes']").prop('checked', false);
            $("input[name$='asi_eksklusif']").prop('checked', false);
            $("input[name$='imunisasi']").prop('checked', false);
            $('#sistol').val("");
            $('#diastol').val("");
            $('#keterangan_indi').val("");
        }

        $('#modal-survei').submit(function (e) {
            e.preventDefault();
            var thn = $('#m_tahun').val();
            var data = $(this).serialize();
            var hi = validasiSurveyIndi(thn);
            if (hi.res == 0) {
                alertB("Error !", hi.msg, 'error');
            } else {
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
                        var art = $('#art_wawancara').val();
                        var no_kk = $('#no_kk').val();
                        $.ajax({
                            type:'POST',
                            url:file,
                            data:data,
                            success:function(data){
                                var json=JSON.parse(data);
                                if (json.res == '1') {
                                    var jml_wa = parseInt(art)+1;
                                    $('#art_wawancara').val(jml_wa);
                                    resetSurveyIndi();
                                    alertB("Sukses !", json.msg, 'success');
                                    var param = 'no_kk='+no_kk;
                                    showTable('survei-art', 'survei-art', param);
                                    $("#modalSurvei").modal("hide");
                                } else {
                                    alertB("Error !", json.msg, 'error');
                                    $("#modalSurvei").modal("hide");
                                }
                            }
                        });
                        // console.log(data);
                    }
                });
            }
        });

        function validasiSurveyKK() {
            var msg = {'res':1};
            if ($('#no_urut_rt').val() == '') {
                msg = {'res':0, msg:'Nomor Urut Bangunan tidak boleh kosong'};
                return msg;
            }
            if ($('#no_urut_kel').val() == '') {
                msg = {'res':0, msg:'Nomor Urut Keluarga tidak boleh kosong'};
                return msg;
            }
            if($("input[name='sab']:checked").length == 0){
                msg = {'res' : 0, 'msg':'Pertanyaan tersedianya air bersih harus diisi !'};
                return msg;
            } else {
                if ($("input[name='sab']:checked").val() == 'Y') {
                    if($("input[name='sat']:checked").length == 0){
                        msg = {'res' : 0, 'msg':'Pertanyaan jenis sumber air harus diisi !'};
                        return msg;
                    }
                }
            }
            if($("input[name='jk']:checked").length == 0){
                msg = {'res' : 0, 'msg':'Pertanyaan tersedianya jamban harus diisi !'};
                return msg;
            } else {
                if ($("input[name='jk']:checked").val() == 'Y') {
                    if($("input[name='js']:checked").length == 0){
                        msg = {'res' : 0, 'msg':'Pertanyaan jenis jamban saniter harus diisi !'};
                        return msg;
                    }
                }
            }
            if($("input[name='gjb']:checked").length == 0){
                msg = {'res' : 0, 'msg':'Pertanyaan tentang gangguan jiwa berat harus diisi !'};
                return msg;
            } else {
                if ($("input[name='gjb']:checked").val() == 'Y') {
                    if($("input[name='obat']:checked").length == 0){
                        msg = {'res' : 0, 'msg':'Pertanyaan tentang konsumsi obat gangguan jiwa teratur harus diisi !'};
                        return msg;
                    }
                } else {
                    if($("input[name='pasung']:checked").length == 0){
                        msg = {'res' : 0, 'msg':'Pertanyaan tentang adanya ART yang dipasung harus diisi !'};
                        return msg;
                    }
                }
            }
            
            return msg;
        };

        function modalIks(title, no_kk, page) {
            $("#modalIks").modal();
            $('.modal-content').empty();
            var data = {'page': page, 'no_kk': no_kk, 'title': title};
            $.ajax({
                type:'POST',
                url:file,
                data:data,
                success:function(data){
                    $('.modal-content').prepend(data);
                }
            });

        }

        function ValidasiSimpanKk() {
            var msg = {'res':1};
            if ($('#no_kk').val() == '') {
                msg = {'res':0, msg:'Nomor KK tidak boleh kosong'};
                return msg;
            }
            if ($('#no_urut_rt').val() == '') {
                msg = {'res':0, msg:'Nomor Urut Bangunan tidak boleh kosong'};
                return msg;
            }
            if ($('#no_urut_kel').val() == '') {
                msg = {'res':0, msg:'Nomor Urut Keluarga tidak boleh kosong'};
                return msg;
            }

            return msg;
        }

        // function pindahKk(nik, no_kk) {
        //     swal({
        //         title: "Pindahkan data ini?",
        //         text: "Data akan disimpan ke database.",
        //         type: "warning",
        //         showCancelButton: true,
        //         confirmButtonClass: "btn-success",
        //         confirmButtonText: "Ya, Simpan data ini",
        //         cancelButtonText: "Batal",
        //         closeOnConfirm: false,
        //         closeOnCancel: true
        //     },
        //     function(isConfirm) {
        //         if (isConfirm) {
        //             var art = $('#art_wawancara').val();
        //             var no_kk = $('#no_kk').val();
        //             $.ajax({
        //                 type:'POST',
        //                 url:file,
        //                 data:data,
        //                 success:function(data){
        //                     var json=JSON.parse(data);
        //                     if (json.res == '1') {
        //                         var jml_wa = parseInt(art)+1;
        //                         $('#art_wawancara').val(jml_wa);
        //                         resetSurveyIndi();
        //                         alertB("Sukses !", json.msg, 'success');
        //                         var param = 'no_kk='+no_kk;
        //                         showTable('survei-art', 'survei-art', param);
        //                         $("#modalSurvei").modal("hide");
        //                     } else {
        //                         alertB("Error !", json.msg, 'error');
        //                         $("#modalSurvei").modal("hide");
        //                     }
        //                 }
        //             });
        //             // console.log(data);
        //         }
        //     });
        // }

        break;

    case "laporan":
            
            function modalIks(title, no_kk, page) {
                $("#modalIks").modal();
                $('.modal-content').empty();
                var data = {'page': page, 'no_kk': no_kk, 'title': title};
                $.ajax({
                    type:'POST',
                    url:file,
                    data:data,
                    success:function(data){
                        $('.modal-content').prepend(data);
                    }
                });

            }
        break;

    case "dashboard":
        function dash() {
            var data = {'page':'dash'};
            setTimeout(function() {
                $.ajax({
                    type:'POST',
                    url:file,
                    data:data,
                    success:function(data){
                        var json=JSON.parse(data);
                        if(json.res==1){
                            $('#jml_p').text(json.data.jml_p);
                            $('#jml_kk').text(json.data.jml_kk);
                            $('#jml_iks_i').text(json.data.jml_iks_i);
                            $('#jml_iks_b').text(json.data.jml_iks_b);
                            // dash();
                        }
                    }
                });
            }, 2000);
        
        };

        dash();

        break;

    default:
        $('#login-form').submit(function (e) {
            e.preventDefault();
            var data = $(this).serialize();
            $.ajax({
                type:'POST',
                url:file,
                data:data,
                success:function(data){
                    var json=JSON.parse(data);
                    if(json.res==1){
                        alertNav('Sukses!', json.msg, 'success', 'dashboard', 'home.php');
                    }else{
                        alertB('Error!', json.msg, 'error');
                    }
                }
            });
        });


        break;
}
