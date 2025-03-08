/**
 * Page Fabric List
 */

'use strict';

// Datatable (jquery)
$(function () {
  // Variable declaration for table
  var dt_fabric_table = $('.datatables-fabric');

  // Fabrics datatable
  if (dt_fabric_table.length) {
    var dt_fabric = dt_fabric_table.DataTable({
      ajax: dt_fabric_table.attr('data-url'),
      processing: true,
      serverSide: true,
      columns: [
        { data: 'id' },
        { data: 'name' },
        // { data: 'created_at' },
        { data: 'action', name: 'action' },
      ],
      order: [[0, 'desc']],
      columnDefs: [],
      lengthMenu: [20],
      dom: "<'row'<'col-sm-12'tr>><'row sticky-header'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6 dataTables_pager'p>>",
      displayLength: 7,
      lengthMenu: [7, 10, 25, 50, 75, 100],
      language: { paginate: { next: '<i class="ti ti-chevron-right ti-sm"></i>', previous: '<i class="ti ti-chevron-left ti-sm"></i>' } },
    });
  }
});

let fv;
(function () {
  let setPassValidation = {};

  (function () {
    const AddFabricForm = document.getElementById('AddFabricForm');
    const submitButton = AddFabricForm.querySelector('button[type="submit"]');

    if (AddFabricForm) {
      fv = FormValidation.formValidation(AddFabricForm, {
        fields: {
          name: {
            validators: {
              notEmpty: {
                message: 'Please enter a name.'
              },
              stringLength: {
                max: 20,
                message: 'The name must be less than 20 characters.',
              },
            }
          },
        },
        plugins: {
          trigger: new FormValidation.plugins.Trigger(),
          bootstrap5: new FormValidation.plugins.Bootstrap5({
            eleValidClass: '',
            rowSelector: '.form-group'
          }),
          submitButton: new FormValidation.plugins.SubmitButton(),
          defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
          autoFocus: new FormValidation.plugins.AutoFocus()
        }
      }).on('core.form.valid', function () {
        submitButton.setAttribute('disabled', true);
      });
    }
  })();
})();

// Fetch Edit Data
$(document).on('click', '.edit-record', function () {
  var updateUrl = $(this).data('url');
  var fetchUrl = $(this).data('fetch-url');
  console.log('updateUrl', updateUrl);

  $.get(fetchUrl, function (data) {
    $('#name').val(data.name);
    $('#offcanvasAddFabricLabel').html('Edit Fabric');
    $('.submit').html('Update');
    $('.btn.btn-primary.mt-3').val('Update');
    $("#AddFabricForm").attr('action', updateUrl);
    $("#AddFabricForm").append('<input type="hidden" name="_method" value="PUT">');
    if (fv) {
      fv.resetForm();
    }
  });
});

$(document).on('click', '.add-new', function () {
  var storeUrl = ''; // Set your store URL here
  $('.submit').html('Submit');
  $("#AddFabricForm").attr('action', storeUrl);
  $("#AddFabricForm").append('<input type="hidden" name="_method" value="POST">');
  resetForm();
});

function resetForm() {
  $('#offcanvasAddFabricLabel').html('Add Fabric');
  $('#AddFabricForm')[0].reset();
  $(".text-danger").addClass("d-none");
  if (fv) {
    fv.resetForm();
  }
}

$('#AddFabricForm').on('hidden.bs.offcanvas', function () {
  fv.resetForm(true);
  $('.text-danger.mb-3').addClass('d-none');
});

$('.text-reset').on('click', function () {
  fv.resetForm(true);
  $('.text-danger.mb-3').remove(); // Corrected selector
});

// Delete record
(function () {
  $(document).on('click', '.delete-record', function () {
    var id = $(this).data('id');
    var url = $(this).data('url');
    Swal.fire({
      title: "Are you sure you want to delete this fabric?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'No, cancel!',
      customClass: {
        confirmButton: 'btn btn-primary me-2 waves-effect waves-light',
        cancelButton: 'btn btn-secondary me-2 waves-effect waves-light'
      },
      buttonsStyling: false
    }).then(function (result) {
      if (result.value) {
        $.ajax({
          url: url,
          type: 'DELETE',
          dataType: 'json',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function (response) {
            Swal.fire({
              icon: 'success',
              title: response.success,
              customClass: {
                confirmButton: 'btn btn-success waves-effect waves-light'
              }
            }).then(function () {
              $('.datatables-fabric').DataTable().ajax.reload();
            });
          },
          error: function (xhr, status, error) {
            Swal.fire({
              icon: 'error',
              title: 'Error!',
              text: 'An error occurred while deleting the record.',
              customClass: {
                confirmButton: 'btn btn-danger waves-effect waves-light'
              }
            });
          }
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire({
          title: 'Cancelled',
          text: 'Your record is safe :)',
          icon: 'error',
          customClass: {
            confirmButton: 'btn btn-success waves-effect waves-light'
          }
        });
      }
    });
  });
})();
