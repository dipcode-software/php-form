<?php

return array(
    "LABEL" => '<label for="{for}"[ {attrs}?]>{contents}[ {required}?]</label>',
    "LABEL_REQUIRED" => '<span class="required">*</span>',

    // ErrorList
    "ERRORLIST" => '<ul class="errorlist">{items}</ul>',
    "ERRORLIST_ITEM" => '<li>{content}</li>',

    // Widgets
    "TEXTAREA" => '<textarea name="{name}" [{attrs}?]>[{value}?]</textarea>',
    "INPUT" => '<input type="{type}" name="{name}" [{attrs}?] [value="{value}?"]/>',

    "SELECT" => '<select name="{name}"[ {attrs}?]>{options}</select>',
    "SELECT_ITEM" => '<option value="{value}"[ {attrs}?]>{label}</option>',

    "CHECKBOX_SELECT_MULTIPLE" => '<div>{options}</div>',
    "CHECKBOX_SELECT_MULTIPLE_ITEM" => '<label for="{for}">%s {label}</label>',

    "RADIOSELECT" => '<div>{options}</div>',
    "RADIOSELECT_ITEM" => '<label for="{for}">%s {label}</label>',
);
