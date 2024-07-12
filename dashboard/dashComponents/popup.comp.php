<button class="btn btn-sm" data-toggle="modal" data-target="#popupcomunicado" id="btncomunicado"></button>
<!-- Modal Add UF-->
<div class="modal fade" id="popupcomunicado" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" id="closemodal" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <h3 class="text-center text-conecta pb-4"><b>COMUNICADO IMPORTANTE!</b></h3>
                    <p style="line-height: 1.5rem; font-size: small;" class="text-center">
                        <b>Produto CustomLIFE (Maxilares Atróficos)</b> agora possui um número de registro ANVISA. Importante atualizarem seu sistema de cotação com o novo código e Nº ANVISA.
                        <br>
                        <br>
                        <span class="bg-light-gray2 p-1 px-2">Em caso de dúvidas procurem pelo comercial CPMH.</span>
                    </p>

                    <div class="d-flex justify-content-center py-4">

                        <button type="button" class="btn btn-outline-conecta" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">Ciente</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.onload = function() {
        // Get the button element by its id
        var button = document.getElementById('btncomunicado');

        // Programmatically trigger a click on the button
        button.click();

    };
</script>