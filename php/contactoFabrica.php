<div class="modal fade" id="contactoFabrica-dialog" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">CONSULT&Aacute; CON EL FABRICANTE</h4>
			</div>
			<form class="form-horizontal" id="contacto-form" data-dialog="#contactoFabrica-dialog">
				<input type="hidden" id="para" value="<?php echo $fabrica["Email"]?>" />
				<div class="modal-body">
						<div class="form-group">
							<label for="nombre" class="control-label col-md-2">Nombre:</label>
							<div class="col-md-4">
								<input type="text" class="form-control" id="nombre" required />
							</div>
						</div>
						<div class="form-group">
							<label for="apellido" class="control-label col-md-2">Apellido:</label>
							<div class="col-md-4">
								<input type="text" class="form-control" id="apellido" required />
							</div>
						</div>			
						<div class="form-group">
							<label for="telefono" class="control-label col-md-2">Tel&eacute;fono:</label>
							<div class="col-md-7">
								<input type="text" class="form-control" id="telefono" required />
							</div>
						</div>
						<div class="form-group">
							<label for="email" class="control-label col-md-2">E-mail:</label>
							<div class="col-md-7">
								<input type="email" class="form-control" id="email" required />
							</div>
						</div>			
						<div class="form-group">
							<label for="mensaje" class="control-label col-md-2">Mensaje:</label>
							<div class="col-md-7">
								<textarea class="form-control" id="mensaje" required></textarea>
							</div>
						</div>
						<div class="row">
							<div class="col-md-7 col-md-offset-2">
								<div class="g-recaptcha" data-sitekey="6Len-1AUAAAAADfipZg2YNG4H-CwroqKqxs78aZa"></div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-7 col-md-offset-2">
								<div id="divMsjContacto" class="divMsj alert alert-danger" role="alert">
									<span id="txtHint"></span>
								</div>
							</div>
						</div>
				</div>
				<div class="modal-footer" id="divBotones">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-danger">Enviar</button>
				</div>
			</form>
		</div>
	</div>
</div>