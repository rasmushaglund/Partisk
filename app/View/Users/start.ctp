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
 ?>

<h1>Välkommen <?php echo $user['fullname'];?>!</h1>

<div class="row">
	<div class="col-md-6">
		<h2>Introduktion</h2>
		<p>Vad roligt att du vill hjälpa till att göra Sveriges politik lättare att förstå! Om du ser att det saknas information eller om någonting
                är oklart hör av dig till oss så ska vi göra allt för att hjälpa till. Vi vill att vi alla lämnar våra politiska övertygelser åt sidan
                här och försöker skapa en så objektiv bild som möjligt. Alla är vi partiska men vi kan alla göra vårt bästa.</p>
                <p><b>Vi</b> skapar denna tjänst <b>tillsammans</b>. Detta handlar inte om att vi ska bli kända eller om att tjäna pengar
                    utan vi vill faktiskt göra världen (i detta fall Sverige) lite bättre. </p>
                <p>Idag står jag, Rasmus, som ägare av domän och server men om det
                    i framtiden skulle visa sig att en annan, kanske mer oberoende part vill driva tjänsten är jag öppen för det. Min motivation är
                    att jag själv vill ha tillgång till tjänsten och att det är roligt.</p>

		<h2>Regler</h2>
		<p>För att kunna bygga upp denna sida och göra det till en viktig resurs inför valåret 2014 måste vi komma överens om ett antal regler. 
                    Att bidra till sidan är ingen rättighet och för att få möjlighet till att göra det måste alla följa reglerna.</p>
		<ul>
		    <li>Låna inte ut dina inloggningsuppgifter till någon annan. Om kontot används för att förstöra stängs kontot av, oavsett anledning.</li>
		    <li>Låt inte en politisk agenda styra hur du formulerar frågor eller svar. </li>
		</ul>
                
                <h2>Frågor</h2>
                <p>De flesta frågor är skrivna som ett påstående. Detta för att inte alla frågor ska börja på samma sätt, t ex med "Ska". 
                   Frågorna bör inte vara för långa och bör inte heller ha invecklade negationer eller liknande. Försök att hålla frågorna
                   relativt enkla och skriv istället en förklarande text till frågan.</p>
                
                
                <h2>Svar</h2>
                <p>Idag stödjs endast svar på formen ja/nej. Det finns inget "kanske" eller "ja, men...". Det kan tänkas att det kommer fler alternativ i 
                   framtiden, men för att göra allt enklare är det löst så idag.</p>
                <p>Varje svar måste ha en källa och alla svar ska ha ett citat eller en sammanfattning av källan. Sammanfattningens uppgift är att
                   visa partiets åsikt i frågan utan att besökaren ska behöva gå in på källan och läsa vad som egentligen är skrivet.</p>
                <p>En viktig sak att tänka på är att detta inte är en avhandlig eller ett vetenskapligt verk. Partiet behöver inte explicit sagt ja/nej
                   för att vi ska lägga in ett svar. Om man förstår av texten att ett parti tycker på ett visst sätt så skriver vi det. Utifall de 
                   inte håller med om att de har den åsikten får de hänvisa till andra källor som styrker deras egentliga åsikt.</p>
                <p><b>Exempel:</b> På frågan om Centerpartiet vill att barnkonventionen blir en Svensk lag svarar de: </p>
                <p><i>"Centerpartiet menar att 
                        barnkonventionen ska vara den naturliga utgångspunkten i allt arbete som rör barn men att den bästa metoden, än så länge, 
                        är en anpassning och skärpning av de svenska lagarna d.v.s. den nuvarande transformeringsmetoden."</i></p>
                        <p>Där skriver de att den bästa lösningen är att skärpa befintliga lagar, och säger alltså implicit <b>nej</b> på 
                        frågan att göra barnkonvantionen till Svensk lag.</p>
                
                <h2>Rättigheter</h2>
                <p>En vanlig användare (contributor) kan skapa frågor och svar, samt ändra och ta bort allt användaren skapat så länge innehållet ännu inte
                    blivit godkänt. En contributor kan ej lägga till taggar samt skapa/ändra partier/användare.</p>
                <p>Moderatorernas uppgift är att godkänna vilka frågor och svar som ska synas för de som ej är inloggade. De granskar alltså alla frågor
                    och svar innan de skickas ut till alla. De kan även ändra allas frågor/svar och lägga till/ta bort taggar.</p>
                <p>En administratör kan göra allt, kort och gott. Administratören lägger till och godkänner partier och användare.</p>
              
		<h2>Ägandeskap</h2>
		<p>Vi vill vara noga med att poängtera att vi skapar denna sida tillsammans och ska kunna forma den som vi vill. 
                    Därför kommer alla som bidrar få tillgång till all data och källkoden för hela systemet. </p>
		<p>Ni kan läsa mer om sidans öppna källkod och data 
                    <?php echo $this->Html->link('här', array('controller' => 'pages', 'action' => 'about')); ?>.</p>
 	</div>
        <div class="col-md-6">
            <h3>Användare som väntar på att godkännas</h3>
            
            <h3>Svar som väntar på att godkännas</h3>
            
            <h3>Frågor som väntar på att godkännas</h3>
        </div>
</div>