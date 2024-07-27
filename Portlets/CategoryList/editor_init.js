$(document).on("change", '[name="cb-category-source"]', function () {
  if ($(this).val() === "explicit") {
    $("#cb-category-filter-section").hide();
  } else {
    $("#cb-category-filter-section").show();
  }
});

$(document).on("click", ".nav-item a", function () {
  setTimeout(function () {
    if ($("#conftab1").is(":visible")) {
      $("#cb-category-filter-section").hide();
    }

    if ($("#conftab0").is(":visible")) {
      if ($('[name="cb-category-source"]').val() === "explicit") {
        $("#cb-category-filter-section").hide();
      } else {
        $("#cb-category-filter-section").show();
      }
    }
  }, 500);
});
