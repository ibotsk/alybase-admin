
function clear($form) {
    $form.find("input[type=text], textarea").val("");
}

function disablePublication(type) {
    $("#LiteratureInsertForm input").prop("disabled", false);
    switch (type) {
        case '1':
            $("#LiteratureSeriesSource").prop("disabled", true);
            $("#LiteratureEditor").prop("disabled", true);
            $("#LiteraturePublisher").prop("disabled", true);
            break;
        case '2':
            $("#LiteratureSeriesSource").prop("disabled", true);
            $("#LiteratureEditor").prop("disabled", true);
            $("#LiteratureJournal").prop("disabled", true);
            $("#LiteratureIssue").prop("disabled", true);
            $("#LiteratureVolume").prop("disabled", true);
            break;
        case '3':
            $("#LiteratureJournal").prop("disabled", true);
            $("#LiteratureVolume").prop("disabled", true);
            $("#LiteratureIssue").prop("disabled", true);
            break;
        case '4':
            $("#LiteratureJournal").prop("disabled", true);
            $("#LiteratureVolume").prop("disabled", true);
            $("#LiteratureIssue").prop("disabled", true);
            break;
        case '5':
            $("#LiteraturePublisher").prop("disabled", true);
            break;
        default:
            break;
    }
}

function isEmpty( el ){
      return !$.trim(el.html())
  }

function sendAjax(where, what) {
    var $aj = $.ajax({
        url: where,
        method: 'POST',
        data: what
    });
    return $aj;
}

