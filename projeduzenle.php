<?php include 'header.php'; 

if (isset($_POST['project_id'])) {
	$projesor=$db->prepare("SELECT * FROM projects where project_id=:id");
	$projesor->execute(array(
		'id' => $_POST['project_id']
	));
	$projecek=$projesor->fetch(PDO::FETCH_ASSOC);
} 


?>


<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="display-4" style="font-size: 2rem;">Proje Düzenle</h3>
        </div>
        <div class="card-body">
            <form action="islemler/islem.php" method="POST">
                <div class="form-row mt-2">
                    <div class="col-md-6">
                        <label>Proje İsmi</label>
                        <input type="text" name="project_name" class="form-control"
                            value="<?php echo $projecek['project_name'] ?>">
                    </div>
                    <div class="col-md-6">
                        <label>Teslim Tarihi</label>
                        <input type="date" name="project_estimated_completion_date"  class="form-control" value="<?php echo $projecek['project_estimated_completion_date'] ?>">
                    </div>
                </div>
                <div class="form-row mt-2">
                    <div class="col-md-6">
                        <label>Proje Aciliyeti</label>
                        <select name="project_priority" class="form-control">
                            <option <?php if ($projecek['project_priority'] == "Critical"){echo "selected";} ?> value="Critical">Critical</option>
                            <option <?php if ($projecek['project_priority'] == "High"){echo "selected";} ?> value="High">High</option>
                            <option <?php if ($projecek['project_priority'] == "Medium"){echo "selected";} ?> value="Medium">Medium</option>
                            <option <?php if ($projecek['project_priority'] == "Low"){echo "selected";} ?> value="Low">Low</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Proje Durumu</label>
                        <select name="project_status" class="form-control">
                            <option <?php if ($projecek['project_status'] == "In Progress"){echo "selected";} ?> value="In Progress">In Progress</option>
                            <option <?php if ($projecek['project_status'] == "On Hold"){echo "selected";} ?> value="On Hold">On Hold</option>
                            <option <?php if ($projecek['project_status'] == "Completed"){echo "selected";} ?> value="Completed">Completed</option>
                        </select>
                    </div>
                </div>
                <input type="hidden" name="project_id" value="<?php echo $_POST['project_id'] ?>">
                <div class="form-row mt-2">
                    <label>Project Detayı</label>
                    <textarea name="project_description" class="form-control"><?php echo $projecek['project_description'] ?></textarea>
                </div>
                <button name="projeduzenle" type="submit" class="btn btn-primary mt-2">Kaydet</button>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php' ?>