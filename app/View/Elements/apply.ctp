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
 */
 ?>

    <?php echo $this->Bootstrap->create('User', 
            array('modal' => true, 'label' => "Ansök om konto", 'icon' => 'fa fa-plus', 'class' => "btn btn-info" )); ?>
    
	<?php echo $this->Bootstrap->input('username', 
                array('label' => 'Användarnamn' , 'placeholder' => 'Användarnamn')); ?>
	<?php echo $this->Bootstrap->input('email', 
                array('label' => 'E-postadress', 'placeholder' => 'E-postadress')); ?>   
	<?php echo $this->Bootstrap->input('password', 
                array('label' => 'Lösenord', 'type' => 'password', 'placeholder' => 'Lösenord')); ?>
	<?php echo $this->Bootstrap->input('confirmPassword', 
                array('label' => 'Bekräfta Lösenord', 'type' => 'password', 'placeholder' => 'Bekräfta Lösenord')); ?>
	<?php echo $this->Bootstrap->textarea('description', 
                array('label' => 'Motivering', 'placeholder' => 'Här kan du skriva en kort presentation av dig själv och om hur du kan bidra till partisk.nu.')); ?>


    <?php echo $this->Bootstrap->end($editMode = "Skicka", array('modal' => true)); ?>
