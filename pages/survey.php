        
            <!--page title-->
            <div class="page-title mb-4 d-flex align-items-center">
                <div class="mr-auto">
                    <h4 class="weight500 d-inline-block pr-3 mr-3 border-right">Data Rumah Tangga</h4>
                </div>
            </div>
            <!--/page title-->
            <div class="row">
            <?php
                if(isset($_GET['add'])){
                    include "pages/survey/add.php";
                } elseif(isset($_GET['edit'])){
                    include "pages/survey/edit.php";
                } elseif (isset($_GET['view'])) {
                    include "pages/survey/view.php";
                } else {
                    include "pages/survey/home.php";
                }
            ?>
            </div>

                     
<!-- Modal -->
<div class="modal fade" id="modalSurvei" tabindex="-1" role="dialog" aria-labelledby="SurveiIndividu" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form id="modal-survei">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Survei Individu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <div class="form-group mb-3 row">
                                    <label class="col-sm-4 col-form-label col-form-label-sm">NIK</label>
                                    <div class="col-sm-8">
                                        <input type="text" readonly class="form-control" name="m_nik" id="m_nik">
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label class="col-sm-4 col-form-label col-form-label-sm">Nomor KK</label>
                                    <div class="col-sm-8">
                                        <input type="text" readonly class="form-control" name="m_kk" id="m_kk">
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label class="col-sm-4 col-form-label col-form-label-sm">Nama ART</label>
                                    <div class="col-sm-8">
                                        <input type="text" disabled class="form-control" name="m_nama" id="m_nama">
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label class="col-sm-4 col-form-label col-form-label-sm">Usia ART</label>
                                    <div class="col-sm-4">
                                        <input type="text" readonly class="form-control" name="m_tahun" id="m_tahun">
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" disabled class="form-control" name="m_bulan" id="m_bulan">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Pertanyaan Individu</h4>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-10 col-xs-12">
                                <div class="form-group" id="i1">
                                    <label for="exampleInputEmail1">1. Apakah Saudara mempunyai kartu jaminan kesehatan atau JKN?</label>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="jkn" value="Y">
                                                    Ya
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="jkn" value="T">
                                                    Tidak
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="i2">
                                    <label for="exampleInputEmail1">2. Apakah Saudara merokok?</label>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="merokok" value="Y">
                                                    Ya
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="merokok" value="T">
                                                    Tidak
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="i3">
                                    <label for="exampleInputEmail1">3. Apakah Saudara biasa buang air besar di jamban?</label>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="babj" value="Y">
                                                    Ya
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="babj" value="T">
                                                    Tidak
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="i4">
                                    <label for="exampleInputEmail1">4. Apakah Saudara biasa menggunakan air bersih?</label>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="sab2" value="Y">
                                                    Ya
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="sab2" value="T">
                                                    Tidak
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="i5">
                                    <label for="exampleInputEmail1">5. Apakah Saudara pernah didiagnosis menderita tuberkulosis (TB) paru?</label>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="tb" value="Y">
                                                    Ya
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="tb" value="T">
                                                    Tidak
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="i6">
                                    <label for="exampleInputEmail1">6. Bila ya, apakah meminum obat TBC secara teratur (selama 6 bulan)?</label>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="obtbe" value="Y">
                                                    Ya
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="obtbe" value="T">
                                                    Tidak
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="i7">
                                    <label for="exampleInputEmail1">7. Apakah Saudara pernah menderita batuk berdahak > 2 minggu disertai satu atau lebih gejala: dahak bercampur darah/ batuk berdarah, berat badan menurun, berkeringat malam hari tanpa kegiatan fisik, dan demam > 1 bulan?</label>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="batuk" value="Y">
                                                    Ya
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="batuk" value="T">
                                                    Tidak
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="i8">
                                    <label for="exampleInputEmail1">8. Apakah Saudara pernah didiagnosis menderita tekanan darah tinggi/hipertensi?</label>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="hipertensi" value="Y">
                                                    Ya
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="hipertensi" value="T">
                                                    Tidak
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="i9">
                                    <label for="exampleInputEmail1">9. Bila ya, apakah selama ini Saudara meminum obat tekanan darah tinggi/hipertensi secara teratur?</label>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="obhiper" value="Y">
                                                    Ya
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="obhiper" value="T">
                                                    Tidak
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="i10">
                                    <label for="exampleInputEmail1">10.	Apakah dilakukan pengukuran tekanan darah?</label>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="tekanan_darah" value="Y">
                                                    Ya
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="tekanan_darah" value="T">
                                                    Tidak
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="i10a">
                                    <div class="form-group mb-3 row">
                                        <label class="col-sm-2 col-form-label col-form-label-sm">Sistolik</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" name="sistol" id="sistol">
                                        </div>
                                    </div>
                                    <div class="form-group mb-3 row">
                                        <label class="col-sm-2 col-form-label col-form-label-sm">Diastolik</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" name="diastol" id="diastol">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="i11">
                                    <label for="exampleInputEmail1">11. Apakah Saudara atau pasangan Saudara menggunakan alat kontrasepsi atau ikut program Keluarga Berencana?</label>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="kb" value="Y">
                                                    Ya
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="kb" value="T">
                                                    Tidak
                                                </label>
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-2">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="jkn" value="T">
                                                    Tidak, Karena Gangguan Reproduksi
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="jkn" value="T">
                                                    Tidak, Karena Masih Menginginkan Anak dan Jumlah Anak <= 2
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="jkn" value="T">
                                                    Tidak, Karena Sudah Menopause
                                                </label>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                                <div class="form-group" id="i12">
                                    <label for="exampleInputEmail1">12. Apakah dalam 1 bulan terakhir dilakukan pemantauan pertumbuhan balita?</label>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="pantau_balita" value="Y">
                                                    Ya
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="pantau_balita" value="T">
                                                    Tidak
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="i13">
                                    <label for="exampleInputEmail1">13. Apakah saat Ibu melahirkan bersalin di fasilitas pelayanan kesehatan?</label>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="faskes" value="Y">
                                                    Ya
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="faskes" value="T">
                                                    Tidak
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="i14">
                                    <label for="exampleInputEmail1">14. Apakah mendapatkan ASI eksklusif?</label>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="asi_eksklusif" value="Y">
                                                    Ya
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="asi_eksklusif" value="T">
                                                    Tidak
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="i15">
                                    <label for="exampleInputEmail1">15. Apakah mendapatkan imunisasi dasar lengkap?</label>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="imunisasi" value="Y">
                                                    Ya
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="imunisasi" value="T">
                                                    Tidak
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-3 row">
                                    <label class="col-sm-2 col-form-label col-form-label-sm">Keterangan</label>
                                    <div class="col-sm-10">
                                        <textarea name="keterangan_indi" id="keterangan_indi" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="page" id="page" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <input type="submit" name="add_simpan" id="add_simpan" class="finish btn btn-success sweet" value="Simpan"/>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="modalIks" tabindex="-1" role="dialog" aria-labelledby="modalIks" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        </div>
    </div>
</div>