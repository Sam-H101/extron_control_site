﻿$(document).ready( function () {
    $('#example').DataTable();

} );


$(function(){
    $('.dropdown').hover(function() {
        $(this).addClass('open');
    },
    function() {
        $(this).removeClass('open');
    });
});