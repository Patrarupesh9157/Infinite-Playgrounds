/**
 * Page Review List
 */

'use strict';

// Datatable (jquery)
$(function () {
  // Variable declaration for table
  var dt_review_table = $('.datatables-review');

  // Reviews datatable
  if (dt_review_table.length) {
    var dt_review = dt_review_table.DataTable({
      ajax: dt_review_table.attr('data-url'),
      processing: true,
      serverSide: true,
      columns: [
        { data: 'id' },
        { data: 'user_name' },
        { data: 'game_name' },
        { data: 'rating_stars' },
        { data: 'comment' },
        { data: 'created_at' },
        { data: 'action', name: 'action' },
      ],
      order: [[0, 'desc']],
      lengthMenu: [7, 10, 25, 50, 75, 100],
      language: { paginate: { next: '<i class="ti ti-chevron-right ti-sm"></i>', previous: '<i class="ti ti-chevron-left ti-sm"></i>' } }
    });
  }
}); 