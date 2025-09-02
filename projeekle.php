<?php include 'header.php'; ?>

<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="display-4" style="font-size: 2rem;">Proje Ekle</h3>
        </div>
        <div class="card-body">
            <form action="islemler/islem.php" method="POST">
                <div class="form-row mt-2">
                    <div class="col-md-6">
                        <label>Proje İsmi</label>
                        <input type="text" name="project_name" class="form-control"
                            placeholder="Projenizin ismini giriniz">
                    </div>

                    <div class="col-md-6">
                        <label>Tahmini Proje Tamamlama Tarihi</label>
                        <input type="date" name="project_estimated_completion_date" class="form-control">
                    </div>
                    
                </div>
                <div class="form-row mt-2">
                    <div class="col-md-6">
                        <label>Proje Statüsü</label>
                        <select name="project_status" class="form-control">
                            <option value="In Progress">In Progress</option>
                            <option value="On Hold">On Hold</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Proje Durumu</label>
                        <select name="project_priority" class="form-control">
                            <option value="Low">Low</option>
                            <option value="Medium">Medium</option>
                            <option value="High">High</option>
                            <option value="Critical">Critical</option>
                        </select>
                    </div>

                    
                </div>
                <div class="form-row mt-2">
                        <label>Proje Açıklaması</label>
                        <textarea name="project_description" class="form-control"
                            placeholder="Projenizin açıklamasını giriniz"></textarea>
                    </div>
                <button name="projeekle" type="submit" class="btn btn-primary mt-2">Kaydet</button>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php' ?>