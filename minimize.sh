#!/bin/bash
# Requires yUglify (https://github.com/yui/yuglify)

yuglify app/webroot/css/bootstrap.min.css app/webroot/css/font-awesome.min.css app/webroot/css/nv.d3.css app/webroot/css/datepicker.css app/webroot/css/style.css -c app/webroot/css/partisk

yuglify app/webroot/js/jquery.js app/webroot/js/bootstrap.js app/webroot/js/bootstrap-datepicker.js app/webroot/js/bootstrap-datepicker.sv.js app/webroot/js/d3.v2.js app/webroot/js/nv.d3.js app/webroot/js/partisk.js -c app/webroot/js/partisk
