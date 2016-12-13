<div class="frmBusqueda">
	<h3 style="margin: 10px 0; color: white;">Seleccione entre 1 o más variables para encontrar su vivienda soñada</h3>
	<form id="busqueda-form" method="post" action="resultados.php" class="form-inline">
		<select name="CantHabi" id="busq-canthabi" class="form-control">
			<option value="" selected>Dormitorios</option>
			<option value="1">1 Dormitorio</option>
			<option value="2">2 Dormitorios</option>
			<option value="3">3 Dormitorios o m&aacute;s</option>
		</select>
		<select name="Precio" id="busq-precio" class="form-control">
			<option value="" selected>Precio</option>
			<option value="1">$50mil a $100mil</option>
			<option value="2">$100mil a $150mil</option>
			<option value="3">$150mil a $200mil</option>
			<option value="4">M&aacute;s de $200mil</option>
		</select>
		<span class="dropdown">
			<button class="btn btn-default dropdown-toggle" type="button" id="busq-adicionales" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
				Adicionales
				<span class="caret" style="float:right; margin-top: 8px;"></span>
			</button>
			<ul class="dropdown-menu cmbAdicionales" aria-labelledby="busq-adicionales">
				<li><input name="chkBano" id="chkBano" type="checkbox" class="clickable" style="margin-left: 5px;"> Ba&ntilde;o</li>
				<li><input name="chkGriferia" id="chkGriferia" type="checkbox" class="clickable" style="margin-left: 5px;"> Grifer&iacute;a</li>
				<li><input name="chkPinturaExt" id="chkPinturaExt" type="checkbox" class="clickable" style="margin-left: 5px;"> Pintura exterior</li>
				<li><input name="chkPinturaInt" id="chkPinturaInt" type="checkbox" class="clickable" style="margin-left: 5px;"> Pintura interior</li>
				<li><input name="chkBacha" id="chkBacha" type="checkbox" class="clickable" style="margin-left: 5px;"> Bacha</li>
				<li><input name="chkMesada" id="chkMesada" type="checkbox" class="clickable" style="margin-left: 5px;"> Mesada</li>
				<li><input name="chkBajoMesada" id="chkBajoMesada" type="checkbox" class="clickable" style="margin-left: 5px;"> Bajo mesada</li>
				<li><input name="chkAlacena" id="chkAlacena" type="checkbox" class="clickable" style="margin-left: 5px;"> Alacena</li>
				<li><input name="chkTanqueAgua" id="chkTanqueAgua" type="checkbox" class="clickable" style="margin-left: 5px;"> Tanque de agua</li>
				<li><input name="chkElectrico" id="chkElectrico" type="checkbox" class="clickable" style="margin-left: 5px;"> Kit el&eacute;ctrico</li>
			</ul>
		</span>
		<button type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Buscar</button>
	</form>
</div>