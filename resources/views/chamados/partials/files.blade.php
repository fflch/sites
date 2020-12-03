<br>
<b>Enviar arquivo:</b>
<form method="post" enctype="multipart/form-data" action="/files_chamados">
@csrf
<input type="hidden" name="chamado_id" value="{{ $chamado->id }}">
<input type="file" name="file_chamado">
<button type="submit" class="btn btn-success">Enviar</button>
</form>