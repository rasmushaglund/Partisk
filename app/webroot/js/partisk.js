/** 
 * Main javascript file
 *
 * Partisk : Political Party Opinion Visualizer
 * Copyright (c) Partisk.nu Team (https://www.partisk.nu)
 *
 * Partisk is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Partisk is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Partisk. If not, see http://www.gnu.org/licenses/.
 *
 * @copyright   Copyright (c) Partisk.nu Team (https://www.partisk.nu)
 * @link        https://www.partisk.nu
 * @package     app.Webroot.js
 * @license     http://www.gnu.org/licenses/ GPLv2
 */

var datepickerArgs = {autoclose: true, format: 'yyyy-mm-dd', language: "sv", calendarWeeks: true, endDate: new Date()};

$(document).ready(function() {
	$('.pop').popover();
	$('.modal').on('shown.bs.modal', function(){
		$(this).find("input:visible").first().focus();
	});
	$('.datepicker').datepicker(datepickerArgs);
});

var openEditModal = function(controller, id) {
	$.ajax({
	    url: appRoot + controller + '/edit/' + id,
	    success: function(data){
			$modal = $(data);
	        $("body").append($modal);
			$modal.modal();
			$modal.find('.datepicker').datepicker(datepickerArgs);

			$modal.on('hidden.bs.modal', function(){
    			$modal.remove();
		});
	    }
	});
};

// http://stackoverflow.com/questions/1026069/capitalize-the-first-letter-of-string-in-javascript
function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

$(document).ready(function() {
	$('.popover-link').popover({ 
	    html : true,
	    placement: "auto",
	    content: function() {
	      return $(this).next('.popover-data').html();
	    }
	 });

	$('.popover-hover-link').popover({ 
	    html : true,
	    placement: "auto",
	    trigger: 'hover',
	    content: function() {
	      return $(this).next('.popover-data').html();
	    }
	 });

	$('body').on('click', function (e) {
            $('.popover.in').prev().not(e.target).popover('toggle');
	});
        
        // Open modal without fade if it contains an error
        $('.modal').each(function (index, modal) {
            if ($(modal).find('p.error').size() > 0) {
                $(modal).removeClass('fade');
                $(modal).on('shown.bs.modal', function () {
                    $(this).addClass('fade in');
                    $('.modal-backdrop').addClass('fade in');
                });
                $(modal).modal('show');
                
            }
        });
            
        
});