<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Blank Page</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= portal_url(''); ?>">Home</a></li>
            <li class="breadcrumb-item active">Blank Page</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!--Add images Modal -->
  <div class="modal fade" id="addImageModel" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Add Images</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="addImageForm">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="exampleFormControlSelect1">Select Category</label>
                  <select class="form-control" name="category">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="exampleFormControlFile1">Select Images</label>
                  <input type="file" name="images" class="form-control-file">
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="addImageSaveBtn">Save</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

      <!-- Default box -->
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title ">Blog Images</h3>
        </div>
        <div class="card-body table-responsive p-2">

        </div>
      </div>
      <!-- /.card -->
    </div>
  </section>

  <!-- /.content -->
</div>
<button type="button" class="btn btn-danger fix-add-btn" id="addImageBtn" title="New Blog Images"><i class="fa fa-plus"></i></button>
<!-- /.content-wrapper -->
<script>
  $(document).ready(function() {
    $("#addImageBtn").click(function() {
      $("#addImageModel").modal('show');
    });

  });
</script>