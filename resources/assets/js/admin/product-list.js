/**
 * Page Product List
 */

'use strict';

// Datatable (jquery)
$(function () {
  const select2 = $('.select2');
  if (select2.length) {
    select2.each(function () {
      var $this = $(this);
      $this.wrap('<div class="position-relative"></div>');
      $this.select2({
        placeholder: 'Select value',
        dropdownParent: $this.parent()
      });
    });
  }
  let filesToUpload = [];
  let existingFilesToRemove = [];

  // New Image Preview and Upload
  $('#images').on('change', function () {
    $('#image-preview').empty(); // Clear previous previews

    filesToUpload = Array.from(this.files); // Store files in an array

    const files = this.files;
    if (files) {
      $.each(files, function (index, file) {
        const reader = new FileReader();
        reader.onload = function (e) {
          const colDiv = $('<div>').addClass('col-md-3 position-relative mb-3').attr('id', 'image-preview-' + index);
          const imageWrapper = $('<div>').addClass('image-wrapper');
          const imgElement = $('<img>').attr('src', e.target.result).css({ width: '100%' });
          const removeButton = $('<button>')
            .addClass('btn btn-secondary btn-sm position-absolute top-0 end-0')
            .html('&times;')
            .click(function () {
              colDiv.remove();
              filesToUpload.splice(index, 1); // Remove file from array
              updateFileInput(); // Update the file input with remaining files
            });

          imageWrapper.append(imgElement).append(removeButton);
          colDiv.append(imageWrapper);
          $('#image-preview').append(colDiv);
        };
        reader.readAsDataURL(file);
      });
    }
  });

  // Remove Existing Images
  $('.remove-existing-image').on('click', function () {
    const index = $(this).data('index');
    $(`#existing-image-${index}`).remove(); // Remove from display
    existingFilesToRemove.push(index); // Add to removal list
    $('#removed_images').val(existingFilesToRemove.join(',')); // Update hidden field with removed image indexes
  });

  // Update file input with remaining files
  function updateFileInput() {
    const dataTransfer = new DataTransfer();
    filesToUpload.forEach(file => dataTransfer.items.add(file));
    $('#images')[0].files = dataTransfer.files;
  }

  // On form submit, update file input
  $('#AddProductForm').on('submit', function (e) {
    updateFileInput();
  });
  // Variable declaration for table
  var dt_product_table = $('.datatables-product');

  // Products datatable
  if (dt_product_table.length) {
    var dt_product = dt_product_table.DataTable({
      ajax: dt_product_table.attr('data-url'),
      processing: true,
      serverSide: true,
      columns: [
        { data: 'id' },
        { data: 'name' },          // Assuming 'name' is a product field
        { data: 'rate' },          // Assuming 'rate' is a product field
        { data: 'stitches' },      // Assuming 'stitches' is a product field
        { data: 'area' },         // New column for areas
        { data: 'concept' },       // New column for concept
        { data: 'fabric' },       // New column for fabrics
        { data: 'panna' },        // New column for pannas
        { data: 'technical_concept' },  // New column for technically concepts
        { data: 'use_in' },       // New column for use instructions (use_ins)
        { data: 'yarn' },         // New column for yarns
        { data: 'created_at' },
        { data: 'action', name: 'action' },
      ],
      order: [[0, 'desc']],
      lengthMenu: [7, 10, 25, 50, 75, 100],
      language: { paginate: { next: '<i class="ti ti-chevron-right ti-sm"></i>', previous: '<i class="ti ti-chevron-left ti-sm"></i>' } }
    });
  }
});

let fv;
(function () {
  let setPassValidation = {};

  (function () {
    const AddProductForm = document.getElementById('AddProductForm');
    const submitButton = AddProductForm.querySelector('button[type="submit"]');

    if (AddProductForm) {
      fv = FormValidation.formValidation(AddProductForm, {
        fields: {
          name: {
            validators: {
              notEmpty: {
                message: 'Please enter a product name.'
              },
              stringLength: {
                max: 100,
                message: 'The name must be less than 100 characters.',
              },
            }
          },
          rate: {
            validators: {
              notEmpty: {
                message: 'Please enter a rate.'
              }
            }
          },
          stitches: {
            validators: {
              notEmpty: {
                message: 'Please enter stitches count.'
              }
            }
          },
          areas: {                            // New field for areas
            validators: { notEmpty: { message: 'Please enter areas information.' } }
          },
          concept: {                          // New field for concept
            validators: { notEmpty: { message: 'Please enter concept information.' } }
          },
          fabrics: {                          // New field for fabrics
            validators: { notEmpty: { message: 'Please enter fabric details.' } }
          },
          pannas: {                           // New field for pannas
            validators: { notEmpty: { message: 'Please enter panna details.' } }
          },
          technically_concepts: {             // New field for technically concepts
            validators: { notEmpty: { message: 'Please enter technically concepts.' } }
          },
          use_ins: {                          // New field for use instructions
            validators: { notEmpty: { message: 'Please enter use instructions.' } }
          },
          yarns: {                            // New field for yarns
            validators: { notEmpty: { message: 'Please enter yarn details.' } }
          }
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
    // Set input values
    $('#name').val(data.name);
    $('#design_name').val(data.design_name);
    $('#rate').val(data.rate);
    $('#height').val(data.height);
    $('#stitches').val(data.stitches);
    $('#price').val(data.price);

    // Set dropdowns with proper IDs and trigger 'change' to update them if necessary
    $('#area_id').val(data.area_id).trigger('change');
    $('#concept_id').val(data.concept_id).trigger('change');
    $('#fabric_id').val(data.fabric_id).trigger('change');
    $('#panna_id').val(data.panna_id).trigger('change');
    $('#technical_concept_id').val(data.technical_concept_id).trigger('change');
    $('#use_in_id').val(data.use_in_id).trigger('change');
    $('#yarn_id').val(data.yarn_id).trigger('change');

    // Set form for editing
    $('#offcanvasAddProductLabel').html('Edit Product');
    $('.submit').html('Update');
    $("#AddProductForm").attr('action', updateUrl);
    $("#AddProductForm").append('<input type="hidden" name="_method" value="PUT">');

    if (fv) {
      fv.resetForm();
    }
  });
});

$(document).on('click', '.add-new', function () {
  var storeUrl = ''; // Set your store URL here
  $('.submit').html('Submit');
  $("#AddProductForm").attr('action', storeUrl);
  $("#AddProductForm").append('<input type="hidden" name="_method" value="POST">');
  resetForm();
});

function resetForm() {
  $('#offcanvasAddProductLabel').html('Add Product');
  $('#AddProductForm')[0].reset();
  $('#areas').val('');              // Reset new fields
  $('#concept').val('');            // Reset new fields
  $('#fabrics').val('');            // Reset new fields
  $('#pannas').val('');             // Reset new fields
  $('#technically_concepts').val('');  // Reset new fields
  $('#use_ins').val('');            // Reset new fields
  $('#yarns').val('');              // Reset new fields
  $(".text-danger").addClass("d-none");
  if (fv) {
    fv.resetForm();
  }
}

$('AddProductForm').on('hidden.bs.offcanvas', function () {
  fv.resetForm(true);
  $('.text-danger mb-3').add('d-none');
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
      title: "Are you sure you want to delete this product?",
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
              $('.datatables-product').DataTable().ajax.reload();
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
