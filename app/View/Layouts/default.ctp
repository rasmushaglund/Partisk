<?php
/**
 * Default layout
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
 * @package     app.View.Layouts
 * @license     http://www.gnu.org/licenses/ GPLv2
 */
?>

<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>
            Partisk.nu (Testversion) - 
            <?php echo $title_for_layout; ?>
        </title>

        <script type="text/javascript">
            var appRoot = "<?php echo Router::url('/', false); ?>";
        </script>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Partisk.nu">
        <meta name="author" content="Partisk.nu">
        <link rel="shortcut icon" href="favicon.ico">

        <?php
        echo $this->Html->meta('icon');

        if (Configure::read('debug')>0) { ?>
            <style>.party-logo,.party-logo-small{background:url('<?php echo Router::url('/', false); ?>img/partisk-sprite.png') no-repeat;}</style>
        <?php
            echo $this->Html->css('bootstrap.min');
            echo $this->Html->css('typeahead.js-bootstrap');
            echo $this->Html->css('font-awesome.min');
            echo $this->Html->css('nv.d3');
            echo $this->Html->css('datepicker');
            echo $this->Html->css('style');
            echo $this->Html->script('jquery');
            echo $this->Html->script('bootstrap');
            echo $this->Html->script('bootstrap-datepicker');
            echo $this->Html->script('bootstrap-datepicker.sv.js', false);
            echo $this->Html->script('typeahead');
            echo $this->Html->script('d3.v2');
            echo $this->Html->script('nv.d3');
            echo $this->Html->script('partisk');

            echo $this->fetch('meta');
            echo $this->fetch('css');
            echo $this->fetch('script');
        } else { 
            $version = Configure::read('PartiskVersion'); 
            echo $this->fetch('meta'); ?>
            <style>.party-logo,.party-logo-small{background:url('<?php echo Router::url('/', false); ?>img/partisk-sprite-v<?php echo $version; ?>.png') no-repeat;}</style>
            
            <?php
            echo $this->Html->css("partisk-v$version.min");
            echo $this->Html->script("partisk-v$version.min");
            ?>
            
        <?php } ?>
    </head>
    <body>        
        <nav class="navbar navbar-default" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <?php echo $this->Html->link('<i class="fa fa-check-square"></i>Partisk.nu', array('controller' => 'pages', 'action' => 'index'), array('class' => 'navbar-brand', 'escape' => false));
                ?>
            </div>
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav navbar-left">
                    <li><?php echo $this->Html->link('<i class="fa fa-thumbs-o-up"></i> Så här tycker partierna', array('controller' => 'questions', 'action' => 'index'), array('escape' => false, 'class' => $currentPage == "questions" ? 'active' : '')); ?></li>
                    <li><?php echo $this->Html->link('<i class="fa fa-tags"></i> Taggar', array('controller' => 'tags', 'action' => 'index'), array('escape' => false, 'class' => $currentPage == "tags" ? 'active' : '')); ?></li>
                    <li><?php echo $this->Html->link('<i class="fa fa-globe"></i> Partier', array('controller' => 'parties', 'action' => 'index'), array('escape' => false, 'class' => $currentPage == "parties" ? 'active' : '')); ?></li>
                    <li><?php echo $this->Html->link('<i class="fa fa-check-square-o"></i> Quiz', array('controller' => 'quizzes', 'action' => 'index'), array('escape' => false, 'class' => $currentPage == "quiz" ? 'active' : '')); ?></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><?php echo $this->Html->link('<i class="fa fa-info-circle"></i> Om sidan', array('controller' => 'pages', 'action' => 'about'), array('escape' => false, 'class' => $currentPage == "about" ? 'active' : ''));
                ?></li>
                    <li><?php echo $this->Html->link('<i class="fa fa-envelope"></i> Kontakt', array('controller' => 'pages', 'action' => 'contact'), array('escape' => false, 'class' => $currentPage == "contact" ? 'active' : ''));
                ?></li>
                    <?php if (isset($current_user)) { ?>
                    <li class="dropdown">
                        <a data-toggle="dropdown" href="#"><i class="fa fa-gears"></i> Administration</a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                        <li><?php echo $this->Html->link('<i class="fa fa-info-circle"></i> Information', array('controller' => 'users', 'action' => 'start'), array('escape' => false));
                    ?></li>
                        <li><?php echo $this->Html->link('<i class="fa fa-group"></i> Användare', array('controller' => 'users', 'action' => 'index'), array('escape' => false));
                    ?></li>
                        <li><?php echo $this->Html->link('<i class="fa fa-thumbs-o-up"></i> Mina frågor', array('controller' => 'questions', 'action' => 'status'), array('escape' => false));
                    ?></li>
                        <li><?php echo $this->Html->link('<i class="fa fa-check"></i> Mina svar', array('controller' => 'answers', 'action' => 'status'), array('escape' => false));
                    ?></li>
                        <li><?php echo $this->Html->link('<i class="fa fa-check-square-o"></i> Mina quizzar', array('controller' => 'quizzes', 'action' => 'status'), array('escape' => false));
                    ?></li>
                        <?php if ($isAdmin) { ?>
                        <li><?php echo $this->Html->link('<i class="fa fa-check-square-o"></i> Quizöversikt', array('controller' => 'quizzes', 'action' => 'overview'), array('escape' => false));
                    ?></li>
                        <?php } ?>
                        <li><?php echo $this->Html->link('<i class="fa fa-sign-out"></i> Logga ut', array('controller' => 'users', 'action' => 'logout'), array('escape' => false));
                        ?></li>
                        </ul>
                    </li>
                    <?php } else { ?>
                        <li><?php echo $this->Html->link('<i class="fa fa-sign-in"></i> Logga in', array('controller' => 'users', 'action' => 'login'), array('escape' => false, 'class' => $currentPage == "login" ? 'active' : '')); ?></li>
                    <?php } ?>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div id="partisk-search">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-search"></i></span>
                            <input type="text" class="form-control" placeholder="Sök fråga"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php echo $this->Html->getCrumbList(array('class' => 'breadcrumb'), 'Hem'); ?>
                    <?php echo $this->Session->flash(); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php echo $this->fetch('content'); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php if (Configure::read('debug') >= 2) { ?>
                        <div class="alert alert-info">
                            <?php echo $this->element('sql_dump'); ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div id="footer">
            <div class="container">
                <div class="row section">
                    <div class="col-md-3">
                        <h4>Navigering</h4>
                        <ul class="list-unstyled">
                            <li><?php echo $this->Html->link('<i class="fa fa-thumbs-o-up"></i> Så här tycker partierna', array('controller' => 'questions', 'action' => 'index'), array('escape' => false)); ?></li>
                            <li><?php echo $this->Html->link('<i class="fa fa-tags"></i> Taggar', array('controller' => 'tags', 'action' => 'index'), array('escape' => false)); ?></li>
                            <li><?php echo $this->Html->link('<i class="fa fa-globe"></i> Partier', array('controller' => 'parties', 'action' => 'index'), array('escape' => false)); ?></li>
                            <li><?php echo $this->Html->link('<i class="fa fa-check-square-o"></i> Quiz', array('controller' => 'quizzes', 'action' => 'index'), array('escape' => false)); ?></li>
                            <li><?php echo $this->Html->link('<i class="fa fa-info-circle"></i> Om sidan', array('controller' => 'pages', 'action' => 'about'), array('escape' => false)); ?></li>
                            <li><?php echo $this->Html->link('<i class="fa fa-envelope"></i> Kontakt', array('controller' => 'pages', 'action' => 'contact'), array('escape' => false)); ?></li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <h4>Hjälp till</h4>
                        <ul class="list-unstyled">
                            <li><a data-toggle="modal" href="#feedbacksModal"><i class="fa fa-comments"></i> Skicka in feedback</a></li>
                            <li><a href="mailto:info@partisk.nu"><i class="fa fa-envelope"></i> Berätta vad du tycker</a></li>
                            <li><?php echo $this->Html->link('<i class="fa fa-user"></i> Ansök om konto', array('controller' => 'users', 'action' => 'login'), array('escape' => false)); ?></li>
                            <li><a href="https://github.com/rasmushaglund/Partisk" title="GitHub"><i class="fa fa-github"></i> Utveckla sidan</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <h4>Kontakt</h4>
                        <ul class="list-unstyled contact">
                            <li>
                                <p>
                                    <b>Allmänna frågor</b> <br />
                                    <a href="mailto:info@partisk.nu">info@partisk.nu</a>
                                </p>
                            </li>
                            <li>
                                <p><b>Media</b> <br />
                                    Rasmus Haglund <br />
                                    <a href="mailto:rasmus.haglund@partisk.nu">rasmus.haglund@partisk.nu</a> <br />
                                    072-570 32 43
                                </p>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-3 follow">
                        <h4>Följ oss</h4>
                        <a href="https://www.facebook.com/partisk.nu" title="Facebook"><i class="fa fa-facebook-square"></i></a>
                        <a href="https://twitter.com/partisknu" title="Twitter"><i class="fa fa-twitter-square"></i></a>
                        <a href="http://www.linkedin.com/company/5005133" title="LinkedIn"><i class="fa fa-linkedin-square"></i></a>
                        <a href="https://github.com/rasmushaglund/Partisk" title="GitHub"><i class="fa fa-github"></i></a>
                        </ul>
                    </div>
                </div>
                <div class="row info">
                    <div class="col-md-12">
                        <p><i class="fa fa-check-square"></i> Partisk.nu är skapat med kärlek 2013-2014.
                            Sidan bygger på <a href="http://sv.wikipedia.org/wiki/%C3%96ppen_k%C3%A4llkod">öppen källkod</a> och är licensierad under <a href="http://www.gnu.org/licenses/gpl-2.0.html">GPLv2</a>.
                    </div>
                </div>
            </div>
        </div>
        <?php echo $this->element('feedback'); ?>
        <div class="modal fade" id="parties-info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="myModalLabel">Information om partier</h4>
                </div>
                <div class="modal-body">
                    <h4>Synliga partier</h4>
                    <p>För att göra sidan enklare och inte visa för mycket information samtidigt visas endast partier som har fått minst 1% av de Svenska 
                        rösterna i det senaste EU-parlamentsvalet eller senaste riksdagsvalet.</p><br />
                    <h4>Sortering av partier</h4>
                    <p>Partierna är sorterade efter deras bästa resultat i senaste EU-parlementsvalet eller riksdagsvalet. Det partiet med
                       bäst resultat hamnar till vänster, och partiet med sämst resultat av de som visas hamnar till höger.</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Stäng</button>
                </div>
              </div>
            </div>
         </div>
    </body>

</html>
