<div class="modal fade" id="chat-dialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Chate&aacute; con nosotros</h4>
			</div>
			<div class="modal-body">
				<div class="col-md-4">
					<img alt="Telemarketer" src="img/telemarketer.png" />
				</div>
				<div class="col-md-8">
					Agreg&aacute; nuestro n&uacute;mero en tu lista de contactos y comenz&aacute; a chatear con un asesor.
					<p>
						<h3><?php echo $fabrica["Telefono"];?></h3>
					</p>
				</div>
				<div class="clearer"></div>
			</div>
			<div class="modal-footer" id="divBotones">
				<button type="button" class="btn btn-success" data-dismiss="modal" onclick="window.open('https://web.whatsapp.com/');">Abrir Chat</button>
			</div>
		</div>
	</div>
</div>	
