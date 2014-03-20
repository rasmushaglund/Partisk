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
            <h1>Om sidan</h1>
            <?php echo $this->element("share"); ?>
    </div>
</div>
<div class="row">
	<div class="col-md-6">
		<h2>Bakgrund</h2>
		<p>Sidan skapades för att göra Sveriges största partiers åsikter lättare att förstå.
                   Tjänsten drivs helt ideellt och målet är att fånga och visualisera de största partiernas viktigaste frågor på ett lätt sätt.
                   Vi vill fungera som en oberoende part som ständigt granskar partiernas åsikter.</p>
                
                <h2>Insamling av data</h2>
                <p>Data är i första hand insamlat från respektive partis hemsida eller partiprogram. Övrig data har hämtats från trovärdiga nyhetsartiklar
                och relevanta källor. För varje svar har vi noga gjort en bedömning på källans trovärdighet och innehåll. Vid motstridiga källor går
                vi alltid i första hand på vad partiet skriver på deras hemsida.</p>
                <p>Vid många svar har vi gjort en tolkning på vad som menas med en text och utifrån det försökt få fram ett ställningstagande.
                Detta kan leda till svar som inte stämmer överens med partiernas åsikter, men är tyvärr än så länge det enda sättet att göra det på.</p>

                <h2>Öppen källkod</h2>
                <p>Tjänsten drivs idag ideellt och koden är släppt som öppen källkod. Källkoden kan laddas ner på 
                    <a href ="https://github.com/rasmushaglund/Partisk">GitHub</a>. Data om tjänstens frågor, svar, partier och taggar kan hämtas
                    via <?php echo $this->Html->link('vårt API', array('controller' => 'api', 'action' => 'index')); ?>.</p>
                <p>Sidan bygger helt på öppen källkod och allt från operativsystem till webbserver drivs enbart av mjukvara med öppen kod.</p>
                <p>Målet är att skapa en tjänst som människor har nytta av, och om det innebär att någon annan tar tjänsten och gör den 
                    bättre har de vår välsignelse. Vi vill och uppmanar er att ta det vi gjort och göra bättre. Vi uppmanar er även att
                hjälpa till att forma denna tjänst så att ni får ut så mycket nytta av den som möjligt.</p>
              
                <h2>Kakor</h2>
                <p>Vi använder cookies (så kallade "kakor") på hemsidan. Denna används endast för att göra det möjligt för besökarna att
                    göra våra quiz på ett lätt sätt. Likt övriga delar av tjänsten är våra kakor bakade med mycket kärlek och omsorg.
        </div>
           <div class="col-md-6">     
		<h2>Personerna bakom tjänsten</h2>
                <p>Vi som varit med och hjälpt till att skapa denna tjänst är:</p>
                <ul class="list-unstyled credits">
                    <li>
                        <div class="alert alert-info">
                            <img src="img/rasmus.png" alt="Rasmus Haglund" class="img-thumbnail">
                            <b>Rasmus Haglund</b>
                            <p>Webbutvecklare, grundare Partisk.nu och entreprenör med stort intresse för politik.
                                Till vardags jobbar Rasmus som IT-konsult på <a href="http://egbs.se/">egbs consulting ab</a>.</p>
                            <p class="social"><a href="https://www.facebook.com/rasmus.haglund" title="Facebook"><i class="fa fa-facebook-square"></i></a>
                            <a href="https://twitter.com/rasmushaglund" title="Twitter"><i class="fa fa-twitter-square"></i></a>
                            <a href="https://plus.google.com/+RasmusHaglund" rel="publisher" title="Google+"><i class="fa fa-google-plus-square"></i></a>
                            <a href="http://www.linkedin.com/in/rasmushaglund" title="LinkedIn"><i class="fa fa-linkedin-square"></i></a>
                            <a href="https://github.com/rasmushaglund/" title="GitHub"><i class="fa fa-github"></i></a>
                            <a href="mailto:rasmus.haglund@partisk.nu" title="Mail"><i class="fa fa-envelope"></i></a></p>
                        </div>
                    </li>
                    <li>
                        <div class="alert alert-info">
                            <img src="img/rikard.png" alt="Rikard Nordström" class="img-thumbnail">
                            <b>Rikard Nordström</b>
                            <p>Studerande på nackademin, sharepointutveckling.</p>
                            <p class="social"><a href="https://www.facebook.com/rikard.nordstrom.7" title="Facebook"><i class="fa fa-facebook-square"></i></a>
                            <a href="http://www.linkedin.com/pub/rikard-nordstr%C3%B6m/83/807/213" title="LinkedIn"><i class="fa fa-linkedin-square"></i></a>
                            <a href="https://github.com/RikardNordstrom" title="GitHub"><i class="fa fa-github"></i></a></p>
                        </div>
                    </li>
                    <li>
                        <div class="alert alert-info">
                            <img src="img/johan.jpg" alt="Johan Gudmundsson" class="img-thumbnail">
                            <b>Johan Gudmundsson</b>
                            <p>Entreprenör med stort intresse för politik, integritetfrågor och IT. Till vardags jobbar Johan som konstruktör på ABB Power Transformers.</p>
                            <p class="social">
                            <a href="mailto:johan.gudmundsson2012@gmail.com" title="Mail"><i class="fa fa-envelope"></i></a></p>
                        </div>
                    </li>
                    <li>
                        <div class="alert alert-info">
                            <img src="img/emil.jpg" alt="Emil Wall" class="img-thumbnail">
                            <b>Emil Wall</b>
                            <p>Civ. ing. från Uppsala, arbetar som teknisk konsult på <a href="http://www.valtech.se">valtech</a>.</p>
                            <p class="social"><a href="https://www.facebook.com/erif89" title="Facebook"><i class="fa fa-facebook-square"></i></a>
                            <a href="https://twitter.com/erif89" title="Twitter"><i class="fa fa-twitter-square"></i></a>
                            <a href="https://plus.google.com/+EmilWall" rel="publisher" title="Google+"><i class="fa fa-google-plus-square"></i></a>
                            <a href="http://www.linkedin.com/pub/emil-wall/56/779/633/" title="LinkedIn"><i class="fa fa-linkedin-square"></i></a>
                            <a href="https://github.com/emilwall" title="GitHub"><i class="fa fa-github"></i></a></p>
                        </div>
                    </li>
                   <li>
                        <div class="alert alert-info">
                            <img src="img/kristoffer.jpg" alt="Kristoffer Bjelkmark" class="img-thumbnail">
                            <b>Kristoffer Bjelkmark</b>
                            <p>Studerande på Nackademin YH, Sharepointutveckling.</p>
                            <p class="social"><a href="https://www.facebook.com/Poffn" title="Facebook"><i class="fa fa-facebook-square"></i></a>
                            <a href="https://plus.google.com/u/0/109899012980016136654" title="Google+"><i class="fa fa-google-plus-square"></i></a>
                            <a href="http://www.linkedin.com/profile/view?id=293245801" title="LinkedIn"><i class="fa fa-linkedin-square"></i></a>
                            <a href="https://github.com/poffn/" title="GitHub"><i class="fa fa-github"></i></a></p>
                        </div>
                    </li>
                   <li>
                        <div class="alert alert-info">
                            <img src="img/sara.jpg" alt="Sara Klasson" class="img-thumbnail">
                            <b>Sara Klasson</b>
                            <p>Retorikstuderande vid Uppsala universitet med intresse för politik och kommunikation.</p>
                        </div>
                    </li>
                </ul>
	</div>
</div>