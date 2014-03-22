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
 * @package     app.View.Pages
 * @license     http://opensource.org/licenses/MIT MIT
 */
 ?>

<div class="row">
    <div class="col-md-6">
<h1>Kontakt</h1>
<?php echo $this->element("share", array(
    "text" => "Kontakt info@partisk.nu eller ge feedback direkt på sidan"
)); ?>
<p>Vid frågor om sidans innehåll eller andra ärenden som har med tjänsten att göra maila <a href="mailto:info@partisk.nu">info@partisk.nu</a> eller 
    <a data-toggle="modal" href="#feedbacksModal">ge oss feedback</a>.</p>
<p>För relationer med media kan ni kontakta <a href="mailto:rasmus.haglund@partisk.nu">rasmus.haglund@partisk.nu</a>.</p>
    </div>
</div>