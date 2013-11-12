<?php
/** 
 * User welcome page
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
 * @package     app.View.Users
 * @license     http://www.gnu.org/licenses/ GPLv2
 */
 ?>

<h1>Välkommen <?php echo $current_user['username'];?>!</h1>

<div class="row">
	<div class="col-md-6">
		<h2>Introduktion</h2>
		<p>Syftet med Partisk.nu är att skapa en objektiv databas över vad Sveriges partier tycker i olika frågor och göra allt tillgängligt på ett överskådligt sätt. Målet är att täcka de viktigaste frågorna och hålla svaren uppdaterade.</p>
		<p>Vi är alla partiska men målet är att hålla all information på sidan så objektiv som det bara går</p>

		<h2>Bakgrund</h2>
		<p>Under en lång tid har jag varit intresserad av politik och jag har ofta hört hur vänner och bekanta tycker att politik är svårt eller oåtkomligt. Jag har också fått höra att det är svårt och tidskrävande att ta reda på vad ett parti faktiskt tycker i vissa frågor. Detta har gjort mig motiverad att skapa denna sida och mitt mål är att göra Sveriges partiers åsikter tillgängliga för allmänheten.</p>

		<h2>Regler</h2>
		<p>För att kunna bygga upp denna sida och göra det till en viktig resurs inför valåret 2014 måste vi komma överens om ett antal regler. Att bidra till sidan är ingen rättighet och därför måste alla följa reglerna.</p>
		<ul>
		    <li>Låna inte ut dina inloggningsuppgifter till någon annan. Om kontot används för att förstöra stängs kontot av, oavsett anledning.</li>
		    <li>Låt inte en politisk agenda styra hur du formulerar frågor eller svar.</li>
		</ul>

		<h2>Ägandeskap</h2>
		<p>Jag vill vara noga med att poängtera att vi skapar denna sida tillsammans och ska kunna forma den som vi vill. Därför kommer alla som bidrar få tillgång till all data, och i framtiden även källkoden för hela systemet. </p>
		<h3>Data</h3>
		<p>Datan som läggs in på sidan ägs av alla vi som bidrar till sidan. Ni kan när som helst begära ut alla data som hör till sidan förutom saker som användaruppgifter, feedback och annan information som hör specifikt till Partisk.nu. För tillfället har endast de som hjälper till access till datan men när sidan lanseras kommer det finnas ett publikt api där vem som helst kan ta del av all data.</p>
		<h3>Källkod</h3>
		<p>Hela källkoden för Partisk.nu kommer att släppas fri under en fri licens (exampelvis GPL, MIT eller Apache) efter att sidan lanserats publikt. Detta betyder att alla som vill kan med hjälp av datan skapa en helt egen version av sidan. Anledningen till att källkoden inte släpps redan nu är att fokus ligger på att få igång sidan och se hur den tas emot av allmänheten. När sidan fungerar som vi vill och fungerar mer eller mindre av sig själv kan vi lägga ner energi på att </p>
		<h3>Övrigt</h3>
		<p>För tillfället äger jag som initiativtagare domänen Partisk.nu men jag är öppen för att en extern, oberoende part skulle kunna ta över den i framtiden.</p>

		<h2>Om Rasmus</h2>
		<p>Jag är en entreprenör/utvecklare som jobbar som IT-konsult i Uppsala. </p>
		<p>Rent ideologiskt har jag svårt att placera mig i ett fack. Jag har deltagit i 2 riksdagsval och 1 EU-val där jag röstat på 
		<?php echo $this->Html->link('Moderaterna', array('controller' => 'parties', 'action' => 'view', 2)); ?>, 
		<?php echo $this->Html->link('Folkpartiet', array('controller' => 'parties', 'action' => 'view', 3)); ?>, 
		<?php echo $this->Html->link('Piratpartiet', array('controller' => 'parties', 'action' => 'view', 4)); ?>, 
		<?php echo $this->Html->link('Vänsterpartiet', array('controller' => 'parties', 'action' => 'view', 7)); ?> och 
		<?php echo $this->Html->link('Socialdemokraterna', array('controller' => 'parties', 'action' => 'view', 1)); ?>. Alla är vi partiska, men jag hoppas att jag kan vara så oberoende som möjligt. Under det senaste året har jag engagerat mig i Piratpartiet i och med de integritetsfrågor som dykt upp under 2013.</p>
	</div>
</div>