(function () {
  let cardColor, labelColor, shadeColor, legendColor, borderColor;
  if (isDarkStyle) {
    cardColor = config.colors_dark.cardColor;
    labelColor = config.colors_dark.textMuted;
    legendColor = config.colors_dark.bodyColor;
    borderColor = config.colors_dark.borderColor;
    shadeColor = 'dark';
  } else {
    cardColor = config.colors.cardColor;
    labelColor = config.colors.textMuted;
    legendColor = config.colors.bodyColor;
    borderColor = config.colors.borderColor;
    shadeColor = '';
  }

  getDashboardData();

  function getDashboardData() {
      $.ajax({
          type: 'get',
          url: '/admin/get-admin-count-data',
          success: function (data) {
              // Update the counts dynamically
              $('#games-count').text(data.games);        // For games count
              $('#likes-count').text(data.likes);        // For total likes count
              $('#reviews-count').text(data.reviews);    // For total reviews count
          },
          error: function (error) {
              console.error('Error fetching dashboard data:', error);
          }
      });
  }


})();
