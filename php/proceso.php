<div class="modal fade" id="proceso-dialog" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"><?php echo $tipologia["NombTipo"]?> - $<?php echo $tipologia["Precio"]?></h4>
			</div>
			<div class="modal-body">
				<input type="hidden" id="hdnPaso" value=""/>
				<input type="hidden" id="hdnNumeTipo" value="<?php echo $tipologia["NumeTipo"];?>"/>
				<input type="hidden" id="hdnAdicionales" value=""/>
				<input type="hidden" id="hdnTipoCoti" value="1"/>
				<input type="hidden" id="hdnTipoFin" value="1"/>
				<input type="hidden" id="hdnLatLngFabrica" value="<?php echo $fabrica["LatLng"];?>"/>
				
				<div class="row paso" id="paso-0" style="display:none;">
					<div class="col-md-3">
						<div class="proceso-titulo">
							<img alt="" src="img/paso-1.png" style="width: 100%; height: auto;">
						</div>
						<div class="clearer"></div>
					</div>
					<div class="col-md-9 proceso-texto">
						<h3 class="fontAbel">Seleccion&aacute; la tipolog&iacute;a</h3>
						
						<?php
							$strSQL = "SELECT NumeTipo, NombTipo, Imagen, Premium,";
							$strSQL.= " chkBano, chkGriferia, chkPinturaExt, chkPinturaInt, chkBacha, chkMesada, chkBajoMesada,";
							$strSQL.= " chkAlacena, chkTanqueAgua, chkElectrico, Opcionales, Precio, Entrega, Porcentaje, CantCuotas, Financiacion";
							$strSQL.= " FROM tipologias t";
							$strSQL.= " WHERE NumeFabr = {$fabrica["NumeFabr"]}";
							
							$tipologias = cargarTabla($strSQL);
							$strSalida = "";
							$I = 0;
							$strSalida.= $crlf.'<div class="row row-eq-height">';
							while ($fila = $tipologias->fetch_array()) {
								if ($I == 3) {
									$I = 0;
									$strSalida.= $crlf.'</div>';
									$strSalida.= $crlf.'<div class="row row-eq-height">';
								}
								$strSalida.= $crlf.'<div class="col-md-4 txtCenter clickable tipologia" data-js="selecTipo('. $fila["NumeTipo"] .');">';
								
								//Cargo los adicionales
								$strSalida.= $crlf.'<input type="hidden" id="adicionales'.$fila["NumeTipo"].'" value="';
								if ($fila["chkBano"]) $strSalida.= '#chkBano#';
								if ($fila["chkGriferia"]) $strSalida.= '#chkGriferia#';
								if ($fila["chkPinturaExt"]) $strSalida.= '#chkPinturaExt#';
								if ($fila["chkPinturaInt"]) $strSalida.= '#chkPinturaInt#';
								if ($fila["chkBacha"]) $strSalida.= '#chkBacha#';
								if ($fila["chkMesada"]) $strSalida.= '#chkMesada#';
								if ($fila["chkBajoMesada"]) $strSalida.= '#chkBajoMesada#';
								if ($fila["chkAlacena"]) $strSalida.= '#chkAlacena#';
								if ($fila["chkTanqueAgua"]) $strSalida.= '#chkTanqueAgua#';
								if ($fila["chkElectrico"]) $strSalida.= '#chkElectrico#';
								$strSalida.= '" />';
								
								$strSalida.= $crlf.'<input type="hidden" id="opcionales'.$fila["NumeTipo"].'" value="'.$fila["Opcionales"].'" />';

								$strSalida.= $crlf.'<input type="hidden" id="precio'.$fila["NumeTipo"].'" value="'.$fila["Precio"].'" />';
								$strSalida.= $crlf.'<input type="hidden" id="entrega'.$fila["NumeTipo"].'" value="'.$fila["Entrega"].'" />';
								$strSalida.= $crlf.'<input type="hidden" id="porcentaje'.$fila["NumeTipo"].'" value="'.$fila["Porcentaje"].'" />';
								$strSalida.= $crlf.'<input type="hidden" id="cantcuotas'.$fila["NumeTipo"].'" value="'.$fila["CantCuotas"].'" />';
								$strSalida.= $crlf.'<input type="hidden" id="financiacion'.$fila["NumeTipo"].'" value="'.$fila["Financiacion"].'" />';
								
								$strSalida.= $crlf.'<div class="imgTipologia" style="background: url(\'admin/'. $fila["Imagen"] . '\') center center/cover no-repeat;"></div>';
								
								$strSalida.= $crlf.'<span class="fa-stack fa-lg check ';
								if ($fila["NumeTipo"] != $tipologia["NumeTipo"])
									$strSalida.= 'oculto';
								
								$strSalida.= '" id="check-'. $fila["NumeTipo"] .'">';
								$strSalida.= $crlf.'<i class="fa fa-circle fa-stack-2x"></i>';
								$strSalida.= $crlf.'<i class="fa fa-check fa-stack-1x fa-inverse"></i>';
								$strSalida.= $crlf.'</span>';

								$strSalida.= $crlf.'<div class="floatLeft" style="margin: 10px 0;">$ '.$fila["Precio"].'</div>';
								if ($fila["Premium"] == "1") {
									$strSalida.= $crlf.'<div class="floatRight" style="margin: 10px 0;">Premium <i class="fa fa-star"></i></div>';
								}
								
								$strSalida.= $crlf.'<div class="clearer"></div>';
								$strSalida.= $crlf.'<div class="cuadroNegro">';
								$strSalida.= $fila["NombTipo"];
								$strSalida.= '</div>';
								$strSalida.= $crlf.'</div>';
								$I++;
							}
							$strSalida.= $crlf.'</div>';
								
							if (isset($tipologias)) { 
								$tipologias->free();
							}
							echo $strSalida;
						?>					
						<div class="row">
							<h3 class="fontAbel">Adicionales</h3>
							<?php
								$strSalida = '<div class="col-md-6">';
									
								$strSalida.= '<div id="chkBano" class="fontAbel clickable adicional oculto" data-js="selectAdi(\'chkBano\');"><i class="fa fa-times fa-fw"></i> <span>Ba&ntilde;o</span></div>';
								$strSalida.= '<div id="chkGriferia" class="fontAbel clickable adicional oculto" data-js="selectAdi(\'chkGriferia\');"><i class="fa fa-times fa-fw"></i> <span>Grifer&iacute;a</span></div>';
								$strSalida.= '<div id="chkPinturaExt" class="fontAbel clickable adicional oculto" data-js="selectAdi(\'chkPinturaExt\');"><i class="fa fa-times fa-fw"></i> <span>Pintura exterior</span></div>';
								$strSalida.= '<div id="chkPinturaInt" class="fontAbel clickable adicional oculto" data-js="selectAdi(\'chkPinturaInt\');"><i class="fa fa-times fa-fw"></i> <span>Pintura interior</span></div>';
								$strSalida.= '<div id="chkBacha" class="fontAbel clickable adicional oculto" data-js="selectAdi(\'chkBacha\');"><i class="fa fa-times fa-fw"></i> <span>Bacha</span></div>';

								$strSalida.= '</div>';
								$strSalida.= '<div class="col-md-6">';

								$strSalida.= '<div id="chkMesada" class="fontAbel clickable adicional oculto" data-js="selectAdi(\'chkMesada\');"><i class="fa fa-times fa-fw"></i> <span>Mesada</span></div>';
								$strSalida.= '<div id="chkBajoMesada" class="fontAbel clickable adicional oculto" data-js="selectAdi(\'chkBajoMesada\');"><i class="fa fa-times fa-fw"></i> <span>Bajo mesada</span></div>';
								$strSalida.= '<div id="chkAlacena" class="fontAbel clickable adicional oculto" data-js="selectAdi(\'chkAlacena\');"><i class="fa fa-times fa-fw"></i> <span>Alacena</span></div>';
								$strSalida.= '<div id="chkTanqueAgua" class="fontAbel clickable adicional oculto" data-js="selectAdi(\'chkTanqueAgua\');"><i class="fa fa-times fa-fw"></i> <span>Tanque de agua</span></div>';
								$strSalida.= '<div id="chkElectrico" class="fontAbel clickable adicional oculto" data-js="selectAdi(\'chkElectrico\');"><i class="fa fa-times fa-fw"></i> <span>Kit el&eacute;ctrico</span></div>';
								
								$strSalida.= '</div>';
								
								$strSalida.= '<div class="col-md-12">';
								$strSalida.= '<div id="chkOpcionales" class="fontAbel clickable adicional" data-js="selectAdi(\'chkOpcionales\');"><i class="fa fa-times fa-fw"></i> <span>'.$tipologia["Opcionales"].'</span></div>';
								$strSalida.= '</div>';
								
								echo $strSalida;
							?>
						</div>		
					</div>
				</div>
				
				<div class="row paso" id="paso-1">
					<div class="col-md-3">
						<div class="proceso-titulo">
							<img alt="" src="img/paso-2.png" style="width: 100%; height: auto;">
						</div>
						<div class="clearer"></div>
					</div>
					<div class="col-md-9 proceso-texto">
						<h3 class="fontAbel">Seleccion&aacute; tu m&eacute;todo de compra</h3>
						<div class="row">
							<div class="marginTop20 fontAbel clickable" data-js="selectCoti(1);">
								<span class="fa-stack optCoti optCotiActivo" id="optCoti-1">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-check fa-stack-1x fa-inverse"></i>
								</span>
								<span class="txtBig txtBold rojo">Compra Directa</span>
							</div>
							<div id="optFinanciacion" class="marginTop20 fontAbel clickable" data-js="selectCoti(2);" style="<?php echo ($tipologia["Financiacion"] != "1")?"display: none;":" "?>">
								<span class="fa-stack optCoti" id="optCoti-2">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-check fa-stack-1x fa-inverse"></i>
								</span>
								<span class="txtBig txtBold rojo">Financiaci&oacute;n</span>
								<div id="optCotiText-2" class="optCotiText">
									<form class="form-horizontal">
										<input type="hidden" id="precio" value="<?php echo $tipologia["Precio"]?>" />
										<input type="hidden" id="porcentaje" value="<?php echo $tipologia["Porcentaje"]?>" />
										
										<div class="form-group">
											<label for="entrega" class="control-label col-md-3">Entrega inicial:</label>
											<div class="col-md-4">
												<input type="number" class="form-control" id="entrega" min="<?php echo $tipologia["Entrega"]?>" /> (M&iacute;nimo $ <?php echo $tipologia["Entrega"]?>)
											</div>
										</div>
										<div class="form-group">
											<label for="cantcuotas" class="control-label col-md-3">Cant. de cuotas:</label>
											<div class="col-md-4">
												<input type="number" class="form-control" id="cantcuotas" /> (M&aacute;ximo <span id="maxcantcuotas"><?php echo $tipologia["CantCuotas"]?></span>)
											</div>
											<div class="col-md-4">
												<button class="btn btn-default" id="btnCalcularCuota">Calcular monto cuota</button>
											</div>
										</div>
										<div class="form-group">
											<label for="impocuota" class="control-label col-md-3">Importe de la cuota:</label>
											<div class="col-md-4">
												<input type="number" class="form-control" id="impocuota" readonly />
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-12" id="txtError" style="color: red;"></div>
										</div>
									</form>
								</div>
								<div class="clearer"></div>
							</div>
							<div class="marginTop20 fontAbel clickable" data-js="selectCoti(3);">
								<span class="fa-stack optCoti" id="optCoti-3">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-check fa-stack-1x fa-inverse"></i>
								</span>
								<span class="txtBig">Plan a medida</span>
								<div id="optCotiText-3" class="optCotiText">
									Usted podra armar su plan a medida haciendo aportes m&iacute;nimos 
									mensuales, para mayor informaci&oacute;n, un asesor se comunicar&aacute; 
									con Usted.
								</div>
								<div class="clearer"></div>
							</div>
						</div>
						<h3 class="fontAbel">Us&aacute; el mapa para seleccionar la ubicaci&oacute;n y el costo del traslado</h3>
						<div class="row">
							<div class="col-md-8" style="padding-left: 0;">
								<div>
									<input type="hidden" id="latlng" />
									<input type="hidden" id="distancia" />
									<input type="hidden" id="preciokm" value="<?php echo $fabrica["PrecioKm"]?>" />
									<input type="text" class="form-control" id="buscar" placeholder="Ingrese localidad" />
								</div>
							</div>
							<div class="col-md-2">
								<button class="btn btn-default" id="btnBuscar">Buscar</button>
							</div>
						</div>
						<div class="row">
							<div id="map" style="height: 300px;"></div>
							<div id="txtDistancia"></div>
							<div id="txtFlete"></div>
						</div>
					</div>
				</div>
				<div class="row paso oculto" id="paso-2">
					<div class="col-md-3">
						<div class="proceso-titulo">
							<img alt="" src="img/paso-4.png" style="width: 100%; height: auto;">
						</div>
						<div class="clearer"></div>
					</div>
					<div class="col-md-9 proceso-texto">
						<h3 class="fontAbel">Dejanos tus datos</h3>
						<div class="row">
							<div class="col-md-8 cuadroNegro">
								<div class="txtBig">Usá tu cuenta de Facebook</div>
								<div class="fb-login-button" data-max-rows="1"onlogin="checkLoginState();"  data-size="large" data-show-faces="true" data-auto-logout-link="true"></div>
								<br><br>
							</div>
						</div>
						<div class="row">
							<div class="col-md-8 cuadroNegro">
								<div class="txtBig">Complet&aacute; tus datos y nuestros asesores se contactar&aacute;n a la brevedad</div>
								<br>
								<div><input type="text" id="nombre" class="form-control" placeholder="Nombre" /></div>
								<br>
								<div><input type="tel" id="telefono" class="form-control" placeholder="Tel&eacute;fono" required /></div>
								<br>
								<div><input type="email" id="email" class="form-control" placeholder="E-mail" /></div>
								<br>
								<div class="form-group">
									<label for="dispone">Dispone de:</label>
									<select class="form-control" id="dispone" required>
										<option>NADA</option>
										<option>AUTO USADO</option>
										<option>ANTICIPO</option>
										<option>TERRENO</option>
										<option>PROPIEDAD</option>
									</select>
								</div>			
								
								<div class="col-md-6" style="padding:0 8px 0 0;">
									<div class="form-group">
										<label for="horadesde">Horario de contacto:</label>
										<select class="form-control" id="horadesde" required>
											<option selected="selected">09 hs</option>
											<option>10 hs</option>
											<option>11 hs</option>
											<option>12 hs</option>
											<option>13 hs</option>
											<option>14 hs</option>
											<option>15 hs</option>
											<option>16 hs</option>
											<option>17 hs</option>
											<option>18 hs</option>
											<option>19 hs</option>
											<option>20 hs</option>
										</select>
									</div>
								</div>
								<div class="col-md-6" style="padding:0 0 0 8px;">
									<div class="form-group">
										<select class="form-control" id="horahasta" style="margin-top:25px;" required>
											<option>09 hs</option>
											<option>10 hs</option>
											<option>11 hs</option>
											<option>12 hs</option>
											<option>13 hs</option>
											<option>14 hs</option>
											<option>15 hs</option>
											<option>16 hs</option>
											<option>17 hs</option>
											<option>18 hs</option>
											<option>19 hs</option>
											<option selected="selected">20 hs</option>
										</select>
									</div>			
								</div>
								
							</div>
						</div>
					</div>
				</div>
				<div class="row paso oculto" id="paso-3">
					<div class="col-md-3">
						<div class="proceso-titulo">
							<img alt="" src="img/paso-5.png" style="width: 100%; height: auto;">
						</div>
						<div class="clearer"></div>
					</div>
					<div class="col-md-9 proceso-texto">
						<h3 class="fontAbel">Decid&iacute; como seguir</h3>
						<div class="row">
							<div class="marginTop40 txtBig fontAbel clickable" data-js="selectFin(1);">
								<div class="col-md-2">
								<span class="fa-stack fa-lg optFin optFinActivo" id="optFin-1">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-check fa-stack-1x fa-inverse"></i>
								</span>
								</div>
								<div class="col-md-6" style="padding: 10px 0;">Guardar</div>
								<div class="clearer"></div>
							</div>
							<div class="marginTop40 txtBig fontAbel clickable" data-js="selectFin(2);">
								<div class="col-md-2">
								<span class="fa-stack fa-lg optFin" id="optFin-2">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-check fa-stack-1x fa-inverse"></i>
								</span>
								</div>
								<div class="col-md-6" style="padding: 10px 0;">Imprimir</div>
								<div class="clearer"></div>
							</div>
							<div class="marginTop40">
								<button class="btn btn-success btnblink" onclick="window.open('https://web.whatsapp.com/');"><i class="fa fa-whatsapp" aria-hidden="true"></i> Chatear ahora con un Vendedor</button>
								<br><br>
								(Agendá en tu teléfono el siguiente número <?php echo $fabrica["Telefono"];?>)
							</div>

							<div id="divMsjCoti" class="marginTop40 alert alert-danger alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<span id="txtHintCoti">Info</span>
							</div>

							<div class="marginTop40">
								Al finalizar con el proceso Usted acepta los <a href="<?php echo $raiz ?>terminos.php" target="_blank">T&eacute;rminos y Condiciones</a> del portal.
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer" id="divBotones">
				<button class="btn btn-default oculto" id="btnAtras">Atr&aacute;s</button>
				<button class="btn btn-danger" id="btnSiguiente" data-fin="0">Siguiente</button>
			</div>
		</div>
	</div>
</div>