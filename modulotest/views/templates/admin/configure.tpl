<form method='POST'>

    <div class='panel'>
        <div class='panel-heading'>
            <h3> {$titulo}</h3>
        </div>

        <div class='panel-body'>
            <h3> {$contenido}</h3>
            <label for='print'>Ingrese su texto de prueba</label>
            <input type='text' name='print' id='print' class='form-control'>
        </div>

        <div class='panel-footer'>
            <button type='submit' name='btnSubmit' class='btn btn-default pull-right'>
                <i class='process-icon-save'></i>
                Grabar
            </button>
        </div>
    </div>
</form>