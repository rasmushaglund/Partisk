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
 * @package     app.View.Users
 * @license     http://opensource.org/licenses/MIT MIT
 */

$this->Html->addCrumb('Logga in');

?>
<div class="row">
    <div class="col-md-6">
        <h2>Logga in</h2>
        <p>Här kan du logga in för att lägga till frågor och svar till tjänsten. </p>
<form action="<?php Router::url(array('controller' => 'users', 'action' => 'login')); ?>" class="alert alert-info form-box" id="UserLoginForm" method="post" accept-charset="utf-8" role="form">
     <div style="display:none;">
     <input type="hidden" name="_method" value="POST"></div>
     <div class="form-group">
     <label for="UserUsername">Användarnamn</label>
     <input name="data[User][username]" maxlength="50" type="text" id="UserUsername" required="required" class="form-control"></div>
     <div class="form-group">
     <label for="UserPassword">Lösenord</label>
     <input name="data[User][password]" type="password" id="UserPassword" required="required" class="form-control"></div>    
     <input type="submit" value="Logga in" class="btn btn-default">
</form>
    </div>
    <div class="col-md-6">
        <h2>Ansök om konto</h2> 
<p>Om du inte har ett konto kan du ansöka om att få tillgång till administrationsdelen
    av sidan. Tänk på att motivera varför just du vill hjälpa till med sidan och vad du kan bidra med.</p>
<?php  echo $this->element('apply'); ?>
    </div>