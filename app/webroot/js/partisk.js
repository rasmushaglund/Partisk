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
    $('.modal').on('shown.bs.modal', function() {
        $(this).find("input:visible").first().focus();
    });
    $('.datepicker').datepicker(datepickerArgs);

    if ($('.qa-table').size() > 0) {
        qaTableFixedHeader();
    }

    $('#partisk-search input').typeahead([
        {
            name: 'questions',
            remote: appRoot + 'api/search/%QUERY',
            minLength: 3
        }
    ]).bind('typeahead:selected', function(event, obj) {
        if (obj.key) {
            window.location = appRoot + "frågor/" + obj.value.split(' ').join('_');
        }

        $(this).val("");
    }).focus();
       
    $('#accordion .panel-collapse').on('show.bs.collapse', function () {
       $(this).parent().find(".toggle").removeClass("fa-plus-square").addClass("fa-minus-square");
    });

    $('#accordion .panel-collapse').on('hide.bs.collapse', function () {
        console.log(this);
       $(this).parent().find(".toggle").removeClass("fa-minus-square").addClass("fa-plus-square");
    });
});

var qaTableFixedHeader = function() {
    var table = $('.table-with-fixed-header');
    var qaTableHead = $('<div class="table-head-container"></div>');
    var qaTableHeadRow = $('<div class="table qa-table table-bordered table-striped"></div>');
    var qaTableHeadBg = $('<div class="table-header-bg"></div>');

    qaTableHead.append(qaTableHeadBg);
    qaTableHead.append(qaTableHeadRow);

    table.before(qaTableHead);
    $('.table-with-fixed-header .table-head.table-row').appendTo(qaTableHeadRow);
    var headerHeight = qaTableHeadRow.find('.table-row.table-head').height();

    qaTableHeadRow.width(table.width());

    var headerVisible = false;
    $(window).scroll(function() {
        if ($(window).scrollTop() >= table.offset().top - headerHeight) {
            if (!headerVisible) {
                headerVisible = true;
                qaTableHead.addClass('table-fixed');
                table.addClass('table-fixed-header');

            }
        } else {
            if (headerVisible) {
                headerVisible = false;

                qaTableHead.removeClass('table-fixed');
                table.removeClass('table-fixed-header');
            }
        }
    });
};

var openModal = function(controller, action, id) {
    $.ajax({
        url: appRoot + controller + '/' + action + '/' + id,
        success: function(data) {
            $modal = $(data);
            $("body").append($modal);
            $modal.modal();
            $modal.find('.datepicker').datepicker(datepickerArgs);

            $modal.on('hidden.bs.modal', function() {
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

    $('.popover-hover-link').popover({
        html: true,
        placement: "auto",
        trigger: 'hover',
        content: function() {
            return $(this).next('.popover-data').html();
        }
    });

    $('.popover-link').bind('click', function() {
        var $popover = $(this);
        $.ajax({url: appRoot + "answers/info/" + $popover.attr('data-id'), success: function(data) {
                $popover.unbind('click');
                $popover.popover({
                    html: true,
                    placement: "auto",
                    content: function() {
                        return data;
                    }
                }).popover('show');
            }});
    });

    $('body').on('click', function(e) {
        $('.popover.in').prev().not(e.target).popover('toggle');
    });

    // Open modal without fade if it contains an error
    $('.modal').each(function(index, modal) {
        if ($(modal).find('p.error').size() > 0) {
            $(modal).removeClass('fade');
            $(modal).on('shown.bs.modal', function() {
                $(this).addClass('fade in');
                $('.modal-backdrop').addClass('fade in');
            });
            $(modal).modal('show');

        }
    });
});

function getQuestionAgreeRate() {
    var result = {key: 'questionAgreeRate', values: []};

    var agree_rate = data["question_agree_rate"];

    for (var value in agree_rate) {
        result.values.push({value: agree_rate[value]['result'], range: agree_rate[value]['range'], plus_points: agree_rate[value]['plus_points'],
            label: capitalizeFirstLetter(parties[value].name), minus_points: agree_rate[value]['minus_points'],
            party_id: parties[value].id,
            color: parties[value].color, order: parties[value].order});
    }

    result.values.sort(function(a, b) {
        return a.order - b.order;
    });
    return [result];
}

function getPointsPercentage() {
    var result = {key: 'pointsPercentage', values: []};

    var points_percentage = data['points_percentage'];

    for (var value in points_percentage) {
        if (points_percentage[value]['result'] > 0) {
            result.values.push({value: points_percentage[value]['result'], range: points_percentage[value]['range'],
                points: points_percentage[value]['points'], label: capitalizeFirstLetter(parties[value].name),
                party_id: parties[value].id,
                color: parties[value].color, order: parties[value].order});
        }
    }

    result.values.sort(function(a, b) {
        return a.order - b.order;
    });
    return [result];
}

nv.addGraph(function() {
    var data = getPointsPercentage();
    var chart = nv.models.pieChart()
            .x(function (d) {
                return d.label;
            })
            .y(function (d) {
                return d.value;
            })
            .tooltips(true)
            .margin({left: 1, top: 0, bottom: 0, right: 0})
            .color(function (item) {
                if (item.data && item.data.color)
                    return item.data.color;
                return "#333";
            })
            .labelThreshold(.06)
            .tooltipContent(function (key, value, item, graph) {
                var result = '<h3>' + key + '</h3>' + '<p>' + Math.round(value) + '%</p>';
                result += '<p>' + item.point.points + 'p' + '</p>';
                return result;
            })
            .showLabels(true);

    d3.select("#points-percentage-graph svg")
            .datum(getPointsPercentage())
            .transition().duration(500)
            .call(chart);

    var bars = d3.select('#points-percentage-graph svg').selectAll('g.nv-label');
    
    bars.append("foreignObject")
      .attr("width", 25)
      .attr("height", 25)
      .attr("y", function (d, i) { return -12; })
      .attr("x", function (d, i) { return -12; })
      .append("xhtml:body")
      .attr("style", "background-color: transparent")
      .attr("text-anchor", "middle")
      .html(function (d, i) { 
          console.log(data[0].values[i]);
          return data[0].values[i].points > 0 ? "<div class='party-logo-small party-logo-small-" + data[0].values[i].party_id + "'></div>" : null; 
      });
      
    nv.utils.windowResize(chart.update);

    return chart;
});

nv.addGraph(function() {
    var data = getQuestionAgreeRate();
    var chart = nv.models.discreteBarChart()
            .x(function (d) {
                return d.label;
            })
            .y(function (d) {
                return d.value;
            })
            .margin({left: 40, top: 0, bottom: 40, right: 0})
            .staggerLabels(false)
            .tooltips(true)
            .tooltipContent(function (id, key, value, item) {
                var result = '<h3>' + key + '</h3>' + '<p>' + Math.round(value) + '%</p>';
                result += '<p>För: ' + item.point.plus_points + 'p</p>';
                result += '<p>Emot: ' + item.point.minus_points + 'p</p>';
                return result;
            })
            .valueFormat(function (value) {
                return Math.round(value) + "%";
            })
            .showValues(true);

    d3.select('#question-agree-rate-graph svg')
            .datum(data)
            .transition().duration(500)
            .call(chart);

    nv.utils.windowResize(chart.update);
    
    var bars = d3.select('#question-agree-rate-graph svg').selectAll('g.nv-x.nv-axis g.nv-wrap.nv-axis > g > g');
    
    bars.append("foreignObject")
      .attr("width", 25)
      .attr("height", 25)
      .attr("y", function (d, i) { return 5; })
      .attr("x", function (d, i) { return -25/2; })
      .append("xhtml:body")
      .attr("style", "background-color: transparent")
      .attr("text-anchor", "middle")
      .html(function (d, i) { 
          return "<div class='party-logo-small party-logo-small-" + data[0].values[i].party_id + "'></div>" 
      });

    return chart;
});