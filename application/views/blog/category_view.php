<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h4 class="font-weight-bold text-secondary">Manage Category</h4>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right font-weight-bold">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>"><i class="fa fa-home"></i></a></li>
            <li class="breadcrumb-item active">Category</li>
          </ol>
        </div>
      </div>
      <hr class="mb-0 mt-2">
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title font-weight-bold"><i class="fa fa-tasks"></i>&nbsp; Category List</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body table-responsive p-0" style="max-height:400px;">
              <table class="table text-center table-head-fixed">
                <thead>
                  <tr>
                    <th width="17%">S/L</th>
                    <th>Name</th>
                    <th>Acton</th>
                  </tr>
                </thead>
                <tbody id="cat-body">

                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <div class="col-md-6">
          <!-- add Category -->
          <div class="card card-success collapsed-card">
            <div class="card-header">
              <h3 class="card-title font-weight-bold"><i class="fa fa-clipboard"></i>&nbsp; Create New</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool cat-tog" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-plus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <form action="" id="new_cat">
                <div class="form-group">
                  <label for="cat_name">Category Name</label>
                  <input type="text" name="cat_name" id="cat_name" class="form-control" required>
                </div>

                <div class="row">
                  <div class="col-12">
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <button type="button" class="save_new_cat btn btn-success float-right font-weight-bold"><i class="fa fa-save"></i>&nbsp; Save </button>
                  </div>
                </div>
              </form>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

          <!-- Update Category -->
          <div class="card card-info update-card" style="display: none;">
            <div class="card-header">
              <h3 class="card-title font-weight-bold"><i class="fa fa-edit"></i>&nbsp; Category</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="remove">
                  <i class="fas fa-times"></i></button>
              </div>
            </div>
            <div class="card-body">
              <form action="" id="update_cat">
                <div class="form-group">
                  <label for="edit_cat"> Category Name</label>
                  <input type="hidden" name="cat_id" id="cat_id" required>
                  <input type="text" name="edit_cat" id="edit_cat" class="form-control" required>
                </div>

                <div class="row">
                  <div class="col-12">
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <button type="button" class="update_cat btn btn-success float-right font-weight-bold"><i class="fa fa-save"></i>&nbsp; Update</button>
                  </div>
                </div>
              </form>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>

      </div>
    </div>
    <div class="loading">
      <!-- loading -->
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
  $(document).ready(function() {
    // cat_list();

    // function cat_list() {
    //   $.ajax({
    //     url: '<?= base_url("grouping/get_category") ?>',
    //     type: 'post',
    //     dataType: 'json',
    //     success: function(data) {
    //       if (data.status_code == 200) {
    //         $('#cat-body').html(data.response);
    //         tooltps(); // for auto tooltip add
    //       } else if (data.status_code == 403 && data.status == false) {
    //         page_redirect(data.response);
    //       } else {
    //         toastr.error('Something went wrong!!');
    //       }
    //     },
    //     error: function() {
    //       toastr.error("Error! Please refresh the page!");
    //     }
    //   });
    // }


      $("#new_cat").validate({
        rules: {
          cat_name: "required"
        },
        messages: {
          cat_name: "Please enter category name",
        },
        errorElement: "div",
        errorPlacement: function(error, element) {
          // Add the `invalid-feedback` class to the error element
          error.addClass("invalid-feedback");

          if (element.prop("type") === "checkbox") {
            error.insertAfter(element.next("label"));
          } else {
            error.insertAfter(element);
          }
        },
        highlight: function(element, errorClass, validClass) {
          $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function(element, errorClass, validClass) {
          $(element).addClass("is-valid").removeClass("is-invalid");
        }
      });

      $("#update_cat").validate({
        rules: {
          edit_cat: "required"
        },
        messages: {
          edit_cat: "Please enter category name",
        },
        errorElement: "div",
        errorPlacement: function(error, element) {
          // Add the `invalid-feedback` class to the error element
          error.addClass("invalid-feedback");

          if (element.prop("type") === "checkbox") {
            error.insertAfter(element.next("label"));
          } else {
            error.insertAfter(element);
          }
        },
        highlight: function(element, errorClass, validClass) {
          $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function(element, errorClass, validClass) {
          $(element).addClass("is-valid").removeClass("is-invalid");
        }
      });



      // new Category
      $('body').on('click', '.save_new_cat', function() {

        if (!$('#new_cat').valid()) {
          toastr.error('Fill all fields!!');
          return false;
        }
        var formData = $('#new_cat').serialize();
        $.ajax({
          url: '<?= base_url("grouping/category_new") ?>',
          method: 'POST',
          data: formData,
          dataType: 'json',
          beforeSend: function() {
            $('.loading').show();
          },
          success: function(res) {
            $('.loading').hide();
            if (res.status_code == 200) {
              $('#new_cat').trigger('reset');
              $('.cat-tog').trigger('click');
              cat_list();
              toastr.success(res.message);
            } else if (res.status_code == 403 && res.status == false) {
              page_redirect(res.response);
            } else if (res.status == false) {
              toastr.error(res.message);
            } else {
              toastr.error('Something went wrong!!');
            }
          },
          error: function() {
            $('.loading').hide();
            toastr.error("Error! Please refresh the page!");
          }
        });

      });

      // edit Category
      $('body').on('click', '.edit_cat', function() {
        var id = $(this).parent().parent().parent().data('id');
        var cat_name = $(this).parent().parent().siblings('#cat').html();
        if (id != "" && cat_name != "") {
          $('#cat_id').val(id);
          $('#edit_cat').val(cat_name);
          $('.update-card').animate({
            height: 'show'
          });
        }
      });
      $('body').on('click', '.update_cat', function() {
        var id = $('#cat_id').val();
        var cat = $('#edit_cat').val();

        if (!$('#update_cat').valid()) {
          toastr.error('Fill all fields!!');
          return false;
        }
        if (id != "" && cat != "") {
          $.ajax({
            url: '<?= base_url("grouping/update_category") ?>',
            method: 'POST',
            dataType: 'json',
            data: {
              cat_id: id,
              cat_name: cat
            },
            beforeSend: function() {
              $('.loading').show();
            },
            success: function(res) {
              $('.loading').hide();
              if (res.status_code == 200) {
                $('#update_cat').trigger('reset');
                $('.update-card').hide();
                cat_list();
                toastr.success(res.message);
              } else if (res.status_code == 403 && res.status == false) {
                page_redirect(res.response);
              } else if (res.status == false) {
                toastr.error(res.message);
              } else {
                toastr.error('Something went wrong!!');
              }
            },
            error: function() {
              $('.loading').hide();
              toastr.error('error! please refress the page!');
            }
          });
        } else {
          toastr.error('please refress the page! try again!');
        }
      });

      //delete category
      $('body').on('click', '.del_cat', function() {
        var row = $(this).parent().parent().parent();
        var id = row.data('id');
        if (confirm('are you sure want to delete')) {
          $.ajax({
            url: '<?= base_url("grouping/category_del") ?>',
            type: 'POST',
            data: {
              id: id
            },
            dataType: 'json',
            beforeSend: function() {
              $('.loading').show();
            },
            success: function(res) {
              $('.loading').hide();
              if (res.status_code == 200) {
                cat_list();
                toastr.success(res.message);
              } else if (res.status_code == 403 && res.status == false) {
                page_redirect(res.response);
              } else if (res.status == false) {
                toastr.error(res.message);
              } else {
                toastr.error('Something went wrong!!');
              }

            },
            error: function() {
              $('.loading').hide();
              toastr.error("error found!");
            }
          });
        } else {
          return false;
        }
      });

  });
</script>