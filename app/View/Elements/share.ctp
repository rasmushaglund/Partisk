<?php 
/**
 * Copyright 2013-2014 Partisk.nu Team
 * https://www.partisk.nu/
 * 
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 * 
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 * 
 * @copyright   Copyright 2013-2014 Partisk.nu Team
 * @link        https://www.partisk.nu
 * @package     app.View.Elements
 * @license     http://opensource.org/licenses/MIT MIT
 */ ?>

<?php $url = Router::url(null, true ); ?>
<div class="share">
    <a href="http://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($url); ?>" title="Facebook"><i class="fa fa-facebook-square"></i></a>
    <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($url); ?>&text=<?php echo $title_for_layout; ?>&via=partisknu" title="Twitter"><i class="fa fa-twitter-square"></i></a>
    <a href="https://plus.google.com/share?url=<?php echo urlencode($url); ?>" title="Google+"><i class="fa fa-google-plus-square"></i></a>
    <a href="http://www.linkedin.com/shareArticle?url=<?php echo urlencode($url); ?>&t=<?php echo $title_for_layout; ?>" title="LinkedIn"><i class="fa fa-linkedin-square"></i></a>
</div>