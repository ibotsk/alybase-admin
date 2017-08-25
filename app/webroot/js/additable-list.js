(function ($) {

    $.fn.additableList = function (options) {

        var settings = $.extend({
            delBtn: '.delete', //selector for delete button
            inputs: [{type: 'text', name: 'data[]', source: null, hidden: 'hidden[]'}] //at least one default text input; if hiddenValue is false, no hidden input is generated

        }, options);

        return this.each(function () {

            var $sourceEl = $(this);
            var id = $sourceEl.attr("id");
            var child = 'tr';
            var currentCount = $sourceEl.find(child).length;
            var colspan = $sourceEl.find(child).first().find('td').length; //cell count, including cells for buttons

            $sourceEl.find(settings.delBtn).addClass("adtbl-btn-delete-strong"); //add custom class to delete button

            $sourceEl.wrap('<div id="adtbl-wrapper-' + id + '"></div>');

            //create add row button
            var $addBtn = $('<button id="adtbl-btn-add-' + id + '" type="button" class="btn btn-success adtbl-btn-add pull-right"><span class="glyphicon glyphicon-plus"></span> Add</button>');
            var $tdAddBtn = $('<td colspan="' + colspan + '">').append($addBtn);
            $('<tr>').append($tdAddBtn).appendTo($sourceEl);

            //replace $i with indexes
            var makeName = function (name, i) {
                if (!name) {
                    return 'data[]';
                }
                return name.replace(/\$[a-z]/i, i);
            };

            var makeOptions = function ($select, source) {
                $select.append($('<option value></option>'));
                if (source) {
                    $.each(source, function (key, value) {
                        $select.append('<option value="' + key + '">' + value + '</option>');
                    });
                }
                return;
            };

            var makeInput = function (item, i) {
                var type = item.type ? item.type : 'text';
                var name = item.name ? makeName(item.name, i) : 'data[]';
                var hiddenName = item.hidden ? makeName(item.hidden, i) : 'hidden[]';

                var $input = null;
                switch (type) {
                    case 'text':
                        $input = $('<input>').attr('type', type);
                        break;
                    case 'select':
                        $input = $('<select>');
                        makeOptions($input, item.source);
                        break;
                    default:
                        $input = $('<input>').attr('type', type);
                        break;
                }
                $input.attr('name', name).addClass('form-control');

                var hidden = $('<input type="hidden" class="form-control"></input>').attr('name', hiddenName); //default

                return $input;
            };

            var pressAdd = function () {
                //clone first row
                var $tr = $sourceEl.find('tr').first().clone();
                $tr.children('td').empty(); //empty cloned conents
                var $weakDelBtn = $('<button type="button" class="btn btn-warning adtbl-btn-delete-weak"><span class="glyphicon glyphicon-remove"></span></button>');
                $tr.children('td:last-child').append($weakDelBtn); //append weak delete button
                //
                //insert input fields - if no inputs specified in options, use text inputs
                if (settings.inputs && Array.isArray(settings.inputs)) {
                    $.each(settings.inputs, function (index, value) {
                        if (index >= colspan - 1) { //if there are in accident more inputs specified than is count of cells minus button cell
                            return; //exit loop
                        }
                        var $input = makeInput(value, currentCount + index);
                        var nthchild = index + 1;
                        $tr.children('td:nth-child(' + nthchild + ')').append($input);
                    });
                }
                $tr.insertBefore($sourceEl.find('tr').last());
                currentCount++;
            };

            //register callbacks
            $sourceEl.on('click', '.adtbl-btn-delete-strong', function () {
                return confirm("You are about to remove this item. This operation will be performed immediately and is permament. Do you want to continue?");
            });

            $sourceEl.on('click', 'button.adtbl-btn-add', function () {
                pressAdd();
            });

            $sourceEl.on('click', '.adtbl-btn-delete-weak', function () {
                $(this).parents('tr').remove();
            });
        });

    };

}(jQuery));