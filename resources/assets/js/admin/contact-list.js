/**
 * Page Contact List
 */

'use strict';

// Datatable (jquery)
$(function () {
  // Variable declaration for table
  var dt_contact_table = $('.datatables-contact');

  // Contacts datatable
  if (dt_contact_table.length) {
    var dt_contact = dt_contact_table.DataTable({
      ajax: dt_contact_table.attr('data-url'),
      processing: true,
      serverSide: true,
      columns: [
        { data: 'id' },
        { data: 'full_name' },
        { data: 'email' },
        { data: 'subject' },
        { data: 'message_preview' },
        { data: 'created_at' },
        { data: 'action', name: 'action' },
      ],
      order: [[0, 'desc']],
      lengthMenu: [7, 10, 25, 50, 75, 100],
      language: { paginate: { next: '<i class="ti ti-chevron-right ti-sm"></i>', previous: '<i class="ti ti-chevron-left ti-sm"></i>' } }
    });
  }
}); 