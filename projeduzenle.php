<?php include 'header.php';

if (isset($_POST['proje_id'])) {
    $projesor = $db->prepare("SELECT * FROM proje where proje_id=:id");
    $projesor->execute(array(
        'id' => $_POST['proje_id']
    ));
    $projecek = $projesor->fetch(PDO::FETCH_ASSOC);
}

$dosyayolu=$projecek['dosya_yolu'];

?>

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
            <form action="islemler/islem.php" method="POST" enctype="multipart/form-data"  data-parsley-validate>
                <div class="form-row mt-2">
                    <div class="col-md-6">
                        <label>Proje Başlığı</label>
                        <input type="text" name="proje_baslik" class="form-control"
                            value="<?php echo $projecek['proje_baslik'] ?>">
                    </div>
                    <div class="col-md-6">
                        <label>Teslim Tarihi</label>
                        <input type="date" name="proje_teslim_tarihi" class="form-control"
                            value="<?php echo $projecek['proje_teslim_tarihi'] ?>">
                    </div>
                </div>
                <div class="form-row mt-2">
                    <div class="col-md-6">
                        <label>Proje Aciliyeti</label>
                        <select name="proje_aciliyet" class="form-control">
                            <option <?php if ($projecek['proje_aciliyet'] == "Acil") {
                                echo "selected";
                            } ?> value="Acil">
                                Acil</option>
                            <option <?php if ($projecek['proje_aciliyet'] == "Acelesi Yok") {
                                echo "selected";
                            } ?>
                                value="Acelesi Yok">Acelesi Yok</option>
                            <option <?php if ($projecek['proje_aciliyet'] == "Normal") {
                                echo "selected";
                            } ?>
                                value="Yeni Başladı">Normal</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Proje Durumu</label>
                        <select name="proje_durum" class="form-control">
                            <option <?php if ($projecek['proje_durum'] == "Yeni Başladı") {
                                echo "selected";
                            } ?>
                                value="Yeni Başladı">Yeni Başladı</option>
                            <option <?php if ($projecek['proje_durum'] == "Devam Ediyor") {
                                echo "selected";
                            } ?>
                                value="Devam Ediyor">Devam Ediyor</option>
                            <option <?php if ($projecek['proje_durum'] == "Bitti") {
                                echo "selected";
                            } ?> value="Bitti">
                                Bitti</option>
                        </select>
                    </div>
                </div>
                <input type="hidden" name="proje_id" value="<?php echo $_POST['proje_id'] ?>">
                <div class=" form-row mt-2">
                    <div class="col-md-6">
                        <label>Dosya Seçme</label>
                        <input type="file" name="proje_dosya" id="projedosya">
                    </div>
                    <div class="col-md-6">
                        <label>Proje Detayı</label>
                        <textarea name="proje_detay" class="form-control"  style="height: 306px";><?php echo $projecek['proje_detay'] ?></textarea>
                    </div>
                </div>
                <div class="form-row mt-4 text-center float-right">
                    <button name="projeduzenle" type="submit" class="btn btn-primary btn-lg"><i class="fa fa-save"></i>
                        Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php' ?>

<?php 
if (strlen($dosyayolu)>10) {?>
	<script>
		$(document).ready(function () {
			var url1='<?php echo $dosyayolu ?>'
			$("#projedosya").fileinput({
				'theme': 'explorer-fas',
				'showUpload': false,
				'showCaption': true,
				'showDownload': true,
			//	'initialPreviewAsData': true,
			allowedFileExtensions: ["jpg", "png", "jpeg", "mp4", "zip", "rar"],
			initialPreview: [
			'<img src="dosyalar/<?php echo $dosyayolu ?>" style="height:100px" class="file-preview-image" alt="Dosya" title="Dosya">'
			],
			initialPreviewConfig: [
			{downloadUrl: url1,
				showRemove: false,
			},
			],
		});

		});
	</script>
<?php } else { ?>
	<script>
		$(document).ready(function () {
			$("#projedosya").fileinput({
				'theme': 'explorer-fas',
				'showUpload': false,
				'showCaption': true,
				'showDownload': true,
			//	'initialPreviewAsData': true,
			allowedFileExtensions: ["jpg", "png", "jpeg", "mp4", "zip", "rar"],
		});

		});
	</script>
<?php } ?>