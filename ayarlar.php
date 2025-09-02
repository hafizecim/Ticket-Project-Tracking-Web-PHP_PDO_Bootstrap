<?php include 'header.php'; ?>

<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Site Ayarları</h1>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-primary font-weight-bold"><i class="fas fa-cogs mr-2"></i>Site Ayarları</h3>
            <p class="text-muted mb-0">Sitenizin temel ayarlarını buradan düzenleyebilirsiniz.</p>
        </div>
        <div class="card-body">
            <?php if(isset($_GET['status']) && $_GET['status'] == 'success'): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle mr-2"></i>Ayarlar başarıyla kaydedildi!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> 
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <form action="islemler/islem.php" method="POST" accept-charset="utf-8">
                <div class="form-group">
                    <label for="siteBaslik">Sitenizin Başlığı</label>
                    <input class="form-control" id="siteBaslik" type="text" name="site_title" value="<?php echo $ayarcek['site_title'] ?>">
                </div>
                <div class="form-group">
                    <label for="siteAciklama">Sitenizin Açıklaması</label>
                    <textarea class="form-control" id="siteAciklama" name="site_description" rows="3"><?php echo $ayarcek['site_description']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="siteSahibi">Site Sahibi</label>
                    <input class="form-control" id="siteSahibi" type="text" name="site_owner_name" value="<?php echo $ayarcek['site_owner_name'] ?>">
                </div>
                <button type="submit" class="btn btn-primary mt-3" name="ayarkaydet">Kaydet</button>
            </form>
        </div>
    </div>

</div>
<?php include 'footer.php'; ?>
