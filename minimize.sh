#!/bin/bash
#
# Copyright 2013-2014 Partisk.nu Team
# https://www.partisk.nu/
# 
# Permission is hereby granted, free of charge, to any person obtaining
# a copy of this software and associated documentation files (the
# "Software"), to deal in the Software without restriction, including
# without limitation the rights to use, copy, modify, merge, publish,
# distribute, sublicense, and/or sell copies of the Software, and to
# permit persons to whom the Software is furnished to do so, subject to
# the following conditions:
# 
# The above copyright notice and this permission notice shall be
# included in all copies or substantial portions of the Software.
# 
# THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
# EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
# MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
# NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
# LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
# OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
# WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

# Requires yUglify (https://github.com/yui/yuglify)

yuglify app/webroot/css/bootstrap.min.css app/webroot/css/font-awesome.min.css app/webroot/css/nv.d3.css app/webroot/css/datepicker.css app/webroot/css/typeahead.js-bootstrap.css app/webroot/css/style.css -c app/webroot/css/partisk

yuglify app/webroot/js/jquery.js app/webroot/js/bootstrap.js app/webroot/js/bootstrap-datepicker.js app/webroot/js/typeahead.js app/webroot/js/bootstrap-datepicker.sv.js app/webroot/js/matchMedia.js app/webroot/js/partisk.js -c app/webroot/js/partisk

yuglify app/webroot/js/d3.v2.js app/webroot/js/nv.d3.js -c app/webroot/js/graph
