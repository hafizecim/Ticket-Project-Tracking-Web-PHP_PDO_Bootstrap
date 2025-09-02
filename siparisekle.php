<?php include 'header.php'; ?>

<link rel="stylesheet" media="all" type="text/css" href="vendor/upload/css/fileinput.min.css">
<link rel="stylesheet" type="text/css" media="all" href="vendor/upload/themes/explorer-fas/theme.min.css">
<script src="vendor/upload/js/fileinput.js" type="text/javascript" charset="utf-8"></script>
<script src="vendor/upload/themes/fas/theme.min.js" type="text/javascript" charset="utf-8"></script>
<script src="vendor/upload/themes/explorer-fas/theme.minn.js" type="text/javascript" charset="utf-8"></script>

<div class="container">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Sipariş Ekleme</h5>
        </div>
        <div class="card-body">
            <form action="islemler/islem.php" method="POST">
                <div class="form-row mt-3">
                    <div class="col-md-6">
                        <label>İsim Soyisim</label>
                        <input type="text" class="form-control" name="musteri_isim"
                            placeholder="Müşterinizin İsmini Yazın">
                    </div>
                    <div class="col-md-6">
                        <label>Mail Adresi</label>
                        <input type="email" class="form-control" name="musteri_mail"
                            placeholder="Müşterinizin Mail Adresini Yazın">
                    </div>
                </div>
                <div class="form-row mt-2">
                    <div class="col-md-6">
                        <label>Telefon Numarası</label>
                        <input type="number" class="form-control" name="musteri_telefon"
                            placeholder="Müşterinizin Telefon Numarasını Yazın">
                    </div>
                    <div class="col-md-6">
                        <label>Sipariş Başlığı</label>
                        <input type="text" class="form-control" name="sip_baslik"
                            placeholder="Siparişiniz Başlığını Yazınız">
                    </div>
                </div>
                <div class="form-row mt-3">
                    <div class="form-group col-md-6">
                        <label>Sipariş Durumu</label>
                        <select required name="sip_durum" class="form-control">
                            <option>Yeni Başladı</option>
                            <option>Devam Ediyor</option>
                            <option>Bitti</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Ücret (TL)</label>
                        <input type="number" class="form-control" required name="sip_ucret"
                            placeholder="Siparişinizin Ücretini Girin">
                    </div>
                </div>
                <div class="form-row mt-3">
                    <div class="form-group col-md-6">
                        <label>Teslim Tarihi</label>
                        <input type="date" class="form-control" required name="sip_teslim_tarihi"
                            placeholder="Teslim Tarihi">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Aciliyet</label>
                        <select required name="sip_aciliyet" class="form-control">
                            <option>Acil</option>
                            <option>Normal</option>
                            <option>Acelesi Yok</option>
                        </select>
                    </div>
                </div>
                <div class=" form-row mt-2">
                    <div class="col-md-6">
                        <label>Dosya Seçme</label>
                        <input type="file" name="proje_dosya" id="proje_dosya">
                    </div>
                    <div class="col-md-6">
                        <label>Sipariş Detay</label>
                        <textarea name="sip_detay" id="editor" class="form-control"
                            placeholder="Sipariş Detayını Yazınız" style="height: 306px"></textarea>
                    </div>
                </div>
                <div class=" form-row mt-4  text-center float-right">
                    <button type="submit" name="siparisekle" class="btn btn-primary btn-lg"><i class="fa fa-save"></i>
                        Kaydet</button>
                    </dix>
            </form>
        </div>
    </div>
</div>



<?php include 'footer.php'; ?>

<script>
    $(document).ready(function () {
        $("#proje_dosya").fileinput({
            'theme': 'explorer-fas',
            'showUpload': false,
            'showCaption': true,
            showDownload: true,
            allowedFileExtensions: ["jpg", "png", "jpeg", "mp4", "zip", "rar"],
        });
    });
</script>