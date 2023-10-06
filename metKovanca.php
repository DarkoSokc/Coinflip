<html>
	<head>
		<title>Met kovanca</title>
	<style>
		
		/* CSS za barvo ozadja internetne strani */
		body {
			background-color: #8c8b8b;
		}
		
		/* CSS za obliko in velikost kjer se nahaja kovanec.(okvir kovanca) */
		.kovanec-container {
			display: flex;
			justify-content: left;
			margin-top: 50px;
		}
		
		/* CSS za obliko in velikost kjer se nahaja rezultat ko obrnemo kovanec. (okvir rezultata) */
		.rezultat-container {
			display: flex;
			align-items: center;
		}
		
		/* CSS velikost, barvo in pozicijo kovanca. */
		.kovanec {
			width: 100px;
			height: 100px;
			border-radius: 50%;
			background-color: #fcca28;
			position: relative;
			margin: 50px 50px;
		}
		
		/* CSS za barvo če za rezultat dobimo glavo kovanca. */
		.kovanec.glava {
			background-color: #fcca28;
		}
		
		/* CSS za barvo če za rezultat dobimo cifro kovanca. */
		.kovanec.cifra {
			background-color: #856b18;
		}
		
		/* CSS za velikost, obliko, in pozicijo izpisanega rezultata */
		#rezultat {
			text-align: top;
			font-size: 30px;
			font-weight: bold;
		}
		
		/* CSS za obliko pisave */
		p {
			font-weight: bold;
		}
	</style>
  </head>
  
	<body>
	
		<!-- Naslov in kratek opis programa -->
		<h1>Met kovanca</h1>
		<p>Igra je zamišljena tako, da če smo neodločeni med dvema stvarema zapišemo eno možnost v polje Glava in eno v polje Cifra,
		   program nato "vrže" kovanec za nas in izbere namesto nas.</p>
		
		<!-- div elementi za oblikovanje CSS-ja, če divu dodamo "class" odpremo možnost oblikovanja vsega par spada pod div tega class-a -->
		<div class="kovanec-container">
			<div id="kovanec" class="kovanec"></div>
			<div class="rezultat-container">
				<div class="kovanec-rezultat" id="rezultat"></div>
		<!-- Dvakratno zapiranje diva - eden za div class="kovanec-container" drugi pa za div class="rezultat-container" -->
			</div>
		</div>
		
		<br>
		<p>Tukaj vpišite med čem se odločate.</p>
		
		<!-- label je narejen da bi vedeli kaj moramo napisati v input za glavo. -->
		<label for="tekstGlava">Glava:</label>
		<input type="text" id="tekstGlava" placeholder="Napiši prvo izbiro">
		<br>
		<!-- label je narejen da bi vedeli kaj moramo napisati v input za cifro. -->
		<label for="tekstCifra">Cifra:</label>
		<input type="text" id="tekstCifra" placeholder="Napiši drugo izbiro">
		<br>
		
		<!-- Narejen gumb, ki na klik "vrže" kovanec. -->
		<button onclick="metKovanca()">Vrzi kovanec</button>
		
		<!-- Narejen gumb rezultat ki nam preko form methoda="post" submita oz. posreduje rezultat serverju. -->
		<form method="post" action="">
		<input type="hidden" name="rezultat" id="skritiRezultat">
		<button type="submit" name="submit" id="submit">REZULTAT</button>
		</form>
	
	    <script>
		
			/*
				Ime datoteke: 	metKovanca.php
				Avtor:			Darko Šokčević
				Vhodni podatki: Dve stvari med katerima smo neodločeni
				Opis:			Program, ki na podlagi dveh izbranih stvari (ki jih vstavimo v polja Glava in Cifra) "vrže" kovanec in odloči za nas
				Izhodni podatki:Izpis katera stran kovanca je zmagala in kaj smo imeli za to stran izbrano
			*/
		
			// Funkcija, ki simulira met kovanca in rezultat prikaže na ekranu.
			function metKovanca() {
				var kovanec = document.getElementById("kovanec");
				var rezultat = document.getElementById("rezultat");
				
				// Math.random generira naključno število od 0 do 1, Math.round pa to številko zaokroži na tisto katera je bližja 1 ali 0.
				var ceGlava = Math.round(Math.random());
        
       
				// ce je var ceGlava zaokrožen na 1 nam funkcija pokaže v rezultat tisto kar smo napisali v Glava:
				if (ceGlava == 1) {
					rezultat.innerHTML = document.getElementById("tekstGlava").value;
					kovanec.classList.add('Glava');
					kovanec.classList.remove('Cifra');
				// ce je var ceGlava zaokrožen na 0 nam funkcija pokaže v rezultat tisto kar je bilo zapisano v Cifra: 
				} else {
					rezultat.innerHTML = document.getElementById("tekstCifra").value;
					kovanec.classList.add('Cifra');
					kovanec.classList.remove('Glava');
				}
				
				// setTimeout nam nastavi da se funkcija izvaja po nekem določenem času. V temu primeru jo uporabljamo da nam omogoča uporabo submit gumba REZULTAT.
				setTimeout(function() {
         
					// Ta vrstica nam nastavi value skritiRezultat da je enak <div id="rezultat"></div>
					document.getElementById('skritiRezultat').value = rezultat.innerHTML;
					
					// Ta vrstica nam omogoča uporabo REZULTAT gumba(submit) in izpis končnega rezultata
					document.getElementById('submit').disabled = false;
				
				// Številka nam pove čez koliko časa se bo funkcija izvedla ob kliku na Rezultat.
				}, 0);
			}
		</script>
	

<?php
     
	 // Če je bil pritisnjen submit gumb oz. REZULTAT nam koda nastavi value iz javascripta glede na zmagovalca iz if funkcije(ceGlav) ==> rezultat.innerHTML.
      if(isset($_POST['submit'])) {
        $rezultat = $_POST['rezultat'];
        $izpisRezultata = "Rezultat meta kovanca je: " . $rezultat;
      }
	  // Nakoncu nam echo ta value tudi izpiše v formi paragrapha. 
      echo "<p>$izpisRezultata</p>";
	  
?>


<!-- integracija phpja nam dovoli izpolniti in "oddati" form in prikazati rezultat meta kovanca vse na isti strani, brez kakršnih koli dodatnih strani.
	HTML v moji aplikaciji služi kot osnovna struktura internetne strani oz. aplikacije, v <style>tagu stoji CSS koda za obliko in videz aplikacije, v <body>
	se nahaja vsebina aplikacije.
	CSS vsebuje vso obliko in videz aplikacije
	JavaScript vsebuje funkcijo metKovanca, ki z klikom prične z generiranjem naključne zaokrožene številke oz. 1 ali 0 preko var ceGlava dobi svoj končni rezultat.
	Ob rezultatu tudi spremeni svoj class v Glava ali Cifra da prepozna pravi rezultat.
	setTimeout služi kot zamik izvajanja rezultata ki med tem spremeni skritiRezultat v rezultat in omogoča gumbu REZULTAT poslati končni rezultat naprej
	PHP preveri ali je REZULTAT gumb bil pritisnjen in kaj je njegov value (skritiRezultat oz hidden input). Tega tudi potem prikaže v echo paragraphu. 
	preko echo je php integriran z HTMLjem da nam prikaže končni value $izpisRezultata.
-->


  </body>

</html>
