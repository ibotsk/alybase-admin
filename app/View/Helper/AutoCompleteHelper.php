<?php

App::uses('AppHelper', 'View/Helper');

class AutoCompleteHelper extends AppHelper {

    public $helpers = array(
        'Form',
        'Html'
    );
    public $js = '';
    public $options = array(
        'minLength' => 1, // autocomplete minLength
        'delay' => 300, // autocomplete delay
        'select' => array(), // additional behaviour to default
        'selectOw' => false, // by default, functions are added to the default behaviour, otherwise the defaults are replaced
        'btnLabel' => 'Add new',
        'btnId' => null,
        'btnClass' => 'btn btn-info',
        'tooltip' => false, // if false, no tooltip on button. otherwise given text as tooltip
        'placeholder' => '',
        'idText' => '',
        'idHidden' => '',
        'textvalue' => null,
        'hiddenvalue' => null,
        'modalId' => null,
        'inputclass' => 'form-control'
    );

    /**
     * Creates a html markup consisting of input group - autocomplete input and button,
     * and hidden input to store the autocomplete custom value.
     * 
     * @param unknown $path        	
     * @param unknown $source        	
     * @param array $options        	
     * @throws InvalidArgumentException
     * @return string
     */
    public function input($path, $source, $options = array()) {
        if (empty($path) || !strpos($path, '.')) {
            throw new InvalidArgumentException("AutoCompleteHelper: invalid path");
        }
        if (empty($source)) {
            throw new InvalidArgumentException("AutoCompleteHelper: invalid source");
        }

        if (!is_array($options)) {
            $options = array(
                'placeholder' => $options
            );
        }
        $options = array_merge($this->options, (array) $options);

        // extract models and field
        $tokens = explode('.', strrev($path), 2);
        $field = strrev($tokens[0]); // field
        $model = strrev($tokens[1]); // Model1.Model2.Model3

        extract($options);

        $input_text_path = "$model.name";
        $field_to_id = strtolower(str_replace('_', '-', $field));
        if (empty($idText)) {
            $idText = $field_to_id . '-name';
        }
        if (empty($idHidden)) {
            $idHidden = $field_to_id . '-id';
        }
        if (empty($idBtn)) {
            $btnId = $field_to_id . '-btn';
        }

        $autocompleteInput = $this->Form->input($input_text_path, array(
            'type' => 'text',
            'id' => $idText,
            'class' => $inputclass,
            'value' => $textvalue,
            'placeholder' => $placeholder,
            'style' => 'padding-right: 24px'
        ));
        $hiddenInput = $this->Form->input($path, array(
            'type' => 'hidden',
            'id' => $idHidden,
            'value' => $hiddenvalue
        ));

        $m = '';
        $t = '';
        if ($modalId) {
            $m = ' data-toggle="modal" data-target="#' . $modalId . '"';
        }
        if ($tooltip) {
            $t = ' data-toggle="tooltip" title="' . $tooltip . '"';
        }

        $clear = '<div class="input-group-btn"><div class="btn btn-default autocomplete-clear-x" data-toggle="tooltip" title="Clear field" style="border-radius:0;margin-left:-1px;"><span class="glyphicon glyphicon-remove-sign" style="opacity:0.6;"></span></div></div>';
        $btn = $clear . '<div class="input-group-btn"' . $m . '><button type="button" id="' . $btnId . '" class="' . $btnClass . '"' . $t . '>' . $btnLabel . '</button></div>';


        $result = '<div class="input-group">' . $autocompleteInput . $btn . '</div>' . $hiddenInput;

        $this->js .= $this->_makeJs($source, $idText, $idHidden, $options);
        return $result;
    }

    public function afterRender($viewFile = null) {
        $content = parent::afterRender($viewFile);

        $clear = '$(".autocomplete-clear-x").click(function () { $(this).parents(".input-group").children("input").val("").change(); });';
        if (!empty($this->js)) {
            // $content .= $this->Html->css( $this->pathToCss, null, array('inline' => false) );
            // $content .= $this->Html->script($this->pathToJs, array('inline' => false));
            // $content .= $this->Html->script( $this->pathToJs, array('inline' => false) );
            $content .= $this->Html->scriptBlock('$(document).ready(function() { ' . $this->js . $clear . '});', array(
                'inline' => false
            ));
        }
        return $content;
    }

    protected function _makeJs($source, $idText, $idHidden, $options = array()) {
        if (empty($source)) {
            throw new InvalidArgumentException('AutoCompleteHelper::_makeJs - invalid source');
        }
        if (empty($idText)) {
            throw new InvalidArgumentException('AutoCompleteHelper::_makeJs - invalid id text');
        }
        if (empty($idHidden)) {
            throw new InvalidArgumentException('AutoCompleteHelper::_makeJs - invalid id hidden');
        }

        $options['source'] = $source;

        $selectDefault = '$("#' . $idText . '").val(ui.item.label);' . '$("#' . $idHidden . '").val(ui.item.value);';

        if (!is_array($options['select'])) {
            $select = $options['select'];
        } else {
            $select = implode('', $options['select']);
        }

        if (!empty($select)) { // given select behaviour in options
            if (!$options['selectOw']) { // behaviour will be appended to default and enclosed to function
                $select = 'function (event, ui) {' . $selectDefault . $select . ' return false; }';
            } // else the overwrite is true and the select behaviour is already assigned
        } else { // otherwise default behviour
            $select = 'function (event, ui) {' . $selectDefault . ' return false; }';
        }

        $options['select'] = $select; // set final select

        $jsOptions = array(
            'source' => null,
            'minLength' => null,
            'delay' => null,
            'select' => null
        );
        $jsOptions = array_intersect_key($options, $jsOptions);

        foreach (array_keys($jsOptions) as $k) {
            if ($jsOptions[$k] === null) {
                unset($jsOptions[$k]);
            }
        }

        $acOptions = $this->_fixJson($jsOptions);

        $js = '$("#' . $idText . '").autocomplete(' . $acOptions . ').autocomplete("instance")._renderMenu = function (ul, items) {' . 'var that = this;' . '$.each(items, function (index, item) {' . 'that._renderItemData(ul, item);' . '});' . '$(ul).find("li:odd").addClass("odd");' . '};' . '$("#' . $idText . '").change(function () {' . 'if ($(this).val().length === 0) {' . '$("#' . $idHidden . '").val(""); }});';

        return $js;
    }

    /**
     * Gets rid of quotation marks around encoded javascript functions.
     * Gets rid of quotation marks around keys.
     * Gets rid of escaped forward slashes.
     * 
     * @param array $source        	
     * @return mixed
     */
    protected function _fixJson($source = array()) {
        $value_arr_functions = array();
        $replace_keys_functions = array();
        $key_arr_quotations = array();
        $replace_keys_quotations = array();

        foreach ($source as $key => &$value) {
            // Look for values starting with 'function('
            if (strpos($value, 'function (') === 0) {
                // Store function string.
                $value_arr_functions[] = $value;
                // Replace function string in $foo with a ‘unique’ special key.
                $value = '%' . $key . '%';
                // Later on, we’ll look for the value, and replace it.
                $replace_keys_functions[] = '"' . $value . '"';
            }

            // store key string replacement for all keys
            $key_arr_quotations[] = $key;
            // store key string to be replaced
            $replace_keys_quotations[] = '"' . $key . '"';
        }

        $json = json_encode($source);
        $json = str_replace($replace_keys_functions, $value_arr_functions, $json);
        $json = str_replace($replace_keys_quotations, $key_arr_quotations, $json);
        $json = str_replace('\/', '/', $json);
        return $json;
    }

}
