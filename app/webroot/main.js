
//var prefix = "/AlyssumAdmin";
var prefix = "/admin";

$(document).ready(function () {

    /** literature block **/
    $("#literature-paper").autocomplete({
        source: prefix + "/literatures/search.json",
        minLength: 3,
        type: 'json',
        select: function (event, ui) {
            $("#literature-paper").val(ui.item.label);
            $("#literature-id").val(ui.item.value);
            return false;
        }
    }).autocomplete("instance")._renderMenu = function (ul, items) {
        var that = this;
        $.each(items, function (index, item) {
            that._renderItemData(ul, item);
        });
        $(ul).find("li:odd").addClass("odd");
    };
    disablePublication('1'); //default
    $("#LiteratureDisplayType").change(function (e) {
        disablePublication($(this).val());
    });
    $("#submit-literature").click(function () {
        var $aj = sendAjax($("#LiteratureInsertForm").attr('action') + '.json', $("#LiteratureInsertForm").serialize());
        $aj.done(function (html) {
            $("#literature-paper").val(html.label);
            $("#literature-id").val(html.value);
            $("#modal-literature").modal('hide');
            clear($("#LiteratureInsertForm"));
            return false;
        }).fail(function (m) {
            console.log('FAILED: Ajax , Submit literature: ' + m);
        });
    });
    $("#literature-paper").change(function () {
        if (isEmpty($(this))) {
            $("#literature-id").val("");
        }
    });
    //---------------//

    /** List of species and identification block **/
    $("#identification-name").autocomplete({
        source: prefix + "/listofspecies/search.json",
        minLength: 2,
        type: 'json',
        select: function (event, ui) {
            $("#identification-name").val(ui.item.label);
            $("#identification-name-id").val(ui.item.value);
            return false;
        }
    }).autocomplete("instance")._renderMenu = function (ul, items) {
        var that = this;
        $.each(items, function (index, item) {
            that._renderItemData(ul, item);
        });
        $(ul).find("li:odd").addClass("odd");
    };
    $("#submit-identification").click(function () {
        var $aj = sendAjax($("#ListOfSpeciesInsertForm").attr('action') + '.json', $("#ListOfSpeciesInsertForm").serialize());
        $aj.done(function (html) {
            $("#identification-name").val(html.label);
            $("#identification-name-id").val(html.value);
            $("#modal-identification").modal('hide');
            clear($("#ListOfSpeciesInsertForm"));
            return false;
        }).fail(function (m) {
            console.log('FAILED: Ajax , Submit identification: ' + m);
        });
    });
    $("#name-as-published-copy").click(function () {
        $("#identification-name-as-published").val($("#identification-name").val());
    });
    $("#identification-hybrid").hide();
    $("#identification-is-hybrid").change(function () {
        if ($(this).is(":checked")) {
            $("#identification-hybrid").show("fast");
        } else {
            $("#identification-hybrid").hide("fast");
        }
    });
    $("#identification-name").change(function () {
        if (isEmpty($(this))) {
            $("#identification-name-id").val("");
        }
    });
    //---------------//

    /** Persons block **/

    $("button.person-btn").click(function () {
//initialize hidden input in persons form so we know whick of many persons button has been pressed
        var id = $(this).attr("id");
        $("#modal-person-ref-btn").val(id.substring(0, id.length - 4));
    });
    $("#counted-by-name").autocomplete({
        source: prefix + "/persons/search.json",
        select: function (event, ui) {
            $("#counted-by-name").val(ui.item.label);
            $("#counted-by-id").val(ui.item.value);
            console.log(ui);
            return false;
        }
    }).autocomplete("instance")._renderMenu = function (ul, items) {
        var that = this;
        $.each(items, function (index, item) {
            that._renderItemData(ul, item);
        });
        $(ul).find("li:odd").addClass("odd");
    };
    $("#collected-by-name").autocomplete({
        source: prefix + "/persons/search.json",
        minLength: 1,
        select: function (event, ui) {
            $("#collected-by-name").val(ui.item.label);
            $("#collected-by-id").val(ui.item.value);
            return false;
        }
    }).autocomplete("instance")._renderMenu = function (ul, items) {
        var that = this;
        $.each(items, function (index, item) {
            that._renderItemData(ul, item);
        });
        $(ul).find("li:odd").addClass("odd");
    };
    $("#identified-by-name").autocomplete({
        source: prefix + "/persons/search.json",
        minLength: 1,
        select: function (event, ui) {
            $("#identified-by-name").val(ui.item.label);
            $("#identified-by-id").val(ui.item.value);
            return false;
        }
    }).autocomplete("instance")._renderMenu = function (ul, items) {
        var that = this;
        $.each(items, function (index, item) {
            that._renderItemData(ul, item);
        });
        $(ul).find("li:odd").addClass("odd");
    };
    $("#checked-by-name").autocomplete({
        source: prefix + "/persons/search.json",
        minLength: 1,
        select: function (event, ui) {
            $("#checked-by-name").val(ui.item.label);
            $("#checked-by-id").val(ui.item.value);
            return false;
        }
    }).autocomplete("instance")._renderMenu = function (ul, items) {
        var that = this;
        $.each(items, function (index, item) {
            that._renderItemData(ul, item);
        });
        $(ul).find("li:odd").addClass("odd");
    };
    $("#submit-person").click(function () {
        var $aj = sendAjax($("#PersonInsertForm").attr('action') + '.json', $("#PersonInsertForm").serialize());
        $aj.done(function (html) {
            $("#" + html.ref + "-name").val(html.label);
            $("#" + html.ref + "-id").val(html.value);
            $("#modal-person").modal('hide');
            return false;
        }).fail(function (m) {
            console.log('FAILED: Ajax , Submit person: ' + m);
        });
    });
    //---------------//

    /** World 4 block **/
    $("#world4-name").autocomplete({
        source: prefix + "/worlds/search.json",
        minLength: 3,
        select: function (event, ui) {
            $("#world4-id").val(ui.item.value);
            $("#world4-name").val(ui.item.label);
            return false;
        }
    }).autocomplete("instance")._renderMenu = function (ul, items) {
        var that = this;
        $.each(items, function (index, item) {
            that._renderItemData(ul, item);
        });
        $(ul).find("li:odd").addClass("odd");
    };
    $("#world4").autocomplete("instance")._renderItem = function (ul, item) {
        return $("<li>")
                .append('<a>' + item.label + ', <small>' + item.desc + '</small></a>')
                .appendTo(ul);
    };
    //---------------//


    $('#editform').submit(function (e) {
        e.preventDefault();
        var id = $(this).find('#id').val();
        if (id !== '') {
            window.location.href = prefix + '/data/edit/' + id;
        }
    });
    
    
});
