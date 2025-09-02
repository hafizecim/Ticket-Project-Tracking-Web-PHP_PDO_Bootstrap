<?php include 'header.php'; 


// veri tabaınından veri çekme işlemi
$ayarsor=$db->prepare("SELECT * FROM sites");
$ayarsor->execute();
$ayarcek=$ayarsor->fetch(PDO::FETCH_ASSOC);

?>

<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Site Ayarları</h1> <!-- mb-4: margin bottom 4 -->

    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-primary font-weight-bold"><i class="fas fa-cogs mr-2"></i>Site Ayarları</h3> <!-- mr-2: margin right 2 --> <!-- fas fa-cogs: settings icon -->
            <p class="text-muted mb-0">Sitenizin temel ayarlarını buradan düzenleyebilirsiniz.</p> <!-- mb-0: margin bottom 0 --> <!-- text-muted: gray text -->
        </div>
        <div class="card-body">
            <?php if(isset($_GET['status']) && $_GET['status'] == 'success'): ?> <!-- Eğer URL'de status parametresi varsa ve değeri 'success' ise -->
                <div class="alert alert-success alert-dismissible fade show" role="alert"> <!-- Bootstrap success alert -->
                    <i class="fas fa-check-circle mr-2"></i>Ayarlar başarıyla kaydedildi! <!-- fas fa-check-circle: check icon -->
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> 
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <form action="islemler/islem.php" method="POST" accept-charset="utf-8">
                <div class="form-group">
                    <label for="siteTitle">Sitenizin Başlığı</label>
                    <input class="form-control" id="siteTitle" type="text" name="site_title" value="<?php echo $ayarcek['site_title'] ?>">
                </div>
                <div class="form-group">
                    <label for="siteDescription">Sitenizin Açıklaması</label>
                    <textarea class="form-control" id="siteDescription" name="site_description" rows="3"><?php echo $ayarcek['site_description']; ?></textarea>
                    <label for="siteOwnerName">Site Sahibi</label>
                    <input class="form-control" id="siteOwnerName" type="text" name="site_owner_name" value="<?php echo $ayarcek['site_owner_name'] ?>">
                </div>
                <button type="submit" class="btn btn-primary mt-3" name="ayarkaydet">Kaydet</button>
            </form>
        </div>
    </div>

</div>
<?php include 'footer.php'; ?>