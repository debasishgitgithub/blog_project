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

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <?= get_message(); ?>
      <!-- Default box -->
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title ">Title</h3>
        </div>
        <div class="card-body table-responsive p-2">
          <table class="table table-striped text-center " id="tbl_blogs">
            <thead>
              <tr>
                <th style="width: 1%">S/L</th>
                <th>Category Name</th>
                <th>Title</th>
                <th>Status</th>
                <th>Created On</th>
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
<a href="<?= portal_url("blog/save") ?>" class="btn btn-danger fix-add-btn " title="New Blog"><i class="fa fa-plus"></i></a>
<!-- /.content-wrapper -->
<script>
  $(document).ready(function() {
    let table = $('#tbl_blogs').DataTable({
      responsive: true,
      autoWidth: false,
      serverSide: false,
      "ajax": {
        "url": "<?= base_url('blog/get_all')?>",
        "type": "get",
        // "data": function(d) {
        //   d.registration_no = $('#registration_no').val();
        //   d.from = $('#from').val();
        //   d.to = $('#to').val();
        // },
        "dataSrc": function(d) {
          if (d.code == 200) {
            return d.data.map((v, i) => {
              // var dateObj = new Date(v.datetime);
              // var yyyy = dateObj.getFullYear();
              // var mm = String(dateObj.getMonth() + 1).padStart(2, '0');
              // var dd = String(dateObj.getDate()).padStart(2, '0');
              let action_btns = {
                'edit': `<a href="<?= base_url("blog/save/"); ?>${v.id}" class="btn btn-primary" title="Edit" data-toggle="tooltip"><i class="fas fa-edit"></i></a>`,
              };
              return [
                ++i,
                v.category_name,
                v.title,
                v.status == true ? `<span class="badge badge-success">Active</span>` : `<span class="badge badge-warning">Inactive</span>`,
                v.create_on,
                `<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">${Object.values(action_btns).join('')}</div>`
              ];
            });
          } else if (d.code == 203) {
            toastr.error(d.message);
          }
          return [];
        },
      }
    });
  });
</script>