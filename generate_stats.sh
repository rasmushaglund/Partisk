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

cat /var/log/nginx/www.partisk.nu.access.log|grep -v "apc"|awk -F\  '{print $1," ",$7}'| grep "fr%C3%A5gor/"|grep -v "getCategoryTable"|grep -v "search"|uniq -c|sort -bgr|awk -F\/ '{print $3}'

sudo cat /var/log/nginx/www.partisk.nu.access.log|grep -v "apc"|awk -F\  '{print $1," ",$7}'| grep "fr%C3%A5gor/"|grep -v "getCategoryTable"|grep -v "search"|uniq|awk -F\  '{print tolower($2)}'|sort|uniq -c|sort -nr|awk -F\/ '{print $3}'
