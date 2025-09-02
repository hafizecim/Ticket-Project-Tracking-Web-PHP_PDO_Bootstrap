<?php include 'header.php'; ?>


<link rel="stylesheet" media="all" type="text/css" href="vendor/upload/css/fileinput.min.css">
<link rel="stylesheet" type="text/css" media="all" href="vendor/upload/themes/explorer-fas/theme.min.css">
<script src="vendor/upload/js/fileinput.js" type="text/javascript" charset="utf-8"></script>
<script src="vendor/upload/themes/fas/theme.min.js" type="text/javascript" charset="utf-8"></script>
<script src="vendor/upload/themes/explorer-fas/theme.minn.js" type="text/javascript" charset="utf-8"></script>

<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="display-4" style="font-size: 2rem;">Proje Ekle</h3>
        </div>
        <div class="card-body">
            <form action="islemler/islem.php" method="POST">
                <div class="form-row mt-2">
                    <div class="col-md-6">
                        <label>Proje Başlığı</label>
                        <input type="text" name="proje_baslik" class="form-control"
                            placeholder="Projenizin başlığını giriniz">
                    </div>
                    <div class="col-md-6">
                        <label>Teslim Tarihi</label>
                        <input type="date" name="proje_teslim_tarihi" class="form-control">
                    </div>
                </div>
                <div class="form-row mt-2">
                    <div class="col-md-6">
                        <label>Proje Aciliyeti</label>
                        <select name="proje_aciliyet" class="form-control">
                            <option value="Acil">Acil</option>
                            <option value="Acelesi Yok">Acelesi Yok</option>
                            <option value="Yeni Başladı">Normal</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Proje Durumu</label>
                        <select name="proje_durum" class="form-control">
                            <option value="Yeni Başladı">Yeni Başladı</option>
                            <option value="Devam Ediyor">Devam Ediyor</option>
                            <option value="Bitti">Bitti</option>
                        </select>
                    </div>
                </div>
                <div class=" form-row mt-2">
                    <div class="col-md-6">
                        <label>Dosya Seçme</label>
                        <input type="file" name="proje_dosya" id="proje_dosya">
                    </div>
                    <div class="col-md-6">
                        <label>Proje Detayı</label>
                        <textarea name="proje_detay" class="form-control" style="height: 306px" ></textarea>
                    </div>
                </div>
                <div class=" form-row mt-4  text-center float-right">
                    <button name="projeekle" type="submit" class="btn btn-primary btn-lg"><i class="fa fa-save"></i>
                        Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php' ?>

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

<script type="text/javascript" src="ckeditor/ckeditor.js"> </script>

