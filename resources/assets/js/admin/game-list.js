/**
 * Page Game List
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
  $('#AddGameForm').on('submit', function (e) {
    updateFileInput();
  });

  // Variable declaration for table
  var dt_game_table = $('.datatables-game');

  // Games datatable
  if (dt_game_table.length) {
    var dt_game = dt_game_table.DataTable({
      ajax: dt_game_table.attr('data-url'),
      processing: true,
      serverSide: true,
      columns: [
        { data: 'id' },
        { data: 'name' },
        { data: 'description' },
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
    const AddGameForm = document.getElementById('AddGameForm');
    const submitButton = AddGameForm.querySelector('button[type="submit"]');

    if (AddGameForm) {
      fv = FormValidation.formValidation(AddGameForm, {
        fields: {
          name: {
            validators: {
              notEmpty: {
                message: 'Please enter a game name.'
              },
              stringLength: {
                max: 100,
                message: 'The name must be less than 100 characters.',
              },
            }
          },
          description: {
            validators: {
              notEmpty: {
                message: 'Please enter a description.'
              }
            }
          },
          html: {
            validators: {
              notEmpty: {
                message: 'Please enter HTML content for the game.'
              }
            }
          },
          css: {
            validators: {
              notEmpty: {
                message: 'Please enter CSS content for the game.'
              }
            }
          },
          js: {
            validators: {
              notEmpty: {
                message: 'Please enter JS content for the game.'
              }
            }
          },
          images: {
            validators: {
              notEmpty: {
                message: 'Please upload images for the game.'
              }
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
    // Set input values
    $('#name').val(data.name);
    $('#description').val(data.description);
    $('#html').val(data.html_code);
    $('#css').val(data.css_code);
    $('#js').val(data.js_code);

    // Set form for editing
    $('#offcanvasAddGameLabel').html('Edit Game');
    $('.submit').html('Update');
    $("#AddGameForm").attr('action', updateUrl);
    $("#AddGameForm").append('<input type="hidden" name="_method" value="PUT">');

    if (fv) {
      fv.resetForm();
    }
  });
});

$(document).on('click', '.add-new', function () {
  var storeUrl = ''; // Set your store URL here
  $('.submit').html('Submit');
  $("#AddGameForm").attr('action', storeUrl);
  $("#AddGameForm").append('<input type="hidden" name="_method" value="POST">');
  resetForm();
});

function resetForm() {
  $('#offcanvasAddGameLabel').html('Add Game');
  $('#AddGameForm')[0].reset();
  $(".text-danger").addClass("d-none");
  if (fv) {
    fv.resetForm();
  }
}

$('#AddGameForm').on('hidden.bs.offcanvas', function () {
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
      title: "Are you sure you want to delete this game?",
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
              $('.datatables-game').DataTable().ajax.reload();
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
