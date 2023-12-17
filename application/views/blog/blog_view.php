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
            <li class="breadcrumb-item"><a href="<?=portal_url(''); ?>">Home</a></li>
            <li class="breadcrumb-item active">Blank Page</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

      <!-- Default box -->
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title ">Title</h3>
        </div>
        <div class="card-body table-responsive p-2">
          <table class="table table-striped text-center " id="tbl_departments">
            <thead>
              <tr>
                <th style="width: 1%">S/L</th>
                <th>Name</th>
                <th>Holiday</th>
                <th>Shift</th>
                <th>Leave</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
      <!-- /.card -->
    </div>
  </section>

  <!-- /.content -->
</div>
<a href="<?= portal_url("") ?>" class="btn btn-danger fix-add-btn " title="New Blog"><i class="fa fa-plus"></i></a>
<!-- /.content-wrapper -->